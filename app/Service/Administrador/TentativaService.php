<?php

namespace App\Service\Administrador ;
  
use App\Models\Administrador\Tentativa;
use Yajra\DataTables\DataTables;
use App\Service\VueService; 
use Illuminate\Http\Request; 
use App\Exceptions\ModelNotFoundException; 



class TentativaService extends VueService  implements TentativaServiceInterface 
{


    protected $model;   


    protected $dataTable; 





    public function __construct( Tentativa $disciplina , DataTables $dataTable ){  
        $this->model = $disciplina ;    
        $this->dataTable = $dataTable ; 
    }
  



    /**
    * Função para excluir um model  
    *
    * @param int $id
    *    
    * @return void
    */
    public function  Apagar( Request $request , $id ){
  
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
        	// ->addColumn('user', function ($tentativa) {
	        //     return $tentativa->usuario->nome ;
	        // })
            ->editColumn('created_at', function ($user) {
                return $user->created_at->format('Y/m/d');
            })
            ->filterColumn('created_at', function ($query, $keyword) {
                $query->whereRaw("DATE_FORMAT(created_at,'%Y/%m/%d') like ?", ["%$keyword%"]);
            }) 
            ->make(true); 
    }


 
}
