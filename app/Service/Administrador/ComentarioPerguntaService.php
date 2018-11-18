<?php

namespace App\Service\Administrador ;
  
use App\Models\Administrador\Comentario_Pergunta;
use Yajra\DataTables\DataTables;
use App\Service\VueService; 
use Illuminate\Http\Request; 
use Auth;


class ComentarioPerguntaService  extends VueService  implements ComentarioPerguntaServiceInterface 
{


    protected $model;   


    protected $dataTable; 





    public function __construct( Comentario_Pergunta $comentario , DataTables $dataTable ){  
        $this->model = $comentario ;    
        $this->dataTable = $dataTable ; 
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

    
    




    /**
    * Função para excluir um model  
    *
    * @param int $id
    *    
    * @return void
    */
    public function  Apagar( Request $request , $id ){

        if( $model = $this->model->find($id)){ 
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
    * Função para criar um model  
    *
    * @param Request $request
    *    
    * @return void
    */
    public function  Salvar( $request  ){

        $data = $request->all();
        $data['user_id'] = Auth::user()->id ;

        throw_if( !$insert  = $this->model->create( $data ) , Exception::class); 

          
        
        return $insert ;  
    }





   
}
