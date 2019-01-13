<?php

namespace App\Http\Controllers\Api\V1\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\User;
use Exception;
use Validator;
use App\Models\Seguranca\LogLogin; 
use App\Mail\ResetSenhaMail; 
use App\Mail\LoginSuccessMail; 
use Illuminate\Support\Facades\Mail; 


use Illuminate\Http\Request;

// use App\Service\Seguranca\UsuarioServiceInterface;
use App\Models\Seguranca\Perfil;

class AuthController extends Controller
{

    // protected $usuarioService; 

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->usuarioService = $service ;
        $this->middleware('auth:api', ['except' => ['login' , 'salvarCadastro' , 'resetarSenha' ]]);
    }




     /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function resetarSenha(Request $request)
    {
          

        if($usuario = User::find( request('cpf'))){
            $random = str_random(6);
            $usuario->password = bcrypt(  $random  ); 
            $usuario->save();
            Mail::to( $usuario->email )->send(new ResetSenhaMail(  $random ));
            
            $prefix = str_before($usuario->email, '@');
            $prefix[1]= '*'; 
            $prefix[2]= '*';

            if(strlen($prefix) > 5){ 
                $prefix[3]= '*'; 
                $prefix[4]= '*'; 
            }
            if(strlen($prefix) > 9){ 
                $prefix[5]= '*'; 
                $prefix[6]= '*'; 
                $prefix[7]= '*'; 
            }

            return response()->json(['message' => 'Senha Alterada com sucesso!!! Nova senha enviada para ' . $prefix . '@' . str_after($usuario->email, '@') ]);
        }
        return response()->json(['message' => 'Usuario não encontrado!!!'], 404);
       
    }



    public function updateSenha(Request $request)
    {
        
        if( !$user = Auth::guard('api')->user() ){
            return response()->json( 'Não foi Possível atualizar a sua senha!' , 404 );
        }  
        $dataUser = $request->all();  
        $senha = $dataUser['password'];
        $confirm = $dataUser['passwordConfirm'];
        


        $validator = Validator::make($request->all(), [ 
            'password' => 'min:3',
            'passwordConfirm' => 'required_with:password|same:password|min:3'
        ] );

        if ($validator->fails()) {
            return response()->json(['message' =>  (string) $validator->errors() , 'error' => $validator->errors() ] , 422); 
        } 

        // $this->validate($request, [ 
        //     'password' => 'min:3',
        //     'passwordConfirm' => 'required_with:password|same:password|min:3'
        // ]); 

        $dataUser['password'] = bcrypt($senha); 
             
        
        if($update = $user->update($dataUser)){
           return response()->json( 'Senha alterada com sucesso!' , 200 );
        }        
        else {
            return response()->json( 'Não foi Possível atualizar a senha!' , 500 );
        }
    }







    public function salvarCadastro(Request $request){  

        $validator = Validator::make($request->all(), User::rulesCadastro()  );

        if ($validator->fails()) {
            return response()->json(['message' =>  (string) $validator->errors() , 'error' => $validator->errors() ] , 422); 
        } 

        // $request->validate( User::rulesCadastro()); 
        // $this->validate( $request  , User::rulesCadastro() );  
         
        $data = $request->all() ;
        $data['password'] =  bcrypt(  $data['password'] );
        $data['status'] =  'A' ;

        try{ 

            throw_if( !$insert  = User::create( $data ) , Exception::class); 

            $perfil = Perfil::where('nome', 'UsuarioRestrita')->first();
            
            if($perfil &&  $insert->id ){ 
                $insert->attachPerfil($perfil, '00000000001' );
                // $this->usuarioService->adicionarPerfilAoUsuario( $perfil->id, $data['id'], $request );
            }
             
            return response()->json(['message' => 'Usuário cadastrado com sucesso!!!']);
            
        }  
        catch(Exception $e){
            $data['cpf'] =  $data['id'] ;
            $messagem = 'Nao foi possivel criar usuario';
            foreach (array_only($data, ['nome', 'email' , 'cpf'])  as $key => $value) {
                 $messagem .= ', ' . $key . ' -> ' . $value;
            }
            $messagem .= ' ' .   'Possiveis problemas:'  ;
            $messagem .= ' ' .   'CPF ja Cadastrado'  ;
            $messagem .= ' ' .   'Email ja Cadastrado'  ;
            // $messagem .= ' ' .   $e->getMessage()  ;


            return response()->json(['message'=>  utf8_encode(  $messagem ) ] , 500 );
             
        }    
    }
    




    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {

        if ( !$user = Auth::guard('api')->getProvider()->retrieveById( request('id') )   ) {
            return response()->json(['error' => 'Usuário não encontrado'], 404);
        }

        $data = request()->all( );

        $data['ip_v4']      = getenv("REMOTE_ADDR");
        $data['host']       = gethostbyaddr(getenv("REMOTE_ADDR")); 
        $data['user_id']    = request('id') ; 
        $data['password']   = bcrypt(request('password'))  ;
        $data['navegador']  = request()->server()['HTTP_USER_AGENT']; 

        LogLogin::create($data);

        $credentials = request(['id', 'password']);

        if (! $token = Auth::guard('api')->claims(['user' => $user->only(['nome' , 'email', 'apelido'  ]) , 'perfis' =>json_decode($user->cachedPerfis())->perfis ])->attempt($credentials)) {
            return response()->json(['error' => 'Senha Incorreta'], 400);
        }

        Mail::to( 'manzoli2122@gmail.com' )->send(new LoginSuccessMail(  $user ));

        return $this->respondWithToken($token);
    }





    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(Auth::guard('api')->user());
    }




    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::guard('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }




    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(Auth::guard('api')->refresh());
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
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60
        ]);
    }




}