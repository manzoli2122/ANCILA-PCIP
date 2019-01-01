<?php

namespace App\Http\Controllers\Api\V1 ;



use Illuminate\Http\Request;  
use Exception ;
use App\Exceptions\ModelNotFoundException;
use Illuminate\Database\QueryException;  
use App\Http\Controllers\Controller;
use Validator;




class VueCrudController extends Controller
{
 	
 	protected $model;   

    protected $dataTable;

    protected $route;   

     
 




    /**
    * Busca todos registros de um model 
    *
    * @param Request $request
    *
    * @return $model
    */
    public function  BuscarTodos( Request $request  ){
        return response()->json( $this->model->get() , 200); 
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
            if( !$model =  $this->model->find($id)   ){       
                return response()->json('Item não encontrado.', 404 );    
            } 
            return response()->json( $model , 200);
        }         
        catch(Exception $e) {  
            return response()->json( 'Erro interno'  , 500);    
        }
    }









    /**
    * Função para atualizar um model
    *
    * @param Request $request
    *  
    * @param int  $id
    *    
    * @return json
    */
    public function update(Request $request ,  $id )
    {       

    	$validator = Validator::make( $request->all(), $this->model->rules() );

        if ($validator->fails()) {
            return response()->json(['message' =>  (string) $validator->errors() , 'error' => $validator->errors() ] , 422); 
        }  

        try{ 
        	if( !$model =  $this->model->find($id)   ){       
                return response()->json('Item não encontrado.', 404 );    
            }         	 
        	if( !$update = $model->update($request->all())  ){
        		return response()->json('Nãp foi possivel atualizar.', 500 ); 
        	}

            
        }  
        catch(Exception $e){
            return response()->json( $e->getMessage() , 500);
        } 
        return response()->json( 'Atualização realizada com sucesso' , 200); 
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
        	if( !$insert  = $this->model->create( $request->all() ) ){
        		return response()->json('Não foi possível cadastrar!' , 500);
        	} 
        }  
        catch(Exception $e){
            return response()->json( $e->getMessage() , 500);
        }   
        return response()->json( 'Cadastro realizado com sucesso' , 200); 
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
    			return  '<a href="#/'. $this->route . '/edit/'.$linha->id.'" btn-edit class="btn btn-success btn-sm" title="Editar"><i class="fa fa-pencil"></i></a>'
    			.'<a href="#/'. $this->route . '/show/'.$linha->id.'" class="btn btn-primary btn-sm" title="Visualizar"><i class="fa fa-search"></i></a>';
    		})
    		->make(true);   

    		// return  $this->service->BuscarDataTable( $request);

    	}         
    	catch (Exception $e) {           
    		return response()->json( $e->getMessage() , 500);
    	} 
    }



     // FUNÇÕES A SEREM IMPLEMENTADAS 
    
    public function  ValidarAtualizacao( $entity ){}
    public function  ValidarExclusao( $entity ){}
    public function  ValidarCriacao(  ){}

    public function  Autorizar(){}
    public function  BuscarQuantidade(){}
  


  
}
