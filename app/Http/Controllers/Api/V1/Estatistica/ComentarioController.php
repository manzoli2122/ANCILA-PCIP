<?php

namespace  App\Http\Controllers\Api\V1\Estatistica;


use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\VueCrudController;   
use App\Models\Administrador\Tentativa;  
use Yajra\DataTables\DataTables;
use Validator;
use App\Models\Administrador\Comentario_Pergunta;
use Auth;     

class ComentarioController extends VueCrudController
{

    
     
    

    public function __construct(Comentario_Pergunta $comentario , DataTables $dataTable ){
        
        $this->model = $comentario ;    
		$this->dataTable = $dataTable ; 
		$this->route = 'comentario';  
        
        $this->middleware('auth:api', ['except' => ['Ativar' ] ]);
         
        $this->middleware('perfil:Admin');
                            
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
    public function  Ativar( Request $request , $comentarioId ){

    	if(!$model = $this->model->withTrashed()->find($comentarioId) ){
    		return response()->json('Item não encontrado.', 404 );
    	}
        $model->restore();  
        return response()->json( 'Ativado' , 200 );
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

            if($linha->deleted_at != ''){
                return '<button data-id="'.$linha->id.'" btn-ativar class="btn btn-success btn-sm" title="Ativar"><i class="fa fa-thumbs-up"></i> </button>' 
                .'<button data-id="'.$linha->id.'" btn-excluir class="btn btn-danger btn-sm" title="Excluir Definitivamente"><i class="fa fa-trash"></i></button>';
            } 
            return 
            '<a href="#/'. $this->route . '/edit/'.$linha->id.'" class="btn btn-success btn-sm" title="Editar"><i class="fa fa-pencil"></i></a>'
            .'<button data-id="'.$linha->id.'" btn-desativar class="btn btn-danger btn-sm" title="Desativar"><i class="fa fa-thumbs-down"></i></button>';
        })
        ->setRowClass(function ($linha) {
            $class = '';
            if($linha->deleted_at != ''){
                 $class .= 'alert-warning' ;
            }
            return $class;
        })
        
        ->make(true); 
 

    	}         
    	catch (Exception $e) {           
    		return response()->json( $e->getMessage() , 500);
    	} 
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
    * Função para criar um model
    *
    * @param Request $request
    *   
    * @return json
    */
    public function store(Request $request)
    {	 
    	$validator = Validator::make( $request->all(), $this->model->rules() );

        if ($validator->fails()) {
            return response()->json(['message' =>  (string) $validator->errors() , 'error' => $validator->errors() ] , 422); 
        }  
         
        try{ 
        	$data = $request->all();
       		$data['user_id'] = Auth::guard('api')->user()->id ;
        	if( !$insert  = $this->model->create( $data ) ){
        		return response()->json('Não foi possível cadastrar!' , 500);
        	} 
        }  
        catch(Exception $e){
            return response()->json( $e->getMessage() , 500);
        }   
        return response()->json( 'Cadastro realizado com sucesso' , 200); 
    }


    




}
