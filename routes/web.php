<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| 
*/
  
// Route::get('/estatistica', function () { return view('estatistica.index');})->name('estatistica');
// Route::get('/seguranca', function () {   return view('seguranca.index');})->name('seguranca');
// Route::get('/admin', function () {    return view('administrador.index');})->name('admin');

// Route::get('/single', function () {    return view('single.index'); } ) ;
Route::get('/single', 'HomeController@home') ;
 
// Route::get('/', function () {    return view('welcome');})->name('inicio');
// Route::get('/', function () {    return redirect('single'); })->name('inicio');
Route::get('/','HomeController@home')->name('inicio');
 
// Route::get('/desenvolvedor',function(){return view('desenvolvedor');})->name('desenvolvedor');

  
// Rotas para autenticação 
// Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
// Route::post('logout', 'Auth\LoginController@logout')->name('logout'); 
// Route::post('login', 'Auth\LoginController@login'); 
// Route::get('cadastro', 'Auth\LoginController@cadastro')->name('cadastro.view');
// Route::post('cadastro', 'Auth\LoginController@salvarCadastro')->name('cadastro.post');




// PROFILE


// Route::post('profile/alterar/senha', 'ProfileController@updateSenha') ;
// Route::post('profile/ativacao/{mailable_id}',  'ProfileController@AtivarNotificacaoEmail') ;  
// Route::delete('profile/desativacao/{mailable_id}','ProfileController@DesativarNotificacaoEmail'); 
// Route::post('profile/mailable/datatable',  'ProfileController@getNotificacaoDatatable') ;
// Route::get('profile/notificacoes',  'ProfileController@notifications') ; 
// Route::post('profile/notificacoes',  'ProfileController@readNotifications') ; 
// Route::post('profile/limpar/notificacoes',  'ProfileController@limparNotifications') ; 
// Route::get('profile',   'ProfileController@profile')->name('profile'); 





// ROTAS TEMPORARIAS A SEREM APAGADAS
 
//Route::post('login', 'Auth\AuthController@login');
 // Route::get('/admin/login/{cpf?}', 'TemporarioController@login');
 

 // Route::get('login/token', 'Auth\LoginController@authenticate');//->middleware('auth:api');


// Route::get('/admin/login/{cpf?}', 'TemporarioController@login');











/*
|--------------------------------------------------------------------------
| Treinamento
|--------------------------------------------------------------------------
| 
*/ 
// Route::post('treinamento/disciplina', 'TreinamentoController@alterarDisciplina')->name('treinamento.disciplina');
// Route::get('treinamento/disciplina', 'TreinamentoController@getDisciplina')->name('treinamento.disciplina');
// Route::post('treinamento/dificuldade', 'TreinamentoController@alterarDificuldade')->name('treinamento.dificuldade');
// Route::get('treinamento', 'TreinamentoController@index')->name('treinamento.index');
// Route::post('treinamento', 'TreinamentoController@responder')->name('treinamento.responder');
// Route::get('treinamento/proximo', 'TreinamentoController@proximo')->name('treinamento.proximo');
// Route::get('treinamento/placar', 'TreinamentoController@placar')->name('treinamento.placar');
// Route::get('treinamento/historico', 'TreinamentoController@historico')->name('treinamento.historico');
 
// Route::post('treinamento/criar/comentario',   'Administrador\ComentarioPerguntaController@store') ; 

// Route::get('treinamento/meu/rank',   'Administrador\TentativaController@MeuRank') ; 












// Route::namespace('Administrador')->prefix('administrador')->group(function () {
    
	/*
	|--------------------------------------------------------------------------
	| Disciplina
	|--------------------------------------------------------------------------
	| 
	*/  
	// Route::get('disciplina/all', 'DisciplinaController@BuscarTodos') ;
	// Route::delete('disciplina/desativacao/{disciplinaId}',          	    'DisciplinaController@destroy') ;
	// Route::post('disciplina/ativacao/{disciplinaId}',   'DisciplinaController@Ativar') ;   
	// Route::post('disciplina/{disciplinaId}/assuntos/datatable', 'DisciplinaController@BuscarAssuntosDataTable'); 
	// Route::post('disciplina/datatable', 'DisciplinaController@getDatatable')->name('disciplina.datatable');
	// Route::resource('disciplina',       'DisciplinaController')->except(['create', 'edit']); 




	/*
	|--------------------------------------------------------------------------
	| Tentativa
	|--------------------------------------------------------------------------
	| 
	*/  
	// Route::get('tentativa/ranking', 'TentativaController@Rankiar') ;
	// Route::get('tentativa/all', 'TentativaController@BuscarTodos') ;
	// Route::post('tentativa/datatable', 'TentativaController@getDatatable')->name('tentativa.datatable');
	// Route::resource('tentativa',       'TentativaController')->except(['create', 'edit' , 'update' , 'store' , 'destroy']); 




	/*
	|--------------------------------------------------------------------------
	| Assunto
	|--------------------------------------------------------------------------
	| 
	*/  
	// Route::get('assunto/all', 'AssuntoController@BuscarTodos') ;
	// Route::get('assunto/{id}/perguntas', 'AssuntoController@perguntas') ;
	// Route::delete('assunto/desativacao/{assuntoId}',   'AssuntoController@destroy') ; 
	// Route::post('assunto/ativacao/{assuntoId}',   'AssuntoController@Ativar') ;  
	// Route::post('assunto/datatable', 'AssuntoController@getDatatable')->name('assunto.datatable');
	// Route::resource('assunto',       'AssuntoController')->except(['create', 'edit']); 
 
	
	/*
	|--------------------------------------------------------------------------
	| Pergunta
	|--------------------------------------------------------------------------
	| 
	*/  

	// Route::post('pergunta/alterar/resposta/{perguntaId}',   'PerguntaController@AlterarResposta') ; 
	

	// Route::post('pergunta/criar/resposta',   'RespostaController@store') ; 
	// Route::patch('pergunta/editar/resposta/{id}',   'RespostaController@update') ; 


	// Route::get('pergunta/datatable/pdf', 'PerguntaController@pdf');

	// Route::get('pergunta/all', 'PerguntaController@BuscarTodos') ;
	// Route::get('pergunta/all/criada', 'PerguntaController@BuscarCriada') ;
	// Route::delete('pergunta/desativacao/{perguntaId}',   'PerguntaController@destroy') ; 
	// Route::post('pergunta/ativacao/{perguntaId}',   'PerguntaController@Ativar') ; 
	// Route::post('pergunta/datatable', 'PerguntaController@getDatatable')->name('pergunta.datatable');
	// Route::resource('pergunta',       'PerguntaController')->except(['create', 'edit']);


	/*
	|--------------------------------------------------------------------------
	| Respostas
	|--------------------------------------------------------------------------
	| 
	*/ 
	// Route::delete('resposta/desativacao/{respostaId}',   'RespostaController@destroy') ; 
	// Route::post('resposta/ativacao/{respostaId}',   'RespostaController@Ativar') ;  
	// Route::post('resposta/datatable', 'RespostaController@getDatatable')->name('resposta.datatable');
	// Route::resource('resposta',       'RespostaController')->except(['create', 'edit']);





	/*
	|--------------------------------------------------------------------------
	| Comentario
	|--------------------------------------------------------------------------
	| 
	*/ 
// 	Route::delete('comentario/desativacao/{comentarioId}',   'ComentarioPerguntaController@destroy') ; 
// 	Route::post('comentario/ativacao/{comentarioId}',   'ComentarioPerguntaController@Ativar') ;  
// 	Route::post('comentario/datatable', 'ComentarioPerguntaController@getDatatable')->name('comentario.datatable');
// 	Route::resource('comentario',       'ComentarioPerguntaController')->except(['create', 'edit']);



// });

