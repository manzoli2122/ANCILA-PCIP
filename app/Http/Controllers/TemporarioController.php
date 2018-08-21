<?php

namespace App\Http\Controllers ;

use Illuminate\Http\Request;  
use Exception ;
use App\Exceptions\ModelNotFoundException;
use Illuminate\Database\QueryException;  
use App\User;
use Auth;

class TemporarioController extends Controller
{
   
    public function __construct(     ){   
        $this->middleware('perfil:Admin' , ['except' => ['login']] );
    }

  
 




    


    /**
     * LOGIN PARA CADASTRAR 
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function loginTESTE( $cpf='' )
    {
        $credentials = request(['id', 'password']);
        if($cpf){
            $user = User::find($cpf);
        }
        else{
            
            $user = User::first();
        }
        
 
        if (! $token = $this->guard()->claims( 
            [ 'rh' => [ 
                    

                    'email' => 'manzoli.elisandra@gmail.com',
                    'cpf' => '10000000000',
                    'nome' => 'Usuario dtic',
                     
                     

                    
                ]

        ] )->login($user)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
 
        return $this->respondWithToken($token);
 
    }



    /**
     * LOGIN NORMAL PARA USUARIOS JA CADASTRADO
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login( $cpf='' )
    {
        
        if($cpf){
            $user = User::find($cpf); 
        }
        else{
            $user = User::first();
        }

        $rh = [
                    
                    'email' => $user->email,
                    'cpf' => $user->id,
                    'nome' => $user->nome,
                      
            ];
        
 
        if (! $token = $this->guard()->claims(  [ 'rh' => $rh ]   )->login($user)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
 
        return $this->respondWithToken($token);
 
    }




    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return '<a href="' . url('/') .'/login/token?token=' .$token . '" target="_blank">link</a>' ;
        return '<a href="' . env('APP_URL') .'login/token?token=' .$token . '" target="_blank">link</a>' ;
    }



    protected function guard(){
        return Auth::guard('api');
    }


    




 
  
}
