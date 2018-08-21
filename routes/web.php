<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| 
*/
 

Route::get('/', function () {    return view('welcome');})->name('inicio');
  
// Rotas para autenticação 
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout'); 
Route::post('login', 'Auth\LoginController@login'); 
Route::get('login/token', 'Auth\LoginController@authenticate');//->middleware('auth:api');





// PROFILE
Route::post('profile/ativacao/{mailable_id}',      'ProfileController@AtivarNotificacaoEmail') ;  
Route::delete('profile/desativacao/{mailable_id}', 'ProfileController@DesativarNotificacaoEmail') ; 
Route::post('profile/mailable/datatable',  'ProfileController@getNotificacaoDatatable') ;

Route::get('profile/notificacoes',  'ProfileController@notifications') ; 
Route::post('profile/notificacoes',  'ProfileController@readNotifications') ; 
Route::post('profile/limpar/notificacoes',  'ProfileController@limparNotifications') ; 

Route::get('profile',   'ProfileController@profile')->name('profile'); 





// ROTAS TEMPORARIAS A SEREM APAGADAS
 
//Route::post('login', 'Auth\AuthController@login');
Route::get('/admin/login/{cpf?}', 'TemporarioController@login');












/*
|--------------------------------------------------------------------------
| Treinamento
|--------------------------------------------------------------------------
| 
*/ 
Route::post('treinamento/disciplina', 'TreinamentoController@alterarDisciplina')->name('treinamento.disciplina');
Route::post('treinamento/dificuldade', 'TreinamentoController@alterarDificuldade')->name('treinamento.dificuldade');
Route::get('treinamento', 'TreinamentoController@index')->name('treinamento.index');
Route::post('treinamento', 'TreinamentoController@responder')->name('treinamento.responder');
Route::get('treinamento/proximo', 'TreinamentoController@proximo')->name('treinamento.proximo');















Route::namespace('Administrador')->prefix('administrador')->group(function () {
    
	/*
	|--------------------------------------------------------------------------
	| Disciplina
	|--------------------------------------------------------------------------
	| 
	*/  
	Route::get('disciplina/all', 'DisciplinaController@BuscarTodos') ;
	Route::delete('disciplina/desativacao/{disciplinaId}',          	    'DisciplinaController@destroy') ;
	Route::post('disciplina/ativacao/{disciplinaId}',   'DisciplinaController@Ativar') ;   
	Route::post('disciplina/{disciplinaId}/assuntos/datatable', 'DisciplinaController@BuscarAssuntosDataTable'); 
	Route::post('disciplina/datatable', 'DisciplinaController@getDatatable')->name('disciplina.datatable');
	Route::resource('disciplina',       'DisciplinaController')->except(['create', 'edit']); 


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
	Route::post('assunto/datatable', 'AssuntoController@getDatatable')->name('assunto.datatable');
	Route::resource('assunto',       'AssuntoController')->except(['create', 'edit']); 
 
	
	/*
	|--------------------------------------------------------------------------
	| Pergunta
	|--------------------------------------------------------------------------
	| 
	*/  
	Route::get('pergunta/all', 'PerguntaController@BuscarTodos') ;
	Route::delete('pergunta/desativacao/{perguntaId}',   'PerguntaController@destroy') ; 
	Route::post('pergunta/ativacao/{perguntaId}',   'PerguntaController@Ativar') ; 
	Route::post('pergunta/datatable', 'PerguntaController@getDatatable')->name('pergunta.datatable');
	Route::resource('pergunta',       'PerguntaController')->except(['create', 'edit']);


	/*
	|--------------------------------------------------------------------------
	| Respostas
	|--------------------------------------------------------------------------
	| 
	*/ 
	Route::delete('resposta/desativacao/{respostaId}',   'RespostaController@destroy') ; 
	Route::post('resposta/ativacao/{respostaId}',   'RespostaController@Ativar') ;  
	Route::post('resposta/datatable', 'RespostaController@getDatatable')->name('resposta.datatable');
	Route::resource('resposta',       'RespostaController')->except(['create', 'edit']);




});

