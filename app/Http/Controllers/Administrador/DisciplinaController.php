<?php
 
namespace  App\Http\Controllers\Administrador;


use Illuminate\Http\Request;
use App\Http\Controllers\VueController;  
use App\Service\Administrador\DisciplinaServiceInterface; 




class DisciplinaController extends VueController
{
    

    protected $service;  


    protected $view = "administrador.disciplina";   





    
    public function __construct( DisciplinaServiceInterface $service  ){
          
        $this->service = $service ;    
        $this->middleware('auth');
        $this->middleware('permissao:disciplinas');
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
    public function  Ativar( Request $request , $disciplinaId ){
        return response()->json( $this->service->Ativar( $request , $disciplinaId ), 200 );
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
    public function BuscarAssuntosDataTable( Request $request , $disciplinaId )
    {     
        try {            
            return  $this->service->BuscarAssuntosDataTable( $request , $disciplinaId);
        }         
        catch (Exception $e) {           
            return response()->json( $e->getMessage() , 500);
        }   
    }





  
}