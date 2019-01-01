<?php

namespace  App\Http\Controllers\Api\V1\Estatistica;


use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\VueCrudController;   
use App\Models\Administrador\Tentativa;  
use Yajra\DataTables\DataTables;
use Auth;
use DB;
use Validator;


class TentativaController extends VueCrudController
{



	public function __construct( Tentativa $tentativa , DataTables $dataTable   ){

		$this->model = $tentativa ;    
		$this->dataTable = $dataTable ; 
		$this->route = 'tentativa';    

        $this->middleware('auth:api', ['except' => ['Ativar' ] ]);
        
        // $this->middleware('auth')  ;
        // $this->middleware('perfil:Admin')->only( 'destroy');       
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
    	return response()->json( 'Item não encontrado' , 404); 
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
    		->editColumn('created_at', function ($user) {
    			return $user->created_at->format('Y/m/d H:i');
    		})
    		->filterColumn('created_at', function ($query, $keyword) {
    			$query->whereRaw("DATE_FORMAT(created_at,'%Y/%m/%d') like ?", ["%$keyword%"]);
    		}) 
    		->make(true); 

    	}         
    	catch (Exception $e) {           
    		return response()->json( $e->getMessage() , 500);
    	} 
    }





    public function  Rankiar( Request $request  ){

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
                ->get();  

        // $model = $model->where('user_id', '07895101706');
          
    	return response()->json($model , 200); 
    }









    public function  MeuRank( Request $request  ){

    	$model = $this->model->select('user_id'  ,   
                                        DB::raw('count(*) as total') , 
                                        DB::raw('DENSE_RANK() OVER( ORDER BY count(CASE WHEN acerto THEN 1 END) / cast(  count(*) AS NUMERIC(15,3)) desc)  as rank') ,                                 
                                        DB::raw('count(CASE WHEN acerto THEN 1 END) as positivo')  ,   
                                        DB::raw('count(CASE WHEN acerto THEN 1 END) / cast(count(*) AS NUMERIC(15,3)) * 100    as porcentagem ')   )

                ->groupBy('user_id')
                ->havingRaw('count(*) > ?', [10])  
                ->get();  

        $model = $model->where('user_id', Auth::guard('api')->user()->id );
        
    	return response()->json( $model->first() , 200); 
    }






}