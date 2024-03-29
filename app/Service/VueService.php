<?php

namespace App\Service ; 

use App\Exceptions\ModelNotFoundException; 
use Illuminate\Http\Request;  
use Auth;
use Log;
use Exception;



class VueService  implements VueServiceInterface  
{


    protected $model;   


    protected $dataTable;









    /**
    *  FIX-ME PODE SER GRAVADO NO ELASTICSEARCH A VISUALIZAÇÃO
    * Busca um model pelo id
    *
    * @param int $id
    *
    * @return $model
    */
    public function  BuscarPeloId( Request $request , $id ){ 
        $model = $this->model->find($id)  ;
        return   $model   ; 
    }









    /**
    * Busca todos registros de um model 
    *
    * @param Request $request
    *
    * @return $model
    */
    public function  BuscarTodos( Request $request  ){
        return $this->model->get();
    }









    /**
    * Função para atualizar um model ja existente  
    *
    * @param Request $request
    *  
    * @param int  $id
    *    
    * @return void
    */
    public function  Atualizar( Request $request , $id){ 
        throw_if(!$model = $this->model->find($id) , ModelNotFoundException::class); 
        throw_if( !$update = $model->update($request->all()) , Exception::class); 
         
        return $model;
    }










    /**
    * Função para criar um model  
    *
    * @param Request $request
    *    
    * @return void
    */
    public function  Salvar( $request  ){

        throw_if( !$insert  = $this->model->create( $request->all() ) , Exception::class); 
        return $insert ;  
    }

    








    /**
    * Função para buscar as validacoes do modelo 
    * 
    * @return $rules
    */
    public function  validacoes(){
        return $this->model->rules();
    }  









    /**
    * Função para excluir um model  
    *
    * @param int $id
    *    
    * @return void
    */
    public function  Apagar( Request $request , $id ){
        throw_if(!$model = $this->model->find($id) , ModelNotFoundException::class);   
        throw_if( !$delete = $model->delete()  , Exception::class);   
    }









     







    /**
    * Função para buscar models para datatable  
    *
    * @param Request $request
    *    
    * @return void
    */
    public function  BuscarDataTable( $request ){ 
        $models = $this->model->getDatatable();
        return $this->dataTable->eloquent($models)
        ->addColumn('action', function($linha) {
            return  '<a href="#/edit/'.$linha->id.'" btn-edit class="btn btn-success btn-sm" title="Editar"><i class="fa fa-pencil"></i></a>'
            .'<a href="#/show/'.$linha->id.'" class="btn btn-primary btn-sm" title="Visualizar"><i class="fa fa-search"></i></a>';
        })
        ->make(true);  
    }





    // FUNÇÕES A SEREM IMPLEMENTADAS 
    
    public function  ValidarAtualizacao( $entity ){}
    public function  ValidarExclusao( $entity ){}
    public function  ValidarCriacao(  ){}

    public function  Autorizar(){}
    public function  BuscarQuantidade(){}



} 