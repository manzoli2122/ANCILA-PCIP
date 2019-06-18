<?php

namespace App\Http\Controllers\Api\V2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use App\Models\Administrador\Pergunta;
use App\Models\Administrador\Disciplina;
use App\Models\Administrador\Resposta;
use App\Models\Administrador\Tentativa;
use App\Models\Administrador\Assunto;
use DB;



class TreinamentoController extends Controller
{

    protected $model;   



    public function __construct(Pergunta $pergunta){
        $this->model = $pergunta;
        $this->middleware('auth:api'); 
    }





    public function proximo(Request $request )
    {
        try { 

            $disciplina = $request->input('disciplina_id'); 
            $perguntas = $request->input('perguntas'); 

            $status =  [  'Validada' , 'Finalizada' , 'Restrita'] ;

            if( !$models = $this->model->ativo()
                ->whereNotIn( 'id' , $perguntas )
                ->whereIn( 'pergunta.status' , $status  )
                ->whereHas('assunto', function ($query) use ($disciplina) {
                    $query->whereIn('disciplina_id',  $disciplina  );
                })

                ->with('resposta')->get()    )
            {       
                return response()->json(  'pergunta nao encontrada - 1' , 404);             
            } 

            if( $models->count() < 1 ){             
                return response()->json(  'pergunta nao encontrada - 2' , 404);
            }




            $realizadas = Tentativa::select('pergunta_id' , DB::raw('count(*) as total')    )

            ->groupBy('pergunta_id') 
            ->where('user_id' , Auth::guard('api')->user()->id ) 
            ->where('disciplina_id' , $disciplina ) 
            ->whereNotIn( 'pergunta_id' , $perguntas )
            ->orderBy('total', 'asc')
            ->get();   

            $plucked = $realizadas->pluck('pergunta_id');

            $filtered = $models->whereNotIn('id',$plucked );

            if( $filtered->count() < 1 ){ 

                if($realizadas->count() > 0){

                    $model = $models->where('id' , $realizadas->where('total' , $realizadas->first()->total)->random()->pergunta_id )->first();

                    $model->resposta = $model->resposta->shuffle();
                    return response()->json(  $model->only( 'id' , 'texto' , 'resposta_certa_id' , 'resumo' , 'assunto' ,'resposta' , 'dificuldade') , 200); 
                } 
                else{
                    return response()->json(  'pergunta nao encontrada - 3' , 404);
                }
            }
            else{

                $model = $filtered->random();
                $model->resposta = $model->resposta->shuffle();

                return response()->json(  $model->only( 'id' , 'texto' , 'resposta_certa_id' , 'resumo' , 'assunto' ,'resposta' , 'dificuldade') , 200);  
            }

        }   

        catch(Exception $e) {        
            return response()->json(  'pergunta nao encontrada' , 500);  ;
        }
    }







    public function responder(Request $request) {
        if( !$model = $this->model->find(  $request->input('pergunta_id')  )   ){       
            return response()->json(  'pergunta nao encontrada' , 500);
        }
        if( !$resposta = Resposta::find(  $request->input('selected')  )   ){       
            return response()->json(  'resposta nao encontrada' , 500);
        }

        $resposta->count = $resposta->count + 1  ;
        $resposta->save();
        $tentativa =  intval( $request->input('selected') ); 
        $resposta_certa =intval(  $model->resposta_certa_id );       
        $resultado =   $tentativa === $resposta_certa ;

        $disciplina_id = Assunto::find($model->assunto_id)->disciplina_id;
        Tentativa::create(['user_id' => Auth::guard('api')->user()->id,  
            'pergunta_id' => $model->id  ,
            'disciplina_id' => $disciplina_id , 
            'resposta_id' => $resposta->id  , 
            'latitude' => $request->input('latitude')  , 
            'longitude' => $request->input('longitude') ,
            'acerto' =>   $resultado ]);

        return response()->json( [  
            'msg' =>  'Resposta cadastrada com sucesso!' ,  
        ]   , 200);

    }





    public function alterarDisciplina(Request $request )
    {
        if($request->input('disciplina')){
            $request->session()->forget('disciplina');
            // $request->session()->forget('perguntas.id');
            // $request->session()->forget('certas');
            // $request->session()->forget('erradas'); 
            // $temp = $request->input('disciplina');            
            // $request->session()->push('disciplina', $temp  );
            $request->session()->push('disciplina', $request->input('disciplina') );
        }   
        else{
            $request->session()->forget('disciplina');
        }
        return response()->json( [ 'disciplina' =>  session('disciplina' , [] ) ], 200);
    }






    // FUNÇÃO PARA BUSCAR QUAIS DISCIPLINAS O USUARIO ESTA FAZENDO
    public function getDisciplina(Request $request )
    { 
        return response()->json( [  'disciplina' =>  session('disciplina' , [] )    ]   , 200); 
    }

 




    // public function todas(Request $request )
    // {
    //     try { 
    //         $disciplina = $request->input('disciplina_id'); 
    //         $status =  [  'Validada' , 'Finalizada' , 'Restrita'] ;
    //         if( !$models = $this->model->ativo()  
    //             ->whereIn( 'pergunta.status' , $status  ) 
    //             ->whereHas('assunto', function ($query) use ($disciplina) {
    //                 $query->whereIn('disciplina_id',  $disciplina  );
    //             }) 
    //             ->with('resposta')
    //             ->with('assunto')->get()    )
    //         {       
    //             return response()->json(  'pergunta nao encontrada' , 404);             
    //         } 
    //         if( $models->count() < 1 ){ 
    //             return response()->json(  'pergunta nao encontrada' , 404);
    //         }
    //         return response()->json(  $models , 200);  
    //     }   
    //     catch(Exception $e) {        
    //         return response()->json(  'pergunta nao encontrada' , 500);  ;
    //     }
    // }


 
    // public function historico(Request $request){ 
    //     $disciplina = $request->input('disciplina');
    //     $id = Auth::guard('api')->user()->id;
    //     $resposta = Tentativa::where('user_id', $id)->whereIn('disciplina_id' , $disciplina )->select('acerto', 'pergunta_id')->get();
    //     return response()->json(  $resposta    , 200); 
    // }



    // public function alterarDificuldade(Request $request ){
    //     $request->session()->forget('dificuldade');
    //     if($request->input('muitofacil')){
    //         $request->session()->push('dificuldade',  'Muito Facil' );
    //     }   
    //     if($request->input('facil')){
    //         $request->session()->push('dificuldade',  'Facil' );
    //     }   
    //     if($request->input('medio')){
    //         $request->session()->push('dificuldade',  'Medio' );
    //     }   
    //     if($request->input('dificil')){
    //         $request->session()->push('dificuldade',  'Dificil' );
    //     }   
    //     if($request->input('muitodificil')){
    //         $request->session()->push('dificuldade',  'Muito Dificil' );
    //     }   
    //     return response()->json( [  'dificuldade' =>  session('dificuldade' , [] ) ] , 200);
    // }

 
}
