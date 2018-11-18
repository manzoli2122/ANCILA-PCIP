<?php

namespace App\Http\Controllers\Administrador ;
 


use Illuminate\Http\Request;
use App\Http\Controllers\VueController;  
use App\Service\Administrador\ComentarioPerguntaServiceInterface; 
// use Auth;


class ComentarioPerguntaController extends VueController
{

    
    protected $service;    
    
    protected $view = 'administrador.comentario' ;
    
    

    public function __construct(ComentarioPerguntaServiceInterface $service){
        
         $this->service = $service ; 
        
        $this->middleware('auth');
        
        $this->middleware('perfil:Admin');
                            
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
    public function  Ativar( Request $request , $comentarioId ){
        return response()->json( $this->service->Ativar( $request , $comentarioId ), 200 );
    }



    /**
    * Função para criar um model
    *
    * @param Request $request
    *   
    * @return json
    */
    public function store(Request $request)
    {
        $this->validate( $request  , $this->service->validacoes() );   
        try{ 
            $model = $this->service->Salvar( $request );  
        }  
        catch(Exception $e){
            return response()->json( $e->getMessage() , 500);
        }   
        return response()->json( 'Comentário realizado com sucesso' , 200); 
    }




}
