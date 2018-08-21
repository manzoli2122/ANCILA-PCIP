<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlterPerguntaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('pergunta', function (Blueprint $table) {
            $table->foreign('resposta_certa_id')->references('id')->on('resposta')->onDelete('set null');
        }); 


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::table('pergunta', function (Blueprint $table) {
            $table->dropForeign(['resposta_certa_id']);
        }); 
    }
}
