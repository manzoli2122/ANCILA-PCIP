<?php

namespace  App\Http\Controllers\Api\V1\Administrador;


use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\VueCrudController;   
use App\Models\Administrador\Assunto;  
use Yajra\DataTables\DataTables; 
use Validator;



class AssuntoController extends VueCrudController
{

 

	public function __construct( Assunto $assunto , DataTables $dataTable ){
		$this->model = $assunto ;    
		$this->dataTable = $dataTable ; 
        $this->route = 'assunto';

        $this->middleware('auth:api', ['except' => [''] ]);        
		 
        $this->middleware('permissao:assunto');
        $this->middleware('permissao:assunto-editar')->only('update');
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
     	return response()->json($this->model->with('disciplina')->orderBy('id','desc')->get(), 200); 
     }






    /**
    * Função para buscar um model
    *
    * @param Request $request
    *  
    * @param int  $id
    *    
    * @return json
    */
    public function show(Request $request , $id){
    	try {  
    		if( !$model =  $this->model->with('disciplina')->find($id)   ){       
    			return response()->json('Item não encontrado.', 404 );    
    		} 
    		return response()->json( $model , 200);
    	}         
    	catch(Exception $e) {  
    		return response()->json( 'Erro interno'  , 500);    
    	}
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
 	public function  Ativar( Request $request , $assuntoId ){
 		if(!$model = $this->model->withTrashed()->find($assuntoId)){
 			return response()->json('Item não encontrado.', 404 );
 		}
 		$model->restore(); 
 		return response()->json( 'Ativado' , 200 );
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
    			. '<a href="#/'. $this->route . '/show/'.$linha->id.'" class="btn btn-primary btn-sm" title="Visualizar" style="margin-left: 10px;"><i class="fa fa-search"></i></a>'
    			.'<button data-id="'.$linha->id.'" btn-desativar class="btn btn-danger btn-sm" title="Desativar"><i class="fa fa-thumbs-down"></i></button>';
    		})
    		->setRowClass(function ($linha) {
    			return $linha->deleted_at == '' ? '' : 'alert-warning';
    		})
    		->addColumn('status', function ($assunto) {
    			return $assunto->deleted_at ? 'Inativo': 'Ativo';  
    		})
    		->addColumn('nomedisciplina', function ($assunto) {
    			return $assunto->disciplina->nome ;
    		})
    		->make(true); 

    	}         
    	catch (Exception $e) {           
    		return response()->json( $e->getMessage() , 500);
    	} 
    }







    public function perguntas(Request $request , $id)
    {
    	if( !$model = $this->model->find($id) ){
    		return response()->json( 'Item não encontrado' , 404); 
    	} 
    	return response()->json(   $model->perguntas()->with('resposta')->get() , 200);
    }




}