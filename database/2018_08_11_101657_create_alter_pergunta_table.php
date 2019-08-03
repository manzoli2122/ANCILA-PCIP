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


        create view classificacao as SELECT B.user_id, C.situacao_aprovacao, format(COUNT(CASE B.acerto WHEN true THEN 1 END ) /  COUNT(*) , 3) * 100 as rendimento ,
            COUNT(CASE B.acerto WHEN true THEN 1 END )  as acertos ,
            COUNT(CASE B.acerto WHEN false THEN 1 END )  as erros ,
            COUNT(*) as total
            from users_resposta_pergunta B 
            inner join users C ON B.user_id = C.id
            GROUP BY B.user_id , C.situacao_aprovacao
            HAVING count(*) >10
            ORDER by rendimento desc



            create view classificacao3 as SELECT B.user_id, C.situacao_aprovacao, C.nome, C.data_fim_pro, format(COUNT(CASE B.acerto WHEN true THEN 1 END ) /  COUNT(*) , 3) * 100 as rendimento ,
            COUNT(CASE B.acerto WHEN true THEN 1 END )  as acertos ,
            COUNT(CASE B.acerto WHEN false THEN 1 END )  as erros ,
            COUNT(*) as total
            from users_resposta_pergunta B 
            inner join users C ON B.user_id = C.id
            GROUP BY B.user_id , C.situacao_aprovacao, C.nome, C.data_fim_pro
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
