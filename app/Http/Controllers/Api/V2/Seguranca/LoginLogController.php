<?php

namespace  App\Http\Controllers\Api\V1\Seguranca;


use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\VueCrudController;   
use App\Models\Seguranca\LogLogin;  
use Yajra\DataTables\DataTables;
 


class LoginLogController extends VueCrudController
{



	public function __construct( LogLogin $logLogin , DataTables $dataTable   ){

		$this->model = $logLogin ;    
		$this->dataTable = $dataTable ; 
		$this->route = 'loginlog';    

        $this->middleware('auth:api', ['except' => [''] ]);
               
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


 


 

}