<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComentarioPerguntaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comentario_pergunta', function (Blueprint $table) {

            $table->increments('id');
            $table->string('texto' , 1500);
            $table->char('user_id',11);
            $table->unsignedInteger('pergunta_id');
            $table->timestamps();
            $table->softDeletes();
            $table->enum('status', ['Criada','Validada','Invalidada' , 'Solucionada' , 'Restrita' ]);


            $table->foreign('pergunta_id')->references('id')->on('pergunta')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
            

            $table->index('pergunta_id');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comentario_pergunta');
    }
}
