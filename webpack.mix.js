let mix = require('laravel-mix');
 
 
mix.js('resources/assets/js/vendor.js', 'public/js');
    
mix.js('resources/assets/js/app.js', 'public/js');
  
mix.js('resources/assets/js/components/seguranca/permissao/rotas.js', 'public/js/permissao.js');

mix.js('resources/assets/js/components/seguranca/perfil/rotas.js', 'public/js/perfil.js');

mix.js('resources/assets/js/components/seguranca/usuario/rotas.js', 'public/js/usuario.js');

mix.js('resources/assets/js/components/profile/rotas.js', 'public/js/profile.js');

mix.js('resources/assets/js/components/administrador/disciplina/rotas.js', 'public/js/disciplina.js');

mix.js('resources/assets/js/components/administrador/assunto/rotas.js', 'public/js/assunto.js');

mix.js('resources/assets/js/components/administrador/pergunta/rotas.js', 'public/js/pergunta.js');

mix.js('resources/assets/js/components/administrador/resposta/rotas.js', 'public/js/resposta.js');

mix.js('resources/assets/js/components/administrador/comentarioPergunta/rotas.js', 'public/js/comentario.js');

mix.js('resources/assets/js/components/administrador/tentativa/rotas.js', 'public/js/tentativa.js');


mix.js('resources/assets/js/components/administrador/core/rotas.js', 'public/js/administrador.js');
mix.js('resources/assets/js/components/estatistica/rotas.js', 'public/js/estatistica.js');


mix.js('resources/assets/js/components/treinamento/treinamento.js', 'public/js/treinamento.js');
 
/*
==========================================================================================================
							CSS
==========================================================================================================
*/
 
mix.styles([
    'node_modules/bootstrap/dist/css/bootstrap.css',  
    'node_modules/izitoast/dist/css/iziToast.min.css', 
    'resources/assets/css/modalProcessamento.css',  
], 'public/css/bootstrap.css');
 
mix.styles([  'node_modules/select2/dist/css/select2.css', ], 'public/css/select2.css');
 
mix.styles([ 'node_modules/font-awesome/css/font-awesome.css',  'node_modules/ionicons/dist/css/ionicons.css' ], 'public/css/fonts.css');
  

// Fontes Font-awesome
mix.copy('node_modules/font-awesome/fonts', 'public/fonts');
mix.copy('node_modules/bootstrap/dist/css/bootstrap.css.map', 'public/css');

mix.copy('resources/assets/css/adminlte.css', 'public/css');
mix.copy('resources/assets/css/adminlte.css.map', 'public/css');
mix.copy('resources/assets/js/adminlte.js', 'public/js');
 
// Fontes Ionicons
mix.copy('node_modules/ionicons/dist/fonts', 'public/fonts');
  
mix.version();