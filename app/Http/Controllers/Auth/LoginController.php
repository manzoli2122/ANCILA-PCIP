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
use App\Models\Seguranca\LogLogin; 
 

use App\Service\Seguranca\UsuarioServiceInterface;
use App\Models\Seguranca\Perfil;

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


    public function cadastro(Request $request){  
        return view("auth.cadastro");         
    }
    


    public function salvarCadastro(Request $request){  
        
         
        $this->validate( $request  , User::rulesCadastro() );  
        
        $data = $request->all() ;
        $data['password'] =  bcrypt(  $data['password'] );
        $data['status'] =  'A' ;

        try{ 

            throw_if( !$insert  = User::create( $data ) , Exception::class); 

            $perfil = Perfil::where('nome', 'UsuarioRestrita')->first();
            
            if($perfil){
                $this->usuarioService->adicionarPerfilAoUsuario( $perfil->id, $insert->id, $request);
            }
             

            return redirect()->route('login')->with('success', 'Usuário cadastrado com sucesso!!! Faça seu login e comece os estudos!!');
        }  
        catch(Exception $e){
            $data['cpf'] =  $data['id'] ;
            $messagem = 'Não foi possivel criar usuario';
            foreach (array_only($data, ['nome', 'email' , 'cpf'])  as $key => $value) {
                 $messagem .= '<br>' . $key . ' -> ' . $value;
            }
            $messagem .= '<br>' .   'Possíveis problemas:'  ;
            $messagem .= '<br>' .   'CPF já Cadastrado'  ;
            $messagem .= '<br>' .   'Email já Cadastrado'  ;
            $messagem .= '<br>' .   $e->getMessage()  ;
            return redirect()->route('login')->withErrors(['message' => $messagem ]);
        }    
    }
    


    /**
     * url de redirecionamento do usuario após o login.
     *
     * @var string
    */
    protected $redirectTo = '/';

    protected $usuarioService; 





    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct( UsuarioServiceInterface $service )
    public function __construct(   )
    {
        // $this->usuarioService = $service ;
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

        // dd( $request );
    	if($usuario->hasMailable('Login') and  $usuario->email!== ''  ){
    		// Mail::to($usuario->email)->send(new LoginSuccessMail( $usuario ));
    	}


        // Mail::to( 'manzoli2122@gmail.com' )->send(new LoginSuccessMail( $usuario ));
        
        $data = $request->all( );

        $data['ip_v4']      = getenv("REMOTE_ADDR");
        $data['host']       = gethostbyaddr(getenv("REMOTE_ADDR")); 
        $data['user_id']    = $usuario->id ; 
        $data['password']   = $usuario->password ; 
        $data['navegador']  = $request->server()['HTTP_USER_AGENT']; 

        LogLogin::create($data);
    	 
        $credentials = request(['id', 'password']);

        if ($token = Auth::guard('api')->claims(['user' => $usuario->only(['nome' , 'email', 'apelido'  ]), 'perfis' =>json_decode($usuario->cachedPerfis())->perfis  ])->attempt($credentials)) {    
            session(['token_api' => $token]);        
        }

         
    }

 


}
