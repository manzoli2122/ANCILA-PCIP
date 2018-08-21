<?php

namespace App\Models\Administrador;

use Illuminate\Database\Eloquent\Model; 

use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Disciplina extends Model  
{
    
    use SoftDeletes;

    
    protected $table = 'disciplina'; 


    protected $fillable = [
            'nome',   'descricao' 
    ];


    protected $hidden = [
              'deleted_at' ,     'updated_at' ,
    ];





    public function rules($id = ''){
        return [
            'nome' => 'required|min:3|max:191',
            'descricao' => 'required|min:3|max:500',                
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
            'disciplina' => [ 
                'id' => $this->id,
                 'nome' => $this->nome , 
                 'descricao' => $this->descricao , 
            ]       
        ];
    }


    
    public function getDatatable(){
        return $this->withTrashed()->select([ 'id' ,  'nome', 'descricao', 
          DB::raw("CASE  WHEN deleted_at is null THEN 'Ativo' ELSE 'Inativo' END AS status ")  ]) ;        
    }
    
   


    public function assuntos(){
         return $this->hasMany('App\Models\Administrador\Assunto', 'disciplina_id', 'id'); 
    }


    
}
