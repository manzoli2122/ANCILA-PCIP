<?php

namespace App\Http\Controllers ;

use Illuminate\Http\Request; 


class HomeController extends Controller
{


    /**
    * Função para buscar dados do usuario logado
    *
    * @param Request $request
    *   
    * @return view
    */
    public function home(Request $request ){        
        return view('single.index');
    }




 

}
