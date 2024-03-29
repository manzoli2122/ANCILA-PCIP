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
    * Função para buscar log de perfis do usuario
    *
    * @param Request $request
    *  
    * @param int  $userId 
    *
    * @return json
    */
    public function carregaBanco(   ){
 
         

        $ch = curl_init();
        $options = array(
            // CURLOPT_URL => 'http://sgpm.rh.dcpm.es.gov.br/api/v1/efetivoativo/228/qdi', 
            CURLOPT_URL => 'http://sgpm.rh.dcpm.es.gov.br/api/v1/efetivoativo', 
            
            //CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array('Content-type: application/json'),
            //CURLOPT_POSTFIELDS => $postString
        );
        if (defined('CURLOPT_SAFE_UPLOAD')) {
            $options[CURLOPT_SAFE_UPLOAD] = true;
        } 
        curl_setopt_array($ch, $options); 

        $result = curl_exec($ch) ;
        if ( $result === false) {
            $curlErrno = curl_errno($ch); 
            $curlError = curl_error($ch); 
            Log::error( sprintf('Curl error (code %s): %s', $curlErrno, $curlError) );
            curl_close($ch); 
            return  $result  ;
        }  else{ 
            $resultJson = json_decode( $result );  
            foreach($resultJson as $me ){
                if( $me->cpf!='' and $me->usuario_email !=''){
                    $me->id =  $me->cpf;
                    $this->cadastroTeste(   $me);
                }
                
            }
            




            if( isset($resultJson->error)  ){
                //Log::warning( 'Error de inserção de dados no elastic -> ' .  $result . ' Dados -> ' .  $postString );
            }
            curl_close($ch);  
            return  $resultJson  ;
        }

        
    }





     /**
     * FIX-ME ADICIONAR ENVIO DE EMAIL DE CADASTRO
     *  Função para realizar o cadastro de um usuario no sistema
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @param  Array  $payload
     *
     * @return Response
    */
    public function cadastroTeste(  $payload)
    {
        //cria o usuario
    	$user = User::create(
    		[
    			'id' => $payload->id ,
    			'name' => $payload->nome,
    			'rg' => $payload->rg,
    			'email' => $payload->usuario_email,
    			'nf' =>$payload->num_funcional,                
    			'quadro_dsc' =>$payload->quadro_dsc ,
    			'post_grad_dsc' => $payload->post_grad_dsc ,
    			'status' => 'A', 
                'password' => bcrypt('123456') ,   // FIX-ME ALTERAR A QUESTÃO DA SENHA
                'ome_qdi_id' =>  $payload->ome_qdi , 
                'ome_qdi_dsc'=>  $payload->ome_dsc , 
                'ome_qdi_lft' => $payload->ome_lft , 
                'ome_qdi_rgt' => $payload->ome_rgt ,  

                'setor_qdi_id' =>  $payload->setor_qdi , 
                'setor_qdi_dsc'=>  $payload->setor_dsc , 
                'setor_qdi_lft' => $payload->setor_lft , 
                'setor_qdi_rgt' => $payload->setor_rgt , 
                  
            ]
        ); 

        // envia dados do cadastro para o elasticsearch
    	if(env('LOG_ELASTIC_LOG')){
    		$info =   [   
    			'ip'   => '0.0.0.0',
    			'host' => '0.0.0.0',
    			'usuario' => '00000000001',
    		] ; 
    		dispatch( 
    			new FIlaElasticSearchLog('App\User', 'Cadastro', $user->logCompleto(), $info, now()->format('Y-m-d\TH:i:s.u') )
    		);  
    	}


    	return $user;

    }








    
        /**
    * Função para buscar log de perfis do usuario
    *
    * @param Request $request
    *  
    * @param int  $userId 
    *
    * @return json
    */
    public function carregaBancoCpf( $cpf  ){
 
         

        $ch = curl_init();
        $options = array(
            // CURLOPT_URL => 'http://sgpm.rh.dcpm.es.gov.br/api/v1/efetivoativo/228/qdi', 
            CURLOPT_URL => 'http://sgpm.rh.dcpm.es.gov.br/api/v1/efetivoativo/' . $cpf .'/registro', 
            
            //CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array('Content-type: application/json'),
            //CURLOPT_POSTFIELDS => $postString
        );
        if (defined('CURLOPT_SAFE_UPLOAD')) {
            $options[CURLOPT_SAFE_UPLOAD] = true;
        } 
        curl_setopt_array($ch, $options); 

        $result = curl_exec($ch) ;
        if ( $result === false) {
            $curlErrno = curl_errno($ch); 
            $curlError = curl_error($ch); 
            Log::error( sprintf('Curl error (code %s): %s', $curlErrno, $curlError) );
            curl_close($ch); 
            return  $result  ;
        }  else{ 
            $resultJson = json_decode( $result );  
            foreach($resultJson as $me ){
                if( $me->cpf!='' and $me->usuario_email !=''){
                    $me->id =  $me->cpf;
                    $this->cadastroTeste(   $me);
                }
                
            }
             
            if( isset($resultJson->error)  ){
                //Log::warning( 'Error de inserção de dados no elastic -> ' .  $result . ' Dados -> ' .  $postString );
            }
            curl_close($ch);  
            return  $resultJson  ;
        }

        
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
            //$user = User::find('10000000000');
            //$user = User::find('81780486715'); // 1 bpm
            $user = User::first();
        }
        
 
        if (! $token = $this->guard()->claims( 
            [ 'rh' => [ 
                    'cargo' => "CEL",
                    'cargoId' => 1,

                    'email' => 'manzoli.elisandra@gmail.com',
                    'cpf' => '10000000000',
                    'nome' => 'Usuario dtic',
                     
                    'numeroFuncional' => 1000001,                
                    'quadro' =>'Admin',
                    'rg' => 1001,

                    'setorId' =>1 ,    
                    'setor'=> 'PMES' ,    
                    'setorLeftId' => 1 ,   
                    'setorRightId' => 10000 , 

                    'situacaoId' => 2 , 
                    'situacao' => 'ATIVO' , 

                    'unidadeId' => 1 , 
                    'unidade'=> 'PMES' , 
                    'unidadeLeftId' => 1, 
                    'unidadeRightId' => 10000,  

                    
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
        $credentials = request(['id', 'password']);
        if($cpf){
            $user = User::find($cpf); 
        }
        else{
            $user = User::first();
        }

        $rh = [
                    'cargo' => $user->cargo,
                    'cargoId' =>$user->cargoId,

                    'email' => $user->email,
                    'cpf' => $user->id,
                    'nome' => $user->nome,
                     
                    'numeroFuncional' => $user->numeroFuncional,                
                    'quadro' =>$user->quadro,
                    'rg' => $user->rg,

                    'setorId' =>$user->setorId ,    
                    'setor'=> $user->setor ,    
                    'setorLeftId' => $user->setorLeftId ,   
                    'setorRightId' => $user->setorRightId , 

                    'situacaoId' => $user->situacaoId, 
                    'situacao' => $user->situacao , 

                    'unidadeId' => $user->unidadeId , 
                    'unidade'=> $user->unidade , 
                    'unidadeLeftId' => $user->unidadeLeftId, 
                    'unidadeRightId' => $user->unidadeRightId ,  
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
