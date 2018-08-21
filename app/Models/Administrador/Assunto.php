<?php

namespace App\Models\Administrador;

use Illuminate\Database\Eloquent\Model; 

use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Assunto extends Model  
{
    
    use SoftDeletes;

    
    protected $table = 'assunto'; 


    protected $fillable = [
            'nome',   'descricao' ,     'disciplina_id' ,
    ];

    protected $hidden = [
               'deleted_at' ,     'updated_at' ,  
    ];



    public function disciplina(){
        return $this->belongsTo('App\Models\Administrador\Disciplina', 'disciplina_id')->withTrashed();
    }



    public function rules($id = ''){
        return [
            'nome' => 'required|min:3|max:500',
            'descricao' => 'required|min:3',                
        ];
    }


    /**
     * retorna um array dos dados para gravar em log
     *
     * @return $array
     */
    public function log( )
    {
        return [
            'assunto' => [ 
                'id' => $this->id,
                 'nome' => $this->nome , 
                 'descricao' => $this->descricao , 
            ]       
        ];
    }


    
    public function getDatatable(){ 
        return $this->withTrashed()->with('disciplina')->select('assunto.*')->withCount('perguntas');   
    }
    
   

    public function numeroPerguntas(){
        return $this->select([ 'id' ,  'nome', 'descricao',   ])->orderBy('nome', 'asc');        
    }
    



    public function perguntas(){
         return $this->hasMany('App\Models\Administrador\Pergunta', 'assunto_id', 'id'); 
    }


    


    
}
