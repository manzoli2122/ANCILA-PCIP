<?php

namespace App\Service\Seguranca ;

use App\User;
use App\Exceptions\ModelNotFoundException; 
use App\Models\Seguranca\Perfil;
use App\Models\Seguranca\LogUsuarioPerfil;
use App\Service\VueService;
use Auth;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;   
use Log;
use Exception;
use Illuminate\Support\Facades\Mail; 
use App\Notifications\PerfilAdicionadoNotification  ; 
use App\Notifications\PerfilRemovidoNotification  ;  
use Fpdf;


class NewPdf extends Fpdf{

}


class UsuarioService extends VueService  implements UsuarioServiceInterface 
{




	protected $model; 


	protected $perfil; 


	protected $logSeguranca;


	protected $dataTable;


	protected $route = "user";





    /**
    * Função para criar um model  
    *
    * @param Request $request
    *    
    * @return void
    */
    public function  Salvar( $request  ){ 
        $data = $request->all() ;
        $data['password'] =  bcrypt(  $data['password'] );
        throw_if( !$insert  = $this->model->create( $data ) , Exception::class); 
        return $insert ;  
    }



    /**
    * Save  
    *
    * @param mixed $inputPermissions
    *
    * @return void
    */
    public function __construct( User $user , Perfil $perfil , LogUsuarioPerfil $log , DataTables $dataTable  ){        
    	$this->dataTable = $dataTable ;   
    	$this->model = $user ;   
    	$this->perfil = $perfil ;
    	$this->logSeguranca = $log ;  

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
    public function  Ativar( Request $request , $id ){
    	throw_if(!$model = $this->model->withoutGlobalScope('ativo')->find($id), ModelNotFoundException::class);
    	$model->status = 'A';
    	$model->save(); 
    	return 'Ativado';
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
        throw_if(!$model = $this->model->withoutGlobalScope('ativo')->find($userId), ModelNotFoundException::class); 
        $model->password = bcrypt(  'pmes@123'  ); 
        $model->save(); 
        return 'Alterado';
    }







    /**
    * Função para desativar um usuario ja existente  
    *
    * @param Request $request
    *  
    * @param int  $id
    *    
    * @return void
    */
    public function  Desativar( Request $request , $id ){

    	throw_if(Auth::user()->id ===  $id , Exception::class); 
    	throw_if(!$model = $this->model->find($id), ModelNotFoundException::class); 
    	$model->status = 'I';
    	$model->save(); 
    	return 'Destivado';
    }










    /**
    * Funcao para buscar os usuario pelo datatable  
    *
    * @param Request $request 
    *
    * @return json
    */
    public function  BuscarDataTable( $request ){
    	$models = $this->model->getDatatable();
    	return $this->dataTable->eloquent($models)
    	->addColumn('action', function($linha) { 
    		if($linha->status === 'Inativo'){
    			return '<button data-id="'.$linha->id.'" btn-ativar class="btn btn-success btn-sm" title="Ativar"><i class="fa fa-unlock"></i> </button>' ;
    		} 
    		return '<a href="#/'.$linha->id.'/perfil" class="btn btn-primary btn-sm" title="Perfis"><i class="fa fa-id-card"></i></a> ' 

            .'<a href="'. route('resetar.senha',$linha->id).'" class="btn btn-warning btn-sm" title="Resetar Senha"><i class="fa fa-key"></i></a>'

    		.'<button data-id="'.$linha->id.'" btn-desativar class="btn btn-danger btn-sm" title="Destivar"><i class="fa fa-lock"></i></button>' ; 
    	})
    	->setRowClass(function ($user) {
    		return $user->status === 'Ativo' ? '' : 'alert-warning';
    	})
    	->make(true); 
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
    public function  BuscarPerfilDataTable( $request , $userId ){ 
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






    /**
    * Função para buscar os perfis de um usuario pelo datatable
    *
    * @param Request $request 
    *  
    * @param int  $userId 
    *
    * @return json
    */
    public function  BuscarPerfilTransferirDataTable( $request , $userId ){ 
    	$usuario = $this->model->find($userId); 
    	$models = $usuario->perfis( ); 
    	return $this->dataTable->eloquent($models)
    	->addColumn('action', function($linha) use( $request) {
            if($request->user()->hasPerfil($linha->nome)){
                return  
                    '<button data-id="'.$linha->perfil_id.'" btn-excluir class="btn btn-danger btn-sm" title="Excluir"><i class="fa fa-trash"></i></button>' 
                    ;
            }
            return  
                    '';
    	})
    	->make(true);  
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
    public function  BuscarPerfilDataTableLog( $request , $userId ){ 
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











    /**
    * Função para Adicionar um Perfil a um usuario e salvar em log 
    *
    * @param int  $perfilId
    *  
    * @param int  $userId
    *  
    * @param int  $autorId
    *  
    * @param string  $ip_v4
    * 
    * @param string  $host
    *
    * @return void
    */
    public function adicionarPerfilAoUsuario( int $perfilId , string  $userId , Request  $request )
    {        
    	$usuario = $this->model->find($userId);
    	$perfil = $this->perfil->find( $perfilId );
    	if( $perfil->nome == 'Admin' and !Auth::user()->hasPerfil('Admin')){
    		abort(403, 'Você não tem permissão para adicionar o perfil Admin.');
    	}
    	$usuario->attachPerfil($perfil, Auth::user()->id );
 
        $usuario->notify( new PerfilAdicionadoNotification( $perfil ) );
 
    	$this->Log( $perfilId , $userId  , Auth::user()->id , 'Adicionar' );  
    }









    /**
    * Função para retirar um Perfil de um usuario e salvar em log 
    *
    * @param int  $perfilId
    *  
    * @param int  $userId
    *  
    * @param int  $autorId
    *  
    * @param string  $ip_v4
    * 
    * @param string  $host
    *
    * @return void
    */
    public function excluirPerfilDoUsuario( int $perfilId , string  $userId , Request  $request)
    {        
    	$usuario = $this->model->find($userId);
    	$perfil = $this->perfil->find($perfilId); 
    	if( $perfil->nome == 'Admin' and !Auth::user()->hasPerfil('Admin')){
    		abort(403, 'Você não tem permissão para remover o perfil Admin.');
    	} 
    	if( $perfil->nome == 'Admin' and  Auth::user()->id === $userId ){
    		abort(403, 'Não é possível remover o seu perfil Admin.'); 
    	} 
    	$usuario->detachPerfil($perfilId); 

        $usuario->notify( new PerfilRemovidoNotification( $perfil ) );
 
    	$this->Log( $perfilId , $userId  , Auth::user()->id , 'Excluir' ); 
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
    * Função para buscar os Perfis que um usuario não possui; 
    *  
    * @param int  $userId 
    *
    * @return List $pefis
    */
    public function BuscarPerfisParaAdicionar(   string $userId  ){ 
      	return  $this->perfil->perfisParaAdicionarAoUsuario( $userId ,  Auth::user()->hasPerfil('Admin') );
    }


 
 
 






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
         
        $pdf ::SetTitle("Batalhao Online da Policia Militar do ES");
        $pdf ::SetSubject("DTIC Sempre Presente, contruindo o seu futuro.");
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
            // $pdf::Cell(20, 8, "Cargo ", 1, 0, 'C'); 
            $pdf::Cell(60, 3, "Nome ", 1, 0, 'C');
            $pdf::Cell(25, 3, "CPF ", 1, 1, 'C');
            // $pdf::Cell(25, 8, utf8_decode("Nº Funcional"), 1, 0, 'C');            
            // $pdf::Cell(15, 8, "RG ", 1, 0, 'C');
            // $pdf::Cell(15, 8, "Cargo", 1, 0, 'C');
            // $pdf::Cell(20, 8, "Unidade", 1, 1, 'C');


            $pdf::SetFont('arial', '', 7);
            $linha = 1;

            foreach ($datas as $data) {
                //escreve no pdf largura,altura,conteudo,borda,quebra de linha,alinhamento,fundo  
                if ($data->status == 'PENDENTE') {
                    $pdf::SetFillColor(254, 142, 142);
                } else {
                    if ($linha % 2 == 0) {
                        // Muda o fundo de c�lula
                        $pdf::SetFillColor(255, 255, 255);
                    } else {
                        $pdf::SetFillColor(199, 199, 199);
                    }
                }
                $pdf::Cell(10, 6, $linha, 1, 0, 'C', 1);
                // $pdf::Cell(20, 6, $data->cargo, 1, 0, 'C', 1);
                $pdf::Cell(60, 6, utf8_decode($data->nome), 1, 0, 'L', 1);
                $pdf::Cell(25, 6, utf8_decode($data->id), 1, 1, 'C', 1);
                // $pdf::Cell(25, 6, utf8_decode($data->numeroFuncional), 1, 0, 'C', 1);
                // $pdf::Cell(15, 6, utf8_decode($data->rg), 1, 0, 'C', 1);
                // $pdf::Cell(15, 6, utf8_decode($data->cargo)  , 1, 0, 'C', 1);
                // $pdf::Cell(20, 6, utf8_decode($data->unidade), 1, 1, 'C', 1 );

                if ($pdf::GetY() >= 280) {
                    $pdf::AddPage();
                    $pdf::SetFont('Arial', 'u', 11);
                    $pdf::SetFont('arial', '', 10);
                    //linha do curso
                    $pdf::Cell(10, 3, " - ", 1, 0, 'C');
                    // $pdf::Cell(20, 8, "Cargo ", 1, 0, 'C');
                    $pdf::Cell(60, 3, "Nome ", 1, 0, 'C');
                    $pdf::Cell(25, 3, "CPF ", 1, 1, 'C');
                    // $pdf::Cell(25, 8, utf8_decode("Nº Funcional"), 1, 0, 'C');
                    // $pdf::Cell(15, 8, "RG ", 1, 0, 'C');
                    // $pdf::Cell(15, 8, "Cargo", 1, 0, 'C');
                    // $pdf::Cell(20, 8, "Unidade", 1, 1, 'C');

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
