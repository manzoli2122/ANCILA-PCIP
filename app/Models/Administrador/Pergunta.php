<?php

namespace App\Models\Administrador;

use Illuminate\Database\Eloquent\Model; 

use Illuminate\Database\Eloquent\SoftDeletes;


class Pergunta extends Model  
{
    
    use SoftDeletes;

    
    protected $table = 'pergunta'; 


    protected $fillable = [
            'texto',  'resposta_certa_id' , 'assunto_id' , 'resumo' , 'ativo' , 'dificuldade', 'status', 
    ];

    protected $casts = [
        'resposta_certa_id' => 'int',
        'ativo' => 'boolean', 
    ];

    protected $hidden = [
            'created_at' ,     'updated_at' ,
    ];

    // public function assunto(){
    //     return $this->belongsTo('App\Models\Assunto', 'assunto_id') ;
    // }


    public function assunto(){
        return $this->belongsTo('App\Models\Administrador\Assunto', 'assunto_id')->select('id' , 'nome' , 'disciplina_id'); //->with('disciplina');
    }






    public function resposta_correta(){
        return $this->belongsTo('App\Models\Administrador\Resposta', 'resposta_certa_id');
    }


    public function resposta(){
        //return $this->belongsToMany( 'App\User' ,  'perfils_users' ,  'perfil_id' ,  'user_id');
        return $this->hasMany('App\Models\Administrador\Resposta', 'pergunta_id', 'id');//->get()->shuffle();
       // return $this->belongsTo('App\Models\Disciplina', 'pergunta_id');
    }



    public function rules($id = ''){
        return [
            'texto' => 'required|min:3|max:5000',
            //'descricao' => 'required|min:3|max:150',                
        ];
    }


    public function scopeAtivo($query){
        return $query->where('ativo', 1);
    }

    
   


    public function getDatatable(){
        return $this->withTrashed()->with('resposta_correta')->with('resposta')->with('assunto')->select('pergunta.*'  ) ;        
    }
 
    


















     public function getDatatable1(){
        return $this->select([ 'id' ,  'texto',    ])->orderBy('id', 'asc');        
    }
    
   
    public function getDatatable2(){
        return $this->select([ 'pergunta.id' ,  'pergunta.texto',  'assunto.nome'  ])->orderBy('id', 'asc')
                    ->leftJoin('assunto', 'assunto.id', '=', 'pergunta.assunto_id')
                    ->groupBy('pergunta.id' , 'pergunta.texto' , 'assunto.nome' );        
    }


    public function getDatatable3(){
        return $this->with('assunto')->select([ 'pergunta.id' ,  'pergunta.texto'  ])->orderBy('id', 'asc') ;        
    }
}
