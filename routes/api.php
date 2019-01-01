<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

    
Route::namespace('Api\V1\Estatistica')->prefix('v1')->group(function () {
    /*
    |--------------------------------------------------------------------------
    | Tentativa
    |--------------------------------------------------------------------------
    | 
    */  
    // Route::get('tentativa/ranking', 'TentativaController@Rankiar') ;
    Route::get('tentativa/all', 'TentativaController@BuscarTodos') ;
    Route::post('tentativa/datatable', 'TentativaController@getDatatable');
    Route::resource('tentativa','TentativaController')->except(['create', 'edit' , 'update' , 'store' , 'destroy']); 


    /*
    |--------------------------------------------------------------------------
    | Comentario
    |--------------------------------------------------------------------------
    | 
    */ 
    Route::delete('comentario/desativacao/{comentarioId}',  'ComentarioController@destroy') ; 
    Route::post('comentario/ativacao/{comentarioId}', 'ComentarioController@Ativar') ;  
    Route::post('comentario/datatable', 'ComentarioController@getDatatable');
    Route::resource('comentario', 'ComentarioController')->except(['create', 'edit']);


});


Route::namespace('Api\V1\Administrador')->prefix('v1')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Disciplina
    |--------------------------------------------------------------------------
    | 
    */  
    Route::get('disciplina/all', 'DisciplinaController@BuscarTodos') ;
    Route::delete('disciplina/desativacao/{disciplinaId}',                  'DisciplinaController@destroy') ;
    Route::post('disciplina/ativacao/{disciplinaId}', 'DisciplinaController@Ativar') ;   
    Route::post('disciplina/{disciplinaId}/assuntos/datatable', 'DisciplinaController@BuscarAssuntosDataTable'); 
    Route::post('disciplina/datatable', 'DisciplinaController@getDatatable');
    Route::resource('disciplina', 'DisciplinaController')->except(['create', 'edit', 'index']); 
 
	// Route::get('disciplina/all', 'DisciplinaController@BuscarTodos') ;



    /*
    |--------------------------------------------------------------------------
    | Assunto
    |--------------------------------------------------------------------------
    | 
    */  
    Route::get('assunto/all', 'AssuntoController@BuscarTodos') ;
    Route::get('assunto/{id}/perguntas', 'AssuntoController@perguntas') ;
    Route::delete('assunto/desativacao/{assuntoId}',   'AssuntoController@destroy') ; 
    Route::post('assunto/ativacao/{assuntoId}',   'AssuntoController@Ativar') ;  
    Route::post('assunto/datatable', 'AssuntoController@getDatatable');
    Route::resource('assunto',  'AssuntoController')->except(['create', 'edit' , 'index']); 
 


    /*
    |--------------------------------------------------------------------------
    | Pergunta
    |--------------------------------------------------------------------------
    | 
    */  

    Route::post('pergunta/alterar/resposta/{perguntaId}', 'PerguntaController@AlterarResposta') ;   
    Route::post('pergunta/criar/resposta', 'RespostaController@store') ; 
    Route::patch('pergunta/editar/resposta/{id}',   'RespostaController@update') ;  
    Route::get('pergunta/datatable/pdf', 'PerguntaController@pdf');
    Route::get('pergunta/all', 'PerguntaController@BuscarTodos') ;
    Route::get('pergunta/all/criada', 'PerguntaController@BuscarCriada') ;
    Route::delete('pergunta/desativacao/{perguntaId}',   'PerguntaController@destroy') ; 
    Route::post('pergunta/ativacao/{perguntaId}',   'PerguntaController@Ativar') ; 
    Route::post('pergunta/datatable', 'PerguntaController@getDatatable') ;
    Route::resource('pergunta', 'PerguntaController')->except(['create', 'edit', 'index']);



    /*
    |--------------------------------------------------------------------------
    | Respostas
    |--------------------------------------------------------------------------
    | 
    */ 
    Route::delete('resposta/desativacao/{respostaId}',  'RespostaController@destroy') ; 
    Route::post('resposta/ativacao/{respostaId}',   'RespostaController@Ativar') ;  
    Route::post('resposta/datatable', 'RespostaController@getDatatable');
    Route::resource('resposta', 'RespostaController')->except(['create', 'edit', 'index']);


 
 	 
});







Route::namespace('Api\V1')->prefix('v1')->group(function () { 

 	Route::get('treinamento/proximo', 'TreinamentoController@proximo') ;
    Route::post('treinamento', 'TreinamentoController@responder') ;
 	Route::post('treinamento/proximo', 'TreinamentoController@proximoPost') ;

});



Route::group([

    'middleware' => 'api',
    'prefix' => 'auth',
    'namespace' => 'Api\V1\Auth',

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::get('me', 'AuthController@me');

    Route::post('update/senha', 'AuthController@updateSenha') ;
    Route::post('cadastro', 'AuthController@salvarCadastro') ;
    Route::post('reset/senha', 'AuthController@resetarSenha') ;


});
 