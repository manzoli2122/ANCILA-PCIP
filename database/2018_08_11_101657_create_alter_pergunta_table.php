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


        create view classificacao as SELECT B.user_id, format(COUNT(CASE B.acerto WHEN true THEN 1 END ) /  COUNT(*) , 3) * 100 as rendimento ,
            COUNT(*) as total
            from users_resposta_pergunta B
            GROUP BY B.user_id
            HAVING count(*) >10
            ORDER by rendimento desc

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
