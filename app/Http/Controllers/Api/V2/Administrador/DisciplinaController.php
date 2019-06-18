<?php

namespace  App\Http\Controllers\Api\V2\Administrador;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\V2\VueCrudController;   
use App\Models\Administrador\Disciplina; 
use Yajra\DataTables\DataTables;
use Validator;
use Auth;


class DisciplinaController extends VueCrudController
{


    public function __construct( Disciplina $disciplina , DataTables $dataTable ){
        $this->model = $disciplina ;
        $this->dataTable = $dataTable ; 
        $this->route = 'disciplina';

        $this->middleware('auth:api', ['except' => ['BuscarTodos' ] ]);

        $this->middleware('permissao:disciplina')->except('BuscarTodos');
        $this->middleware('permissao:disciplina-editar')->only('update');
        $this->middleware('perfil:Admin')->only( 'destroy');       
    }




    /**
    * Busca todos registros de um model 
    *
    * @param Request $request
    *
    * @return $model
    */
    public function  BuscarTodos( Request $request  ){
        $model = null ;
        if( Auth::guard('api')->user() && Auth::guard('api')->user()->can('DisciplinaNivelRestrita') ){
            $model =  $this->model->select('id' , 'nome')->orderBy('nome' , 'asc')->get();
        }
        else if( Auth::user() && Auth::user()->can('DisciplinaNivelRestrita') ){
            $model =  $this->model->select('id' , 'nome')->orderBy('nome' , 'asc')->get();
        }
        else{
           $model =  $this->model->where('nivel' , 'Validada')->select('id' , 'nome')->orderBy('nome' , 'asc')->get();
       }
       return response()->json( $model , 200); 
   }








    /**
    * Função para ativar um usuario ja existente  
    *
    * @param Request $request
    *  
    * @param int  $id
    *    
    * @return void
    */
    public function  Ativar( Request $request , $disciplinaId ){
        if(!$model = $this->model->withTrashed()->find($disciplinaId) ){
            return response()->json( 'Item não encontrado' , 404); 
        }
        $model->restore(); 
        foreach ( $model->assuntos()->withTrashed()->get() as $assunto ) {
            $assunto->restore();
        } 
        return response()->json(  'Ativado' , 200 );
    }





    /**
    * Função para excluir um model
    *
    * @param Request $request
    *   
    * @param int  $id
    *    
    * @return json
    */
    public function destroy( Request $request, $id)
    { 
        try{  
            if( $model = $this->model->find($id) ){
                foreach ( $model->assuntos as $assunto ) {
                    $assunto->delete();
                } 
                if( !$delete = $model->delete() ){
                    return response()->json([ 'message' => 'Erro ao excluir o registro!' ], 500);
                }
                return response()->json( 'Exclusão realizada com sucesso' , 200);  
            }
            if( $model = $this->model->onlyTrashed()->find($id)){
                if( !$delete = $model->forceDelete() ){
                    return response()->json([ 'message' => 'Erro ao excluir o registro!' ], 500);
                }
                return response()->json( 'Exclusão realizada com sucesso' , 200);  
            }
            return response()->json( 'Item não encontrado' , 404); 
        } 
        catch(QueryException $e){
            return response()->json([ 'message' => 'Erro de conexao com o banco' ] , 500 );
        } 
        catch(Exception $e){
            return response()->json([ 'message' => $e->getMessage() ], 500);
        }  
    }







    /**
    * Função para buscar models para datatable
    *
    * @param Request $request
    *   
    * @return json
    */
    public function getDatatable( Request $request ){
        try {  
            $models = $this->model->getDatatable();
            return $this->dataTable->eloquent($models)
            ->addColumn('action', function($linha) { 
                if($linha->status === 'Inativo'){
                    return '<button data-id="'.$linha->id.'" btn-ativar class="btn btn-success btn-sm" title="Ativar"><i class="fa  fa-thumbs-up"></i></button>' 
                    .'<button data-id="'.$linha->id.'" btn-excluir class="btn btn-danger btn-sm" title="Excluir Definitivamente"><i class="fa fa-trash"></i></button>';

                } 
                return 
                '<a href="#/'. $this->route . '/'.$linha->id.'/assuntos" class="btn btn-info btn-sm" title="Assuntos"><i class="fa fa-comments"></i></a>'
                .'<a href="#/'. $this->route . '/edit/'.$linha->id.'" class="btn btn-success btn-sm" title="Editar"><i class="fa fa-pencil"></i></a>'
                .'<button data-id="'.$linha->id.'" btn-desativar class="btn btn-danger btn-sm" title="Desativar"><i class="fa fa-thumbs-down"></i></button>';
            })
            ->setRowClass(function ($linha) {
                return $linha->status === 'Ativo' ? '' : 'alert-warning';
            })
            ->make(true); 

        }         
        catch (Exception $e) {           
            return response()->json( $e->getMessage() , 500);
        } 
    }





    /**
    * Função para buscar as  
    *
    * @param Request $request 
    *  
    * @param int  $disciplinaId 
    *
    * @return json
    */
    public function BuscarAssuntosDataTable( Request $request , $disciplinaId )
    {     
        try {            
            $disciplina = $this->model->find($disciplinaId); 
            $models = $disciplina->assuntos( )->withTrashed()->withCount('perguntas');  
            return $this->dataTable
            ->eloquent($models) 
            ->addColumn('action', function($linha) { 
                if($linha->deleted_at != ''){
                    return '<button data-id="'.$linha->id.'" btn-ativar class="btn btn-success btn-sm" title="Ativar"><i class="fa  fa-thumbs-up"></i></button>' 
                    .'<button data-id="'.$linha->id.'" btn-excluir class="btn btn-danger btn-sm" title="Excluir Definitivamente"><i class="fa fa-trash"></i></button>';

                } 
                return 
                '<button data-id="'.$linha->id.'" btn-desativar class="btn btn-danger btn-sm" title="Desativar"><i class="fa fa-thumbs-down"></i></button>';
            })
            ->setRowClass(function ($linha) {
                return $linha->deleted_at == null ? '' : 'alert-warning';
            })
            ->addColumn('status', function ($assunto) {
                return $assunto->deleted_at ? 'Inativo': 'Ativo';  
            })
            ->make(true); 
        }         
        catch (Exception $e) {           
            return response()->json( $e->getMessage() , 500);
        }   
    }






}