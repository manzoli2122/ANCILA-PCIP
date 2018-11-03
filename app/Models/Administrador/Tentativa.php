<?php

namespace App\Models\Administrador;

use Illuminate\Database\Eloquent\Model; 

use Illuminate\Database\Eloquent\SoftDeletes;


class Tentativa extends Model  
{
    
    use SoftDeletes;

    
    protected $table = 'users_resposta_pergunta'; 


    protected $fillable = [
            'user_id',  'pergunta_id' , 'disciplina_id', 'resposta_id', 'acerto'
    ];

    protected $hidden = [
               'deleted_at' ,     'updated_at' ,
    ];




    public function pergunta(){
        return $this->belongsTo('App\Models\Administrador\Pergunta', 'pergunta_id');
    }


 	 public function resposta(){
         return $this->belongsTo('App\Models\Administrador\Resposta', 'resposta_id');
    }

    public function disciplina(){
        return $this->belongsTo('App\Models\Administrador\Disciplina', 'disciplina_id')->withTrashed();
    }


    public function usuario()
    {
        return $this->belongsTo('App\User',   'user_id' );
    }



    
    public function getDatatable12(){
        return $this->withTrashed()->with('usuario')->with('disciplina')->select([ 'id' , 'user_id' ,  'pergunta_id',  'disciplina_id', 'resposta_id', 'acerto']);        
    }
    
   

     public function getDatatable(){
        return $this->withTrashed()->with('usuario')->with('disciplina')->select('users_resposta_pergunta.*' );        
    }
    


    
}
