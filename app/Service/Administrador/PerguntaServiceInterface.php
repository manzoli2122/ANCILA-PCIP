<?php

namespace App\Service\Administrador ;

use App\Service\VueServiceInterface;
use Illuminate\Http\Request; 
  
interface PerguntaServiceInterface  extends VueServiceInterface    
{

	 



   /**
    * Função para ativar um usuario ja existente  
    *
    * @param Request $request
    *  
    * @param int  $id
    *    
    * @return void
    */
    public function  Ativar( Request $request , $id );

    public function  BuscarCriada( Request $request  );

    
    /**
    * Função para gerar pdf dos usuarios 
    *
    * @param Request $request
    *   
    * @return pdf
    */
    public function  Pdf( Request $request );


    
} 