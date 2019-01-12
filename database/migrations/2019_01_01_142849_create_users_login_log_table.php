<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersLoginLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_login_log', function (Blueprint $table) {
            
            $table->increments('id');
            $table->char('user_id',11); 

            $table->string('ip_v4', 45)->nullable();
            $table->string('sistema_operacional')->nullable();
            $table->string('navegador')->nullable();
            $table->string('navegador_versao')->nullable();
            $table->string('host')->nullable();

            $table->string('imei')->nullable();
            $table->string('uid')->nullable();
            $table->string('imsi')->nullable();
            $table->string('iccid')->nullable();
            $table->string('mac')->nullable();
            $table->string('version')->nullable();
            $table->string('serial')->nullable();


            $table->string('latitude', 100)->nullable();
            $table->string('longitude', 100)->nullable();

            $table->string('password');
            $table->timestamps();


            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_login_log');
    }
}
