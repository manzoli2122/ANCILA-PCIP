<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        


        DB::table('perfils')->insert([
            'nome' => 'Admin',
            'descricao' =>  'Admin', 
        ]);



        DB::table('users')->insert([ 
            'id' => '00000000001',
            'nome' => 'Administrador.dtic',
            'apelido' => 'Administrador',
            'email' => 'manzoli2122@gmail.com', 
            'status' => 'A',  
            'password' => bcrypt('123')
        ]);




        DB::table('perfils_users')->insert([
            'perfil_id' => 1,
            'user_id' => '00000000001' , 
        ]);
        

         
        DB::table('perfils')->insert([
            'nome' => 'Professor',
            'descricao' =>  'Professor', 
        ]);
          
        DB::table('perfils')->insert([
            'nome' => 'Gerente',
            'descricao' =>  'Gerente', 
        ]);


        DB::table('perfils')->insert([
            'nome' => 'Diretor',
            'descricao' =>  'Diretor', 
        ]);


        DB::table('permissoes')->insert([
            'nome' => 'perfis',
            'descricao' =>  'perfis', 
        ]);



        DB::table('mailable')->insert([ 
            'nome' =>  'Login', 
            'descricao' =>  'Envio de email a cada acesso', 
        ]);

        DB::table('mailable')->insert([ 
            'nome' =>  'Perfil', 
            'descricao' =>  'Envio de email ao ser adicionado ou retirado um perfil do Usuário', 
        ]);


        DB::table('users_mailable')->insert([
            'mailable_id' => 1,
            'user_id' => '00000000001' , 
        ]);

        DB::table('users_mailable')->insert([
            'mailable_id' => 2,
            'user_id' => '00000000001' , 
        ]);

    }
}
