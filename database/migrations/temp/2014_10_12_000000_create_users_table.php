<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) { 
            $table->char('id', 11)->primary('id')->comment('CPF DO USUARIO');
            $table->string('nome', 150); 
            $table->string('email')->unique();   
            $table->string('apelido', 50)->nullable(); 
            $table->enum('status', ['A', 'I'])->default('A')->comment('A->ATIVO, I-> INATIVO'); 
            $table->string('image', 200)->default('default.jpg');
            $table->string('obs', 200)->nullable(); 
            $table->char('created_user',11)->default('00000000001');
            $table->string('created_ip',45)->nullable();
            $table->string('created_host',45)->nullable();  
            $table->char('updated_user',11)->default('00000000001');
            $table->string('updated_ip',45)->nullable();
            $table->string('updated_host',45)->nullable();
            $table->timestamps(); 
            $table->string('password');
            $table->rememberToken();  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
