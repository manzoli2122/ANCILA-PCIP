<?php

namespace  App\Http\Controllers\Api\V1\Seguranca;


use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\VueCrudController;   
use Yajra\DataTables\DataTables;
use Validator; 
use App\User;
use App\Models\Seguranca\Perfil; 
use App\Models\Seguranca\Permissao;
use App\Models\Seguranca\LogPerfilPermissao; 
use Exception;
use Auth; 
use Cache;





class PerfilController extends VueCrudController
{



	protected $permissao;


	protected $logSeguranca;




	public function __construct( Perfil $perfil , Permissao $permissao, LogPerfilPermissao $log , DataTables $dataTable   ){ 

		$this->model = $perfil ;    
		$this->permissao = $permissao ;  
		$this->dataTable = $dataTable ;    
		$this->logSeguranca = $log ; 
		$this->route = 'perfil';  

		$this->middleware('auth:api', ['except' => ['Ativar' ] ]);


        // $this->middleware('permissao:perfis');  
        // $this->middleware('perfil:Admin')->only('update', 'destroy' , 'excluirPermissaoDoPerfil' , 'adicionarPermissaoAoPerfil');   

	}







    /**
    * Função para Adicionar uma Permissao a um Perfil atraves do PerfilServiceInterface
    *
    * @param Request $request
    *  
    * @param int  $perfilId
    *    
    * @return json
    */
    public function adicionarPermissaoAoPerfil(Request $request , $perfilId)
    {        
    	
    	if( !$perfil = $this->model->find($perfilId) ){
    		return response()->json('Item não encontrado.', 404 );
    	} 

    	$permissaoId = $request->get('permissao'); 

    	if( !$permissao = $this->permissao->find( $permissaoId ) ){
    		return response()->json('Item não encontrado.', 404 );
    	} 

    	$perfil->attachPermissao($permissao); 
    	$this->Log( $perfilId , $permissaoId , $permissao->nome  , Auth::guard('api')->user()->id , 'Adicionar'  );

    	return  $this->BuscarPermissoesParaAdicionar( $perfilId ) ; 

    }






    /**
    * Função para buscar os Permissao que um Perfil não possui; 
    *  
    * @param int  $perfilId 
    *
    * @return List $permissoes
    */
    public function BuscarPermissoesParaAdicionar($perfilId)
    {      
    	try {            
    		return response()->json( $this->permissao->permissaoParaAdicionarAoPerfil( $perfilId ) , 200);
    	}         
    	catch(Exception $e) {           
    		return response()->json( 'Erro interno', 500);    
    	}   
    }






    /**
    * Função para buscar as permissoes de um Perfil pelo datatable
    *
    * @param Request $request 
    *  
    * @param int  $perfilId 
    *
    * @return json
    */
    public function BuscarPermissaoDataTable( Request $request , $perfilId )
    {     
    	try {            
    		$perfil = $this->model->find($perfilId); 
    		$models = $perfil->permissoes( );  
    		return $this->dataTable
    		->eloquent($models)
    		->addColumn('action', function($linha) {
    			return  '<button data-id="'.$linha->permissao_id.'" btn-excluir class="btn btn-danger btn-sm" title="Excluir"><i class="fa fa-trash"></i></button>' ;
    		})
    		->make(true);
    	}         
    	catch (Exception $e) {           
    		return response()->json( $e->getMessage() , 500);
    	}   
    }





    /**
    * Função para buscar as Usuarios de um Perfil pelo datatable
    *
    * @param Request $request 
    *  
    * @param int  $perfilId 
    *
    * @return json
    */
    public function BuscarUsuariosDataTable( Request $request , $perfilId )
    {     
    	try {            
    		$perfil = $this->model->find($perfilId); 
    		$models = $perfil->usuarios( );  
    		return $this->dataTable
    		->eloquent($models) 
    		->make(true);  
    	}         
    	catch (Exception $e) {           
    		return response()->json( $e->getMessage() , 500);
    	}   
    }



    /**
    * Função para buscar os logs de permissoes de um perfil pelo datatable
    *
    * @param Request $request 
    *  
    * @param int  $perfilId 
    *
    * @return json
    */
    public function BuscarPermissaoDataTableLog( Request $request , $perfilId )
    {     
    	try {            
    		$models = $this->logSeguranca->getDatatable($perfilId);  
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
    		if( !$model = $this->model->find($id) ){
    			return response()->json( 'Item não encontrado' , 404);
    		}
    		if( !$delete = $model->delete() ){
    			return response()->json([ 'message' => 'Erro ao excluir o registro!' ], 500);
    		}
    		if(Cache::getStore() instanceof TaggableStore){
    			Cache::tags(User::$cacheTag)->flush(); 
    		}
    		else{
    			Cache::flush( );
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
    * Função para retirar um Permissao de um Perfil  atraves do PerfilServiceInterface
    *
    * @param Request $request
    * 
    * @param int  $perfilId
    *  
    * @param int  $permissaoId 
    *
    * @return json
    */ 
    public function excluirPermissaoDoPerfil( Request $request , $perfilId , $permissaoId )
    {        
    	if( !$perfil = $this->model->find($perfilId) ){
    		return response()->json('Item não encontrado.', 404 );
    	}  

    	if( !$permissao = $this->permissao->find( $permissaoId ) ){
    		return response()->json('Item não encontrado.', 404 );
    	} 

    	$perfil->detachPermissao($permissao);  
    	$this->Log( $perfilId  , $permissaoId , $permissao->nome ,  Auth::guard('api')->user()->id , 'Excluir'  ); 

    	return   $this->service->BuscarPermissoesParaAdicionar( $perfilId )   ;  
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
    			return 
    			'<a href="#/'. $this->route . '/'.$linha->id.'/permissao" class="btn btn-primary btn-sm" title="Permissões"><i class="fa fa-unlock"></i></a>'
    			.'<a href="#/'. $this->route . '/'.$linha->id.'/usuarios" class="btn btn-warning btn-sm" title="Usuarios"><i class="fa fa-users"></i></a>'
    			.'<button data-id="'.$linha->id.'" btn-excluir class="btn btn-danger btn-sm" title="Excluir"><i class="fa fa-trash"></i></button>' ;
    		})
    		->make(true); 

    	}         
    	catch (Exception $e) {           
    		return response()->json( $e->getMessage() , 500);
    	} 
    }



    /**
    * Função para retirar um Perfil de um usuario e salvar em log 
    *
    * @param int  $perfilId
    *  
    * @param int  $pemissaoId
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
    private function Log( int $perfilId , int $permissaoId , string $permissao_nome , string $autorId , string $acao  )
    {         
        $log =  new LogPerfilPermissao();
        $log->permissao_id = $permissaoId;
        $log->permissao_nome = $permissao_nome;
        $log->autor_id = $autorId;
        $log->perfil_id = $perfilId;
        $log->acao = $acao ;
        $log->ip_v4 = getenv("REMOTE_ADDR");
        $log->host =gethostbyaddr(getenv("REMOTE_ADDR")); 
        $log->save(); 
    }

}