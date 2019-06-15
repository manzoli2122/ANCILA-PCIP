<?php

namespace  App\Http\Controllers\Api\V1\Seguranca;


use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\VueCrudController;   
use Yajra\DataTables\DataTables;
use Validator; 
use App\User;
use App\Models\Seguranca\Perfil;
use App\Models\Seguranca\LogUsuarioPerfil;
use Exception;
use Auth;
use Log;
use Illuminate\Support\Facades\Mail;  
 




class UsuarioController extends VueCrudController
{

     protected $perfil;
     protected $logSeguranca;


	public function __construct( User $user , Perfil $perfil , LogUsuarioPerfil $log , DataTables $dataTable   ){ 

		$this->model = $user ;   
		$this->perfil = $perfil ;
		$this->logSeguranca = $log ;   
		$this->dataTable = $dataTable ; 
		$this->route = 'usuario';  

		$this->middleware('auth:api', ['except' => [''] ]);

        // $this->middleware('permissao:usuarios');  
        // $this->middleware('perfil:Admin')->only('update', 'destroy' , 'excluirPerfilDoUsuario' , 'adicionarPerfilAoUsuario' , 'ResetarSenha'); 

	}





	/**
    * Função para Adicionar um Perfil a um usuario atraves do UsuarioServiceInterface
    *
    * @param Request $request
    *  
    * @param int  $userId
    *    
    * @return json
    */
	public function adicionarPerfilAoUsuario(Request $request , $userId)
	{     
		if( !$usuario = $this->model->find($userId) ){
			return response()->json('Item não encontrado.', 404 );
		} 
		$perfilId = $request->get('perfil'); 
		if( !$perfil = $this->perfil->find( $perfilId ) ){
			return response()->json('Item não encontrado.', 404 );
		} 
		if( $perfil->nome == 'Admin' and !Auth::guard('api')->user()->hasPerfil('Admin')){
			abort(403, 'Você não tem permissão para adicionar o perfil Admin.');
		} 
		if(Auth::guard('api')->check()){
			$usuario->attachPerfil($perfil, Auth::guard('api')->user()->id );
			$this->Log( $perfilId , $userId  , Auth::guard('api')->user()->id , 'Adicionar' );  
		}
		else {
			if($userId){
				$usuario->attachPerfil($perfil, '00000000001' );
				$this->Log( $perfilId , $userId  ,'00000000001' , 'Adicionar' ); 
			} 
		} 
		return  $this->BuscarPerfisParaAdicionar( $userId ) ;
	}







    /**
    * Função para ativar um usuario ja existente  
    *
    * @param Request $request
    *  
    * @param int  $id
    *    
    * @return void
    */
    public function  Ativar( Request $request , $userId ){ 
    	if(!$model = $this->model->withoutGlobalScope('ativo')->find($userId)){
    		return response()->json('Item não encontrado.', 404 );
    	}
    	$model->status = 'A';
    	$model->save(); 
    	return response()->json( 'Ativado' , 200 ); 
    }






    /**
    * Função para buscar os logs de perfis de um usuario pelo datatable
    *
    * @param Request $request 
    *  
    * @param int  $userId 
    *
    * @return json
    */
    public function BuscarPerfilDataTableLog( Request $request , $userId )
    {     
    	try {   
    		$models = $this->logSeguranca->getDatatable($userId);  
    		return $this->dataTable
    		->eloquent($models)
    		->editColumn('created_at', function ($log) {
    			return $log->created_at->format('d/m/Y H:i');
    		})
    		->filterColumn('created_at', function ($query, $keyword) {
    			$query->whereRaw("DATE_FORMAT(created_at,'%d/%m/%Y %H:%i') like ?", ["%$keyword%"]);
    		})
    		->make(true);          

    	}         
    	catch (Exception $e) {           
    		return response()->json( $e->getMessage() , 500);
    	}   
    }







    /**
    * Função para buscar os perfis que o usuario ainda não tem
    * 
    * @param int  $userId 
    *
    * @return List $perfis
    */
    public function BuscarPerfisParaAdicionar($userId)
    {    
    	try {            
    		return response()->json($this->perfil->perfisParaAdicionarAoUsuario($userId, Auth::guard('api')->user()->hasPerfil('Admin') ) , 200);
    	}         
    	catch(Exception $e) {           
    		return response()->json( $e, 500);    
    	}   
    }






    /**
    * Função para buscar os perfis de um usuario pelo datatable
    *
    * @param Request $request 
    *  
    * @param int  $userId 
    *
    * @return json
    */
    public function BuscarPerfilDataTable( Request $request , $userId )
    {     
    	try {            
    		$usuario = $this->model->find($userId); 
    		$models = $usuario->perfis( ); 
    		return $this->dataTable->eloquent($models)
    		->addColumn('action', function($linha) {
    			return  
    			'<button data-id="'.$linha->perfil_id.'" btn-excluir class="btn btn-danger btn-sm" title="Excluir"><i class="fa fa-trash"></i></button>' 
    			;
    		})
    		->make(true);  

    	}         
    	catch (Exception $e) {           
    		return response()->json( $e->getMessage() , 500);
    	}   
    }





    /**
    * Função para buscar os perfis de um usuario pelo datatable
    *
    * @param Request $request 
    *  
    * @param int  $userId 
    *
    * @return json
    */
    // public function  BuscarPerfilTransferirDataTable( $request , $userId ){ 
    // 	$usuario = $this->model->find($userId); 
    // 	$models = $usuario->perfis( ); 
    // 	return $this->dataTable->eloquent($models)
    // 	->addColumn('action', function($linha) use( $request) {
    // 		if(Auth::guard('api')->user()->hasPerfil($linha->nome)){
    // 			return  
    // 			'<button data-id="'.$linha->perfil_id.'" btn-excluir class="btn btn-danger btn-sm" title="Excluir"><i class="fa fa-trash"></i></button>' 
    // 			;
    // 		}
    // 		return  
    // 		'';
    // 	})
    // 	->make(true);  
    // }







    /**
    * Função para desativar um usuario ja existente  
    *
    * @param Request $request
    *  
    * @param int  $id
    *    
    * @return void
    */
    public function  Desativar( Request $request , $userId ){
    	
    	if( Auth::guard('api')->user()->id ===  $userId  ){
    		return response()->json('Operação não permitida.', 403 );
    	}
    	if( !$model = $this->model->find($userId) ){
    		return response()->json('Item não encontrado.', 404 );
    	}
    	$model->status = 'I';
    	$model->save();  

    	return response()->json( 'Destivado' , 200 );
    }







    /**
    * Função para excluir um model
    *
    * @param Request $request
    *   
    * @param int  $id
    *    
    * @return json
    */
    public function destroy( Request $request, $id)
    {  
    	try{  
    		if( !$model = $this->model->withoutGlobalScope('ativo')->find($id) ){
    			return response()->json( 'Item não encontrado' , 404);
    		}
    		if( !$delete = $model->forceDelete() ){
    			return response()->json([ 'message' => 'Erro ao excluir o registro!' ], 500);
    		} 
    		return response()->json( 'Exclusão realizada com sucesso' , 200); 
    	}  
    	catch(QueryException $e){
    		return response()->json([ 'message' => 'Erro de conexao com o banco' ] , 500 );
    	} 
    	catch(Exception $e){
    		return response()->json([ 'message' => $e->getMessage() ], 500);
    	}  
    }







    /**
    * Função para retirar um Perfil de um usuario  atraves do UsuarioServiceInterface
    *
    * @param Request $request
    * 
    * @param int  $perfilId
    *  
    * @param int  $userId 
    *
    * @return json
    */
    public function excluirPerfilDoUsuario( Request $request , $userId , $perfilId )
    {        
    	if( !$usuario = $this->model->find($userId) ){
    		return response()->json('Item não encontrado.', 404 );
    	} 
    	 
    	if( !$perfil = $this->perfil->find( $perfilId ) ){
    		return response()->json('Item não encontrado.', 404 );
    	} 
    	if( $perfil->nome == 'Admin' and !Auth::guard('api')->user()->hasPerfil('Admin')){
    		abort(403, 'Você não tem permissão para remover o perfil Admin.');
    	} 
    	if( $perfil->nome == 'Admin' and  Auth::guard('api')->user()->id === $userId ){
    		abort(403, 'Não é possível remover o seu perfil Admin.'); 
    	} 
    	$usuario->detachPerfil($perfilId);  
    	$this->Log( $perfilId , $userId  , Auth::guard('api')->user()->id , 'Excluir' ); 
    	return  $this->BuscarPerfisParaAdicionar( $userId )  ;  
    }







    /**
    * Função para buscar models para datatable
    *
    * @param Request $request
    *   
    * @return json
    */
    public function getDatatable( Request $request ){
    	try {  
    		
    		$models = $this->model->getDatatable();
    		return $this->dataTable->eloquent($models)
    		->addColumn('action', function($linha) { 
    			if($linha->status === 'Inativo'){
    				return '<button data-id="'.$linha->id.'" btn-ativar class="btn btn-success btn-sm" title="Ativar"><i class="fa fa-unlock"></i> </button>'
    				.'<button data-id="'.$linha->id.'" btn-excluir class="btn btn-danger btn-sm" title="Excluir Definitivamente"><i class="fa fa-trash"></i></button>' ;
    			} 
    			return '<a href="#/'. $this->route . '/'.$linha->id.'/perfil" class="btn btn-primary btn-sm" title="Perfis"><i class="fa fa-id-card"></i></a> ' 

    			.'<a href="#" class="btn btn-warning btn-sm" title="Resetar Senha"><i class="fa fa-key"></i></a>'
    			.'<a href="#/'. $this->route . '/edit/'.$linha->id.'" class="btn btn-success btn-sm" title="Editar"><i class="fa fa-pencil"></i></a>'

    			.'<button data-id="'.$linha->id.'" btn-desativar class="btn btn-danger btn-sm" title="Destivar"><i class="fa fa-lock"></i></button>' ; 
    		})
    		->setRowClass(function ($user) {
    			return $user->status === 'Ativo' ? '' : 'alert-warning';
    		})

    		->editColumn('created_at', function ($user) {
    			return $user->created_at->format('Y/m/d');
    		})
    		->filterColumn('created_at', function ($query, $keyword) {
    			$query->whereRaw("DATE_FORMAT(created_at,'%Y/%m/%d') like ?", ["%$keyword%"]);
    		}) 
    		->make(true);  

    	}         
    	catch (Exception $e) {           
    		return response()->json( $e->getMessage() , 500);
    	} 
    }






    /**
    * Função para ResetarSenha um usuario ja existente  
    *
    * @param Request $request
    *  
    * @param int  $id
    *    
    * @return void
    */
    public function  ResetarSenha( Request $request , $userId ){ 
    	if(!$model = $this->model->withoutGlobalScope('ativo')->find($userId)) {
    		return response()->json('Item não encontrado.', 404 );
    	}
    	$model->password = bcrypt(  'pmes@123'  ); 
    	$model->save();  
    	return back();
    }








    /**
    * Função para criar um model
    *
    * @param Request $request
    *   
    * @return json
    */
    public function store(Request $request)
    {	 
    	$validator = Validator::make( $request->all(), $this->model->rules() ); 
    	if ($validator->fails()) {
    		return response()->json(['message' => (string) $validator->errors(), 'error' => $validator->errors() ], 422); 
    	}   
    	try{ 
    		$data = $request->all() ;
    		$data['password'] =  bcrypt(  $data['password'] ); 
    		if( !$insert  = $this->model->create( $data ) ){
    			return response()->json('Não foi possível cadastrar!' , 500);
    		} 
    	}  
    	catch(Exception $e){
    		return response()->json( $e->getMessage() , 500);
    	}   
    	return response()->json( 'Cadastro realizado com sucesso' , 200); 
    }






    /**
    * Função para  salvar em log 
    *
    * @param int  $perfilId
    *  
    * @param int  $userId
    *  
    * @param int  $autorId
    * 
    * @param string  $acao
    *  
    * @param string  $ip_v4
    * 
    * @param string  $host
    *
    * @return void
    */
    private function  Log( int $perfilId , string $userId  , string $autorId , string $acao  )
    {         
    	$log =  new LogUsuarioPerfil();
    	$log->user_id = $userId;
    	$log->autor_id = $autorId;
    	$log->perfil_id = $perfilId;
    	$log->acao = $acao ;
    	$log->ip_v4 = getenv("REMOTE_ADDR");
    	$log->host = gethostbyaddr(getenv("REMOTE_ADDR")); 
    	$log->save(); 
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
    // public function elasticsearch( Request $request , $userId  )
    // {        
    // 	$response = $this->service->elasticsearch(   $request , $userId  );  
    // 	return response()->json( $response  , 200);  
    // }


    

    /**
    * Função para gerar pdf dos usuarios 
    *
    * @param Request $request
    *   
    * @return pdf
    */
    public function  Pdf( Request $request ){

    	$models = $this->model->getDatatable();

    	$dados = $this->dataTable->eloquent($models)->make(true); 

    	$datas = $dados->getData()->data;

    	$pdf = new NewPdf();

    	$pdf::SetTitle("Batalhao Online da Policia Militar do ES");
    	$pdf::SetSubject("DTIC Sempre Presente, contruindo o seu futuro.");
        // $pdf ::SetAuthor('bruno'); 
        // $pdf ::SetKeywords('baon cco desempenho individual ');
        //Seta a posicao vertical e horizontal  
    	$pdf::SetY(-10);
    	$pdf::AddPage();
    	$pdf::AliasNbPages();
    	$pdf::SetAutoPageBreak(10, 10);

    	$pdf::SetFont('Arial', 'u', 11);

    	if (count($datas) > 1) {

            // Muda o tamanho da fonte
    		$pdf::SetFont('arial', '', 10);

            //linha do curso
    		$pdf::Cell(10, 3, " - ", 1, 0, 'C'); 
    		$pdf::Cell(60, 3, "Nome ", 1, 0, 'C');
    		$pdf::Cell(25, 3, "CPF ", 1, 1, 'C');

    		$pdf::SetFont('arial', '', 7);
    		$linha = 1;

    		foreach ($datas as $data) {
                //escreve no pdf largura,altura,conteudo,borda,quebra de linha,alinhamento,fundo  
    			if ($data->status == 'PENDENTE') {
    				$pdf::SetFillColor(254, 142, 142);
    			} else {
    				if ($linha % 2 == 0) { 
    					$pdf::SetFillColor(255, 255, 255);
    				} else {
    					$pdf::SetFillColor(199, 199, 199);
    				}
    			}
    			$pdf::Cell(10, 6, $linha, 1, 0, 'C', 1); 
    			$pdf::Cell(60, 6, utf8_decode($data->nome), 1, 0, 'L', 1);
    			$pdf::Cell(25, 6, utf8_decode($data->id), 1, 1, 'C', 1); 
    			if ($pdf::GetY() >= 280) {
    				$pdf::AddPage();
    				$pdf::SetFont('Arial', 'u', 11);
    				$pdf::SetFont('arial', '', 10); 
    				$pdf::Cell(10, 3, " - ", 1, 0, 'C'); 
    				$pdf::Cell(60, 3, "Nome ", 1, 0, 'C');
    				$pdf::Cell(25, 3, "CPF ", 1, 1, 'C'); 
    				$pdf::SetFont('arial', '', 7);
    			} 
    			$linha++;
    		}

    	} else { 
    		$pdf::Cell(0, 7, 'Nenhum registro de Atividades no periodo', 0, 1, 'C');
    	}
    	$pdf::Output('usuarios.pdf', 'D');
    	exit;

    }


}