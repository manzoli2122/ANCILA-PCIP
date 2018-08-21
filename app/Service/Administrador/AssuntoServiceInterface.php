<?php

namespace App\Service\Administrador ;

use App\Service\VueServiceInterface;
use Illuminate\Http\Request;


  
interface AssuntoServiceInterface  extends VueServiceInterface    
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







     /**
    * Função para excluir um model  
    *
    * @param int $id
    *    
    * @return void
    */
    public function perguntas(Request $request , $id);
    
} 