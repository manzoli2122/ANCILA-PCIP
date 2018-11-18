<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
         Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Service\VueServiceInterface',
            'App\Service\VueService'
        );
  
        $this->app->bind(
            'App\Service\Seguranca\PermissaoServiceInterface',
            'App\Service\Seguranca\PermissaoService'
        );

        $this->app->bind(
            'App\Service\Seguranca\PerfilServiceInterface',
            'App\Service\Seguranca\PerfilService'
        );

        $this->app->bind(
            'App\Service\Seguranca\UsuarioServiceInterface',
            'App\Service\Seguranca\UsuarioService'
        );

        $this->app->bind(
            'App\Service\Administrador\DisciplinaServiceInterface',
            'App\Service\Administrador\DisciplinaService'
        );

        $this->app->bind(
            'App\Service\Administrador\AssuntoServiceInterface',
            'App\Service\Administrador\AssuntoService'
        );


        $this->app->bind(
            'App\Service\Administrador\TentativaServiceInterface',
            'App\Service\Administrador\TentativaService'
        );



        $this->app->bind(
            'App\Service\Administrador\PerguntaServiceInterface',
            'App\Service\Administrador\PerguntaService'
        );


        $this->app->bind(
            'App\Service\Administrador\RespostaServiceInterface',
            'App\Service\Administrador\RespostaService'
        );


        $this->app->bind(
            'App\Service\Administrador\ComentarioPerguntaServiceInterface',
            'App\Service\Administrador\ComentarioPerguntaService'
        );




    }
}
