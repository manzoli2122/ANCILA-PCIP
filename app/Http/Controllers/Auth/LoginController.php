<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;  
use App\User;
use App\Models\Mailable; 
use App\Mail\LoginSuccessMail; 
use Illuminate\Support\Facades\Mail; 
 



use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Exception;
 


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;



    



    /**
     * url de redirecionamento do usuario após o login.
     *
     * @var string
    */
    protected $redirectTo = '/';







    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    	$this->middleware('guest')->except('logout' );
        // $this->middleware('guest')->except('logout' ,'authenticate' );
    }








    /**
     * Função para retornar quando neccesitar de fazer login
     * vai para pagina de erro de autenticação onde contém
     * informações de como logar no sistema.
     * 
     *
     * @return \Exception 401
    */
    // public function showLoginForm()
    // {
    // 	abort(401 , "Falha de Autenticação!!" );  
    // }
    // Invalida a função login tradicional
    // public function login(Request $request)
    // {
    // 	abort(401 , "Falha de Autenticação!!" );  
    // }








    /**
     *  Retorna o nome do campo usuado para localizar um usuário
     * 
     *
     * @return string 
    */
    public function username(){
    	return 'id';
    } 









    /**
     *
     * Função para autenticar um usuario via token
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
    */
    public function authenticate(Request $request)
    {

    	$credentials = $request->only('token');

    	if(!$credentials){ 
            abort(401 , "Falha de Autenticação - token vazio!!" );
    	}

    	try{
    		$payload = Auth::guard('api')->payload();  
    		if(!$user = User::withoutGlobalScope('ativo')->find($payload['sub'])){
                abort(401 , "Falha de Autenticação - O usuário esta inativo no sistema, entre em contato com administrador para ativa-lo!!" );
    			$user = $this->cadastro( $request, $payload['rh'] );
            }
            else{
                if($user->status === 'I'  ){
                    abort(401 , "Falha de Autenticação - O usuário esta inativo no sistema, entre em contato com administrador para ativa-lo!!" );
                }
                //$this->atualizarCadastro( $request, $payload['rh'] , $user );
            }

    		//FIX-ME TESTAR VIA TOKEN DO SCA
    		//Auth::guard('web')->loginUsingId( $user->id );
            //Auth::guard('web')->loginUsingId( Auth::guard('api')->user()->id );
    		Auth::guard('web')->loginUsingId( $payload['sub'] ); 
    		$this->authenticated( $request, Auth::guard('web')->user() ); 
    		return  redirect()->intended('/');

    	}
    	catch(TokenInvalidException $e){ 
            abort(401 , "Falha de Autenticação - Token Invalido!!" );
    	}
    	catch(TokenExpiredException $e){ 
            abort(401 , "Falha de Autenticação - Token expirado!!" );
    	}
    	catch(JWTException $e){ 
    		abort(401 , "Falha de Autenticação - Token vazio!!" );
    	} 
    	catch(Exception $e){ 
    		abort(401 , "Falha de Autenticação!!" );
    	} 

    }





     







    /**
     * Função chamada logo após o usuário ser autenticado
     * notifica o usuário do acesso realizado.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @param   App\User $usuario 
     * 
     */
    protected function authenticated(Request $request, User $usuario)
    {
    	if($usuario->hasMailable('Login') and  $usuario->email!== ''  ){
    		Mail::to($usuario->email)->send(new LoginSuccessMail( $usuario ));
    	}
    	 
    }

 


}
