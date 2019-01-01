<?php
 
namespace  App\Http\Controllers\Administrador;


use Illuminate\Http\Request;
use App\Http\Controllers\VueController;  
use App\Service\Administrador\TentativaServiceInterface; 




class TentativaController extends VueController
{
    

    protected $service;  


    protected $view = "administrador.tentativa";   

 
    public function __construct( TentativaServiceInterface $service  ){
          
        $this->service = $service ;    
        $this->middleware('auth')  ;
        $this->middleware('perfil:Admin')->only( 'destroy');       
    }


    
 
    public function  Rankiar( Request $request  ){
        return response()->json( $this->service->Rankiar( $request  ) , 200); 
    }
  

    public function  MeuRank( Request $request  ){
        return response()->json( $this->service->MeuRank( $request  ) , 200); 
    }
  





}