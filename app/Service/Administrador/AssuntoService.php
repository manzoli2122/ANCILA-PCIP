<?php

namespace App\Service\Administrador ;

use App\Models\Administrador\Assunto;
use Yajra\DataTables\DataTables;
use App\Service\VueService; 
use Illuminate\Http\Request; 
use App\Exceptions\ModelNotFoundException; 


class AssuntoService extends VueService  implements AssuntoServiceInterface 
{


    protected $model;   


    protected $dataTable; 





    public function __construct( Assunto $assunto , DataTables $dataTable ){  
        $this->model = $assunto ;    
        $this->dataTable = $dataTable ; 
    }
    




    
    /**
    *  
    * Busca um model pelo id
    *
    * @param int $id
    *
    * @return $model
    */
    public function  BuscarPeloId( Request $request , $id ){ 
        $model = $this->model->with('disciplina')->find($id)  ;
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
        return $this->model->with('disciplina')->orderBy('id', 'desc')->get();
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
    public function  Ativar( Request $request , $id ){
        throw_if(!$model = $this->model->withTrashed()->find($id), ModelNotFoundException::class);
        $model->restore();  
        return 'Ativado';
    }








    /**
    * Função para excluir um model  
    *
    * @param int $id
    *    
    * @return void
    */
    public function  Apagar( Request $request , $id ){

        if( $model = $this->model->find($id)){
            // foreach ( $model->assuntos as $assunto ) {
            //     $assunto->delete();
            // } 
            $model->delete() ; 
            return; 
        }
        
        if( $model = $this->model->onlyTrashed()->find($id)){
            $model->forceDelete(); 
            return; 
        }

        throw_if( true , ModelNotFoundException::class);   

    }





    /**
    * Funcao para buscar as permissoes pelo datatable  
    *
    * @param Request $request 
    *
    * @return json
    */
    public function  BuscarDataTable( $request ){
        $models = $this->model->getDatatable();
        return $this->dataTable->eloquent($models)
        ->addColumn('action', function($linha) {

            if($linha->deleted_at != ''){
                return '<button data-id="'.$linha->id.'" btn-ativar class="btn btn-success btn-sm" title="Ativar"><i class="fa fa-thumbs-up"></i> </button>' 
                .'<button data-id="'.$linha->id.'" btn-excluir class="btn btn-danger btn-sm" title="Excluir Definitivamente"><i class="fa fa-trash"></i></button>';
            } 
            return 
            '<a href="#/edit/'.$linha->id.'" class="btn btn-success btn-sm" title="Editar"><i class="fa fa-pencil"></i></a>'
            . '<a href="#/show/'.$linha->id.'" class="btn btn-primary btn-sm" title="Visualizar" style="margin-left: 10px;"><i class="fa fa-search"></i></a>'
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









    /**
    * Função para excluir um model  
    *
    * @param int $id
    *    
    * @return void
    */
    public function perguntas(Request $request , $id)
    {
        throw_if(!$model = $this->model->find($id) , ModelNotFoundException::class);
        return  $model->perguntas()->with('resposta')->get() ; 
    }








}
