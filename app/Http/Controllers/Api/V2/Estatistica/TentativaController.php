<?php

namespace  App\Http\Controllers\Api\V2\Estatistica;


use Illuminate\Http\Request;
use App\Http\Controllers\Api\V2\VueCrudController;   
use App\Models\Administrador\Tentativa;  
use Yajra\DataTables\DataTables;
use Auth;
use DB;
use Validator;


class TentativaController extends VueCrudController
{



	public function __construct( Tentativa $tentativa , DataTables $dataTable   ){

		$this->model = $tentativa ;    
		$this->dataTable = $dataTable ; 
		$this->route = 'tentativa';    

        $this->middleware('auth:api');

        $this->middleware('perfil:Admin', ['except' => ['Rank' , 'Classificação' ] ]) ;       
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
    	return response()->json( 'Item não encontrado' , 404); 
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
    		->editColumn('created_at', function ($user) {
    			return $user->created_at->format('Y/m/d H:i');
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




    // DEPENDE DA CRIAÇÃO DA VIEW COLOCACAO
    public function  ClassificaçãoQuery(    ){
        $model = DB::select('select @row_number:=@row_number + 1 AS colocacao, nome, data_fim_pro, rendimento ,  total, acertos, erros,  user_id , situacao_aprovacao  from classificacao3 ,(SELECT @row_number:=0) AS t'); 
        $collection = collect($model);
        return $collection;
    }



    // DEPENDE DA CRIAÇÃO DA VIEW COLOCACAO
    public function  Classificação(    ){
         $classificacao = $this->ClassificaçãoQuery();
         return response()->json( $classificacao , 200); 
    }




    public function  RendimentoGeralQuery(    ){
        $model = $this->model
        ->select(   
            DB::raw('count(*) as total') ,
            DB::raw('count(CASE WHEN acerto THEN 1 END) as positivo')  ,   
            DB::raw('format(count(CASE WHEN acerto THEN 1 END)/cast(count(*) AS SIGNED),3) * 100 as porcentagem')   
        ) 
        ->first();  
        return $model;
    }


    public function  RendimentoDisciplinaQuery(    ){


        $discSub = $this->model 
        ->select(  'users_resposta_pergunta.disciplina_id',
            DB::raw('format(count(CASE WHEN acerto THEN 1 END) / cast(  count(*) AS  SIGNED) , 4 ) * 100 as porcentagem ') ,
            DB::raw('count(CASE acerto WHEN 0 THEN 1 END) as erros ')   ,
            DB::raw('count(CASE acerto WHEN 1 THEN 1 END) as acertos ')   
        )
        ->groupBy('users_resposta_pergunta.disciplina_id' )
        ->where('users_resposta_pergunta.user_id' , Auth::guard('api')->user()->id ) 
        ->orderBy('porcentagem' ,'desc') ;



        $discGeral = $this->model
        ->join('disciplina', 'disciplina_id', '=', 'disciplina.id')
        ->joinSub($discSub, 'discSub', function ($join) {
            $join->on('users_resposta_pergunta.disciplina_id', '=', 'discSub.disciplina_id');
        })
        ->select( 
            DB::raw('discSub.porcentagem as minha')  , 
            'discSub.erros' , 
            'discSub.acertos' , 
            'users_resposta_pergunta.disciplina_id'  , 
            'disciplina.nome',
            DB::raw('format(count(CASE WHEN acerto THEN 1 END) / cast(  count(*) AS  SIGNED) , 4 ) * 100 as porcentagem '),
            DB::raw('count(*)  as total ')    
        )
        ->groupBy('discSub.acertos' , 'discSub.erros' , 'discSub.porcentagem' , 'users_resposta_pergunta.disciplina_id', 'disciplina.nome')
        ->orderBy('porcentagem' ,'desc') 
        ->get(); 

        return $discGeral;
    }



    public function  Rank( Request $request  ){

        $classificacao = $this->ClassificaçãoQuery();

        $model = $classificacao->where('user_id', Auth::guard('api')->user()->id );

        $rendimentoGeral  = $this->RendimentoGeralQuery();

        $discGeral = $this->RendimentoDisciplinaQuery();

        $estatistica = $model->first(); 
        $estatistica->numero_de_usuario =  $classificacao->count() ; 
        $estatistica->rendimentoGeral =  $rendimentoGeral ; 
        $estatistica->disciplinasGeral = $discGeral; 

        return response()->json( $estatistica , 200); 
    }

 
}