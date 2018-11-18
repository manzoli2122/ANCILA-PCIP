<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Administrador\Pergunta;
use App\Models\Administrador\Disciplina;
use App\Models\Administrador\Resposta;
use App\Models\Administrador\Tentativa;
use App\Models\Administrador\Assunto;

class TreinamentoController extends Controller
{
   
  	protected $model;   



    public function __construct(Pergunta $pergunta){
    	$this->model = $pergunta;
        $this->middleware('auth');
    }



    
    public function index(){
        return view('treinamento.index');
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
        $temp = session('perguntas.id' , 0 );
        $request->session()->push('perguntas.id',  $model->id );
        
        $disciplina_id = Assunto::find($model->assunto_id)->disciplina_id;
        Tentativa::create(['user_id' => Auth::user()->id,  
            'pergunta_id' => $model->id  ,
            'disciplina_id' => $disciplina_id , 
            'resposta_id' => $resposta->id  , 
            'acerto' =>   $resultado ]);



        if($resultado){
            $certas = session('certas' , 0 ) + 1 ;
            session(['certas' =>  $certas  ]);

        }
        else{
            $erradas = session('erradas' , 0 ) + 1 ;
            session(['erradas' => $erradas ]);
        }
        



        return response()->json( [  
            'certas' =>  session('certas' , 0 ) , 
            'erradas' =>  session('erradas' , 0 )  ,  
            // 'realizadas' => session('perguntas.id' , 0 ),
            // 'disciplina' =>  session('disciplina' , [] )   
            ]   , 200);

    }







    public function historico(Request $request){ 
        
        $disciplina = session('disciplina' , [] );

        $id = Auth::user()->id;

        $resposta = Tentativa::where('user_id', $id)->whereIn('disciplina_id' , $disciplina )->select('acerto', 'pergunta_id')->get();

        return response()->json(  $resposta    , 200); 
    }








    public function placar(Request $request){ 
        return response()->json( [  
            'certas' =>  session('certas' , 0 ) , 
            'erradas' =>  session('erradas' , 0 )  ,  
            // 'realizadas' => session('perguntas.id' , 0 ),
            // 'disciplina' =>  session('disciplina' , [] ) 
              ]   , 200); 
    }






    public function proximo(Request $request )
    {
        try { 
            $disciplina = Disciplina::select('id')->get()->toArray(); 
            
            // if(  Auth::check() ){
                
                if(  Auth::user()->can('Restrita') ){
                    $status =  [  'Validada' , 'Finalizada' , 'Restrita'] ;
                }
                else{
                     $status =  [  'Validada' , 'Finalizada' ] ;
                }
 
                if( !$models = $this->model->ativo()
                            ->whereNotIn( 'id' , session('perguntas.id' , [] ) )

                            // ->whereIn( 'pergunta.dificuldade' , session('dificuldade' , [ 'Muito Facil', 'Facil', 'Medio' ,  'Dificil' ,  'Muito Dificil'    ] ) )

                             // ->whereIn( 'pergunta.status' , [  'Validada' , 'Finalizada' ]  )
                            
                            ->whereIn( 'pergunta.status' , $status  )

                            ->whereHas('assunto', function ($query) use ($disciplina) {
                                $query->whereIn('disciplina_id', session('disciplina' , $disciplina )  );
                            })

                            ->with('resposta')->get()    ){       
                    return response()->json(  'pergunta nao encontrada' , 404);             
                } 

                
            // }





            // else{
            //     if( !$models = $this->model->ativo()
            //                 ->whereNotIn( 'id' , session('perguntas.id' , [] ) )

            //                 ->whereIn( 'pergunta.dificuldade' , session('dificuldade' , [ 'Muito Facil', 'Facil', 'Medio' ,  'Dificil' ,  'Muito Dificil'    ] ) )

            //                 ->whereIn( 'pergunta.status' , [  'Validada' , 'Finalizada' ]  )
                            
            //                 ->whereHas('assunto', function ($query) use ($disciplina) {
            //                     $query->whereIn('disciplina_id', session('disciplina' , $disciplina )  );
            //                 })

            //                 ->with('resposta')->get()    ){       
            //         return response()->json(  'pergunta nao encontrada' , 404);             
            //     } 
            // }
 
            if( $models->count() < 1 ){
                $request->session()->forget('perguntas.id');
                return response()->json(  'pergunta nao encontrada' , 404);
            }
 
            $model = $models->random();
            $model->resposta = $model->resposta->shuffle();

            return response()->json(  $model->only( 'id' , 'texto' , 'resposta_certa_id' , 'resumo' , 'assunto' ,'resposta' , 'dificuldade') , 200);      
 
        }   

        catch(Exception $e) {        
            return response()->json(  'pergunta nao encontrada' , 500);  ;
        }
    }






    public function alterarDificuldade(Request $request )
    {

        $request->session()->forget('dificuldade');

        if($request->input('muitofacil')){
             $request->session()->push('dificuldade',  'Muito Facil' );
        }   

        if($request->input('facil')){
             $request->session()->push('dificuldade',  'Facil' );
        }   

        if($request->input('medio')){
             $request->session()->push('dificuldade',  'Medio' );
        }   

        if($request->input('dificil')){
             $request->session()->push('dificuldade',  'Dificil' );
        }   

        if($request->input('muitodificil')){
             $request->session()->push('dificuldade',  'Muito Dificil' );
        }   
 
        return response()->json( [  'dificuldade' =>  session('dificuldade' , [] )    ]   , 200);
        
    }



    public function alterarDisciplina(Request $request )
    {
               
        if($request->input('disciplina')){
            
            $request->session()->forget('disciplina');
            $request->session()->forget('perguntas.id');
            $request->session()->forget('certas');
            $request->session()->forget('erradas'); 

            $temp = $request->input('disciplina');            
            $request->session()->push('disciplina', $temp  );
                      
        }   
        else{
            $request->session()->forget('disciplina');
        }
 
        return response()->json( [  'disciplina' =>  session('disciplina' , [] )    ]   , 200);
        
    }



    public function getDisciplina(Request $request )
    { 
        return response()->json( [  'disciplina' =>  session('disciplina' , [] )    ]   , 200); 
    }





    public function proximo2(Request $request )
    {
        try {
            if( !$model = $this->model->get()->random()    ){       
            	return redirect()->route('treinamento.index')->withErrors(['message' => 'Aconteceu um erro!!']);
            } 
            $resposta = $model->resposta ;            	
            return view('treinamento.pergunta' , compact( "model" , 'resposta') ) ;
        }         
        catch(Exception $e) {        
        	return redirect()->route('treinamento.index')->withErrors(['message' => 'Aconteceu um erro!!']);  
        }
    }

    

}
