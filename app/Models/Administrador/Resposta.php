<?php

namespace App\Models\Administrador;

use Illuminate\Database\Eloquent\Model; 

use Illuminate\Database\Eloquent\SoftDeletes;


class Resposta extends Model  
{
    
    use SoftDeletes;

    
    protected $table = 'resposta'; 


    protected $fillable = [
            'texto',  'pergunta_id' , 'count'
    ];

    protected $hidden = [
            'created_at',   'deleted_at' ,     'updated_at' ,
    ];

    public function pergunta(){
        return $this->belongsTo('App\Models\Administrador\Pergunta', 'pergunta_id');
    }



    public function rules($id = ''){
        return [
            'texto' => 'required|min:1|max:1000',              
        ];
    }



    
    public function getDatatable(){
        return $this->withTrashed()->select([ 'id' , 'texto' ,  'pergunta_id', 'count',  'deleted_at' ]);        
    }
    
   




    
}
