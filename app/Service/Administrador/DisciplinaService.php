<?php

namespace App\Service\Administrador ;
  
use App\Models\Administrador\Disciplina;
use Yajra\DataTables\DataTables;
use App\Service\VueService; 
use Illuminate\Http\Request; 
use App\Exceptions\ModelNotFoundException; 

use Auth;

class DisciplinaService extends VueService  implements DisciplinaServiceInterface 
{


    protected $model;   


    protected $dataTable; 





    public function __construct( Disciplina $disciplina , DataTables $dataTable ){  
        $this->model = $disciplina ;    
        $this->dataTable = $dataTable ; 
    }
  



     /**
    * Busca todos registros de um model 
    *
    * @param Request $request
    *
    * @return $model
    */
    public function  BuscarTodos( Request $request  ){

        if( Auth::user() && Auth::user()->can('DisciplinaNivelRestrita') ){
            return $this->model->select('id' , 'nome')->orderBy('nome' , 'asc')->get();
        }
        else{
           return $this->model->where('nivel' , 'Validada')->select('id' , 'nome')->orderBy('nome' , 'asc')->get();
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
    public function  Ativar( Request $request , $id ){
        throw_if(!$model = $this->model->withTrashed()->find($id), ModelNotFoundException::class);
        $model->restore(); 
        foreach ( $model->assuntos()->withTrashed()->get() as $assunto ) {
    		$assunto->restore();
    	}
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
    		foreach ( $model->assuntos as $assunto ) {
    			$assunto->delete();
    		} 
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
                if($linha->status === 'Inativo'){
                    return '<button data-id="'.$linha->id.'" btn-ativar class="btn btn-success btn-sm" title="Ativar"><i class="fa  fa-thumbs-up"></i></button>' 
                    .'<button data-id="'.$linha->id.'" btn-excluir class="btn btn-danger btn-sm" title="Excluir Definitivamente"><i class="fa fa-trash"></i></button>';

                } 
                return 
                        '<a href="#/'.$linha->id.'/assuntos" class="btn btn-info btn-sm" title="Assuntos"><i class="fa fa-comments"></i></a>'
                       .'<a href="#/edit/'.$linha->id.'" class="btn btn-success btn-sm" title="Editar"><i class="fa fa-pencil"></i></a>'
                       .'<button data-id="'.$linha->id.'" btn-desativar class="btn btn-danger btn-sm" title="Desativar"><i class="fa fa-thumbs-down"></i></button>';
            })
            ->setRowClass(function ($linha) {
                return $linha->status === 'Ativo' ? '' : 'alert-warning';
            })
            ->make(true); 
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
    public function  BuscarAssuntosDataTable( $request , $disciplinaId ){
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
  
}
