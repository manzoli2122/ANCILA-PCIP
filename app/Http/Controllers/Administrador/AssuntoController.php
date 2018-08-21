<?php
 
namespace  App\Http\Controllers\Administrador;


use Illuminate\Http\Request;
use App\Http\Controllers\VueController;  
use App\Service\Administrador\AssuntoServiceInterface; 


class AssuntoController extends VueController
{
    

    protected $service;  


    protected $view = "administrador.assunto";   



    
    public function __construct( AssuntoServiceInterface $service  ){
          
        $this->service = $service ;    
        $this->middleware('auth');
        $this->middleware('permissao:assuntos');
        $this->middleware('perfil:Admin')->only('update', 'destroy');       
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
    public function  Ativar( Request $request , $assuntoId ){
        return response()->json( $this->service->Ativar( $request , $assuntoId ), 200 );
    }




    public function perguntas(Request $request , $id)
    {
        return response()->json( $this->service->perguntas( $request , $id) , 200);
         
    }







 
  
}