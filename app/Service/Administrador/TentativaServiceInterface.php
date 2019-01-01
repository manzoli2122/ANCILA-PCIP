<?php

namespace App\Service\Administrador ;

use App\Service\VueServiceInterface;
use Illuminate\Http\Request; 
  
interface TentativaServiceInterface  extends VueServiceInterface    
{

	public function  Rankiar( Request $request   );
	
	public function  MeuRank( Request $request   );

 
} 