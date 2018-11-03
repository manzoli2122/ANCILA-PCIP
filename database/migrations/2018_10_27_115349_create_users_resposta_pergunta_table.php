<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersRespostaPerguntaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_resposta_pergunta', function (Blueprint $table) {
            $table->increments('id');

            $table->char('user_id',11); 
            $table->unsignedInteger('pergunta_id');  
            $table->unsignedInteger('disciplina_id');  
            $table->unsignedInteger('resposta_id');  
            $table->boolean('acerto')->default(false);
            $table->softDeletes();

            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict'); 
            $table->foreign('pergunta_id')->references('id')->on('pergunta')->onDelete('restrict'); 
            $table->foreign('disciplina_id')->references('id')->on('disciplina')->onDelete('restrict'); 
            $table->foreign('resposta_id')->references('id')->on('resposta')->onDelete('restrict');  




            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_resposta_pergunta');
    }
}
