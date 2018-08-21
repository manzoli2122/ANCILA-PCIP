<?php

namespace App\Service\Administrador ;

use App\Service\VueServiceInterface;
use Illuminate\Http\Request; 
  
interface DisciplinaServiceInterface  extends VueServiceInterface    
{

	/**
    * Função para buscar as  
    *
    * @param Request $request 
    *  
    * @param int  $permissaoId 
    *
    * @return json
    */
    public function  BuscarAssuntosDataTable( $request , $disciplinaId );
   



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
} 