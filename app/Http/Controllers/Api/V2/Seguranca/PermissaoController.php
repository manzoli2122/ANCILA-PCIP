<?php

namespace  App\Http\Controllers\Api\V2\Seguranca;


use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\VueCrudController;   
use Yajra\DataTables\DataTables;
use Validator; 
use Cache; 
use App\Models\Seguranca\Permissao; 
use App\Models\Seguranca\Perfil;


class PermissaoController extends VueCrudController
{




	public function __construct( Permissao $permissao , DataTables $dataTable  ){

		$this->model = $permissao ;   
		$this->dataTable = $dataTable ; 
		$this->route = 'permissao';  

		$this->middleware('auth:api', ['except' => ['Ativar' ] ]);

        // $this->middleware('permissao:permissoes');
        // $this->middleware('perfil:Admin')->only('update', 'destroy');       
	}








    /**
    * Função para buscar as Perfis de uma Permissao pelo datatable
    *
    * @param Request $request 
    *  
    * @param int  $permissaoId 
    *
    * @return json
    */
    public function BuscarPerfisDataTable( Request $request , $permissaoId )
    {     
    	try {            
    		$permissao = $this->model->find($permissaoId); 
    		$models = $permissao->perfis( );  
    		return $this->dataTable
    		->eloquent($models) 
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
    		if( !$model = $this->model->find($id) ){
    			return response()->json( 'Item não encontrado' , 404);
    		}
    		if( !$delete = $model->delete() ){
    			return response()->json([ 'message' => 'Erro ao excluir o registro!' ], 500);
    		}
    		if(Cache::getStore() instanceof TaggableStore){
    			Cache::tags(Perfil::$cacheTag)->flush();
    		}
    		else{
    			Cache::flush( );
    		}  
    		return response()->json( 'Exclusão realizada com sucesso' , 200); 
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
     			return 
     			'<a href="#/'. $this->route . '/'.$linha->id.'/perfis" class="btn btn-warning btn-sm" title="Perfis"><i class="fa fa-id-card"></i></a>'
     			.'<a href="#/'. $this->route . '/edit/'.$linha->id.'" class="btn btn-success btn-sm" title="Editar"><i class="fa fa-pencil"></i></a>'
     			.'<button data-id="'.$linha->id.'" btn-excluir class="btn btn-danger btn-sm" title="Excluir"><i class="fa fa-trash"></i></button>';
     		})
     		->make(true);

     	}         
     	catch (Exception $e) {           
     		return response()->json( $e->getMessage() , 500);
     	} 
     }





 }