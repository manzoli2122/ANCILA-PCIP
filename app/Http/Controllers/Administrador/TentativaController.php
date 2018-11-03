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

 

  
}