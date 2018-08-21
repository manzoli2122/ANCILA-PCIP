<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRespostaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resposta', function (Blueprint $table) {
            $table->increments('id');

            $table->string('texto' , 1000);
            
            $table->bigInteger('count' )->default(0);

            $table->unsignedInteger('pergunta_id')->nullable();

            $table->foreign('pergunta_id')->references('id')->on('pergunta')->onDelete('cascade');

            //$table->string('descricao')->nullable();

            $table->softDeletes();

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
        Schema::dropIfExists('resposta');
    }
}
