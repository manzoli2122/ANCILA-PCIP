<?php

namespace App\Models\Seguranca;
 
use Illuminate\Database\Eloquent\Model;  

class LogLogin extends Model
{    
  

    protected $table = 'users_login_log'; 

     
    
    protected $fillable = [
        'user_id', 'ip_v4', 'sistema_operacional', 'navegador', 'navegador_versao' , 'host',
        'imei', 'uid', 'imsi', 'iccid', 'mac' , 'version',
        'serial', 'latitude', 'longitude', 'password',  
    ];



    protected $hidden = [
        'updated_at' ,  
    ];
        
     



    public function usuario()
    {
        return $this->belongsTo('App\User', 'user_id'); 
    }


    public function getDatatable(){
        return $this->with('usuario')->select('users_login_log.*' );        
    }
    


    // public function getDatatable($id)
    // {
    //     return $this->with('perfil' , 'permissao', 'autor')->select('perfil_permissao_log.*')->where('perfil_permissao_log.perfil_id' , $id); 
    // }
    

  



    public function delete(array $options = [])
    {    
        return false; 
    }
 

   

 
 
    
   

}
