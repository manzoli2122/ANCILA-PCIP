<?php

namespace  App\Http\Controllers\Api\V1\Estatistica;


use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\VueCrudController;   
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

        $this->middleware('auth:api', ['except' => ['Ativar' ] ]);

        $this->middleware('perfil:Admin', ['except' => ['MeuRank' ] ]) ;       
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





    public function  Rankiar( Request $request  ){

    	$model = $this->model->select('user_id'  ,   
            DB::raw('count(*) as total') , 
            DB::raw('DENSE_RANK() OVER( ORDER BY count(CASE WHEN acerto THEN 1 END) / cast(count(*) AS NUMERIC(15,3)) desc) as rank') ,                                 
            DB::raw('count(CASE WHEN acerto THEN 1 END) as positivo')  ,   
            DB::raw('count(CASE WHEN acerto THEN 1 END) / cast(count(*) AS NUMERIC(15,3)) * 100    as porcentagem ')   )

        ->groupBy('user_id')
                 // ->orderBy('total' , 'desc')
        ->havingRaw('count(*) > ?', [10]) 
                // ->where('user_id' , '07819403705') 
        ->with('usuario')   
        ->get();  

        // $model = $model->where('user_id', '07895101706');

        return response()->json($model , 200); 
    }









    public function  MeuRank1( Request $request  ){

    	$model = $this->model->select('user_id'  ,   
            DB::raw('count(*) as total') , 
            DB::raw('DENSE_RANK() OVER( ORDER BY count(CASE WHEN acerto THEN 1 END) / cast(  count(*) AS NUMERIC(15,3)) desc)  as rank') ,                                 
            DB::raw('count(CASE WHEN acerto THEN 1 END) as positivo')  ,   
            DB::raw('count(CASE WHEN acerto THEN 1 END) / cast(count(*) AS NUMERIC(15,3)) * 100    as porcentagem ')   )

        ->groupBy('user_id')
        ->havingRaw('count(*) > ?', [10])  
        ->get();  

        $model = $model->where('user_id', Auth::guard('api')->user()->id );
        
        return response()->json( $model->first() , 200); 
    }



    public function  ClassificaçãoQuery1(    ){
     $model =   $this->model
     ->select('user_id'  ,   
        DB::raw('count(*) as total') , 
        DB::raw('count(CASE WHEN acerto THEN 1 END) / cast(  count(*) AS  SIGNED)  as rank1') ,                                 
        DB::raw('count(CASE WHEN acerto THEN 1 END) as positivo')  ,   
        DB::raw('count(CASE WHEN acerto THEN 1 END) / cast(  count(*) AS  SIGNED) * 100 as porcentagem ')   
    )

     ->groupBy('user_id')
     ->havingRaw('count(*) > ?', [10])  
     ->orderBy('rank1' ,'desc') 
     ->get();  

     $model->each(function ($item, $key) {
        $item['rank'] = $key + 1; 
    });

     return $model;

 }






 public function  ClassificaçãoQuery(    ){
    $model = DB::select('select @row_number:=@row_number + 1 AS colocacao, rendimento ,  total, user_id  from classificacao ,(SELECT @row_number:=0) AS t'); 
    $collection = collect($model);
    return $collection;
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








public function  MeuRank( Request $request  ){

    // RANK DOS USUÁRIOS       
    $classificacao = $this->ClassificaçãoQuery();

    $model = $classificacao->where('user_id', Auth::guard('api')->user()->id );

    $rendimentoGeral  = $this->RendimentoGeralQuery();

    $discGeral = $this->RendimentoDisciplinaQuery();



    // $disc = $this->model
    // ->join('disciplina', 'disciplina_id', '=', 'disciplina.id') 
    // ->select(  'users_resposta_pergunta.disciplina_id'  , 'disciplina.nome',
    //     DB::raw('count(CASE WHEN acerto THEN 1 END) / cast(  count(*) AS  SIGNED) * 100 as porcentagem ')   ) 
    // ->groupBy('users_resposta_pergunta.disciplina_id', 'disciplina.nome')
    // ->where('users_resposta_pergunta.user_id' , Auth::guard('api')->user()->id ) 
    // ->orderBy('porcentagem' ,'desc') 
    // ->get(); 




    // $discGeral1 = $this->model
    // ->join('disciplina', 'disciplina_id', '=', 'disciplina.id')
    //            // ->select('users.*', 'contacts.phone', 'orders.price')
    // ->select(  'users_resposta_pergunta.disciplina_id'  , 'disciplina.nome',
    //     DB::raw('count(CASE WHEN acerto THEN 1 END) / cast(  count(*) AS  SIGNED) * 100 as porcentagem '),
    //     DB::raw('count(*)  as total ')    )

    // ->groupBy('users_resposta_pergunta.disciplina_id', 'disciplina.nome')

    // ->orderBy('porcentagem' ,'desc') 
    // ->get(); 



    $estatistica = $model->first();
    // $estatistica = head($model);
    // $estatistica->disciplinas = $disc;
    $estatistica->rendimentoGeral =  $rendimentoGeral ;
    // $estatistica['disciplinas'] = $disc;
    $estatistica->disciplinasGeral = $discGeral;
    // $estatistica['disciplinasGeral'] = $discGeral;

    return response()->json( $estatistica , 200); 
}




}