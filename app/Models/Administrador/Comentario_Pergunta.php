<?php

namespace App\Models\Administrador;

use Illuminate\Database\Eloquent\Model; 

use Illuminate\Database\Eloquent\SoftDeletes;


class Comentario_Pergunta extends Model  
{
    
    use SoftDeletes;

    
    protected $table = 'comentario_pergunta'; 


    protected $fillable = [
            'user_id', 'texto',  'pergunta_id' , 'status'
    ];

    protected $hidden = [
            'created_at',   'deleted_at' ,     'updated_at' ,
    ];


    public function pergunta(){
        return $this->belongsTo('App\Models\Administrador\Pergunta', 'pergunta_id');
    }


     public function usuario()
    {
        return $this->belongsTo('App\User',   'user_id' );
    }


    public function rules($id = ''){
        return [
            'texto' => 'required|min:1|max:1500',              
        ];
    }



    
    public function getDatatable(){
        return $this->withTrashed()->with('usuario')->select([ 'id' , 'texto' ,  'pergunta_id',  'deleted_at' , 'status' , 'user_id']);        
    }
    
   




    
}
