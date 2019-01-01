<?php

namespace App\Service\Administrador ;
  
use App\Models\Administrador\Tentativa;
use Yajra\DataTables\DataTables;
use App\Service\VueService; 
use Illuminate\Http\Request; 
use App\Exceptions\ModelNotFoundException; 
use Auth;
use DB;

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
                return $user->created_at->format('Y/m/d H:i');
            })
            ->filterColumn('created_at', function ($query, $keyword) {
                $query->whereRaw("DATE_FORMAT(created_at,'%Y/%m/%d') like ?", ["%$keyword%"]);
            }) 
            ->make(true); 
    }




    public function  MeuRank( Request $request   ){
        $model = $this->model->select('user_id'  ,   
                                        DB::raw('count(*) as total') , 
                                        DB::raw('DENSE_RANK() OVER( ORDER BY count(CASE WHEN acerto THEN 1 END) / cast(  count(*) AS NUMERIC(15,3)) desc)  as rank') ,                                 
                                        DB::raw('count(CASE WHEN acerto THEN 1 END) as positivo')  ,   
                                        DB::raw('count(CASE WHEN acerto THEN 1 END) / cast(count(*) AS NUMERIC(15,3)) * 100    as porcentagem ')   )

                ->groupBy('user_id')
                ->havingRaw('count(*) > ?', [10]) 
                // ->with('usuario')   
                ->get(); ;



        $model = $model->where('user_id', Auth::user()->id );
        return   $model->first()   ; 
    }






    public function  Rankiar( Request $request   ){



        $model = $this->model->select('user_id'  ,   
                                        DB::raw('count(*) as total') , 
                                        DB::raw('DENSE_RANK() OVER( ORDER BY count(CASE WHEN acerto THEN 1 END) / cast(count(*) AS NUMERIC(15,3)) desc) as rank') ,                                 
                                        DB::raw('count(CASE WHEN acerto THEN 1 END) as positivo')  ,   
                                        DB::raw('count(CASE WHEN acerto THEN 1 END) / cast(count(*) AS NUMERIC(15,3)) * 100    as porcentagem ')   )

                ->groupBy('user_id')
                 // ->orderBy('total' , 'desc')
                ->havingRaw('count(*) > ?', [10]) 
                // ->where('user_id' , '07819403705') 
                ->with('usuario')   
                ->get(); ;



        // $model = $model->where('user_id', '07895101706');
        return   $model   ; 
    }
 





}
