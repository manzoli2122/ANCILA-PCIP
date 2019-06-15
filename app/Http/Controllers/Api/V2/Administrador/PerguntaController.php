<?php

namespace  App\Http\Controllers\Api\V1\Administrador;


use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\VueCrudController;   
use App\Models\Administrador\Pergunta;  
use App\Models\Administrador\Resposta;
use Yajra\DataTables\DataTables;
use Fpdf;
use Validator;
use Auth;

class PerguntaController extends VueCrudController
{


    public function __construct( Pergunta $pergunta , DataTables $dataTable){     

        $this->model = $pergunta ;    
        $this->dataTable = $dataTable ; 
        $this->route = 'pergunta';
        
        $this->middleware('auth:api', ['except' => [''] ]);

        $this->middleware('permissao:pergunta')->except('respostas', 'destroy') ;
        
        $this->middleware('permissao:pergunta-editar')->only('update') ;

        $this->middleware('perfil:Admin')->only( 'destroy');

    }




    /**
    * Função para buscar um model
    *
    * @param Request $request
    *  
    * @param int  $id
    *    
    * @return json
    */
    public function show(Request $request , $id){
        try {  
            if( !$model = $this->model->with('assunto')->with('resposta')->find($id) ){      
                return response()->json('Item não encontrado.', 404 );    
            } 
            return response()->json( $model , 200);
        }         
        catch(Exception $e) {  
            return response()->json( 'Erro interno'  , 500);    
        }
    }






    /**
    * Função para alterar resposta
    *
    * @param Request $request
    *  
    * @param int  $id
    *    
    * @return void
    */
    public function  AlterarResposta( Request $request , $perguntaId  ){
        if( !$model = $this->model->with('assunto')->with('resposta')->find($perguntaId)){
            return response()->json('Item não encontrado.', 404 ); 
        }        
        if( !$resposta = Resposta::find( $request->input('resposta_id')) ){
            return response()->json('Item não encontrado.', 404 ); 
        } 
        $model->resposta_correta()->associate($resposta) ;
        $model->save(); 
        return response()->json( $model , 200 ); 

    }








    /**
    * Busca   registros de um model 
    *
    * @param Request $request
    *
    * @return $model
    */
    public function  BuscarCriada( Request $request  ){
        return response()->json( $this->model->where('status', 'Criada')->get() , 200); 
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
    public function  Ativar( Request $request , $perguntaId ){

        if(!$model = $this->model->withTrashed()->find($perguntaId) ){
            return response()->json('Item não encontrado.', 404 ); 
        }
        $model->restore();  
        return response()->json('Ativado', 200 );
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
                if($linha->deleted_at != ''){
                    return '<button data-id="'.$linha->id.'" btn-ativar class="btn btn-success btn-sm" title="Ativar"><i class="fa fa-thumbs-up"></i> </button>' 
                    .'<button data-id="'.$linha->id.'" btn-excluir class="btn btn-danger btn-sm" title="Excluir Definitivamente"><i class="fa fa-trash"></i></button>';
                } 
                return 
                '<a href="#/'. $this->route . '/edit/'.$linha->id.'" class="btn btn-success btn-sm" title="Editar"><i class="fa fa-pencil"></i></a>'
                . '<a href="#/'. $this->route . '/show/'.$linha->id.'" class="btn btn-primary btn-sm" title="Visualizar" style="margin-left: 10px;"><i class="fa fa-search"></i></a>'
                .'<button data-id="'.$linha->id.'" btn-desativar class="btn btn-danger btn-sm" title="Desativar"><i class="fa fa-thumbs-down"></i></button>';
            })
            ->setRowClass(function ($linha) {
                $class = '';
                if($linha->deleted_at != ''){
                 $class .= 'alert-warning' ;
             }
             if($linha->status === 'Suspensa'){
                 $class .= ' text-danger' ;
             } 
             return $class;
         })
            ->addColumn('disciplina', function ($pergunta) {
                return $pergunta->assunto->disciplina->nome ;
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
            if( $model = $this->model->find($id) ){
                if( !$delete = $model->delete() ){
                    return response()->json([ 'message' => 'Erro ao excluir o registro!' ], 500);
                }
                return response()->json( 'Exclusão realizada com sucesso' , 200);  
            }
            if( $model = $this->model->onlyTrashed()->find($id)){
                if( !$delete = $model->forceDelete() ){
                    return response()->json([ 'message' => 'Erro ao excluir o registro!' ], 500);
                }
                return response()->json( 'Exclusão realizada com sucesso' , 200);  
            }
            return response()->json( 'Item não encontrado' , 404);  
        } 
        catch(QueryException $e){
            return response()->json([ 'message' => 'Erro de conexao com o banco' ] , 500 );
        } 
        catch(Exception $e){
            return response()->json([ 'message' => $e->getMessage() ], 500);
        }  
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
        $texto = utf8_decode('Questões para Estudo'); 
        $pdf->SetTitle($texto);
        $pdf->SetSubject("DTIC Sempre Presente, contruindo o seu futuro.");
        // $pdf ::SetAuthor('bruno'); 
        // $pdf ::SetKeywords('baon cco desempenho individual ');
        //Seta a posicao vertical e horizontal  
        $pdf->SetY(-10);
        $pdf->AddPage();
        // $pdf->SetDash(5,5);
        //$pdf->Header();
        $pdf->AliasNbPages();
        // $pdf::SetAutoPageBreak(10, 10);
        $pdf->SetFont('Arial', 'u', 11);
        // Fpdf::Write(5,"To find out wha's new in this tutorial, click ");
        
        if (count($datas) >= 1) {
            foreach ($datas as $data) {

                if($data->deleted_at == ''){

                    if($data->status === 'Validada'  || $data->status === 'Finalizada' || (Auth::guard('api')->user()->can('Admin') && $data->status === 'Restrita') ){

                        $pdf->SetFont('arial', '', 10);

                        $html = html_entity_decode( $data->id . ') ' . $data->texto);
                        $html = str_replace(['–' , '—'], '-' ,$html ); 
                        $html = str_replace(['”' , '“'], '"' ,$html );
                        $html = str_replace(['‘' , '’'], '"' ,$html );
                        $html = str_replace('…', '. . .' ,$html );
                        $html = utf8_decode($html); 
                        $pdf->WriteHTML( $html ); 
                        $pdf->Ln();
                        foreach ($data->resposta as $reposta) {
                            $pdf->SetFont('arial', '', 8);
                            $html = html_entity_decode( '(   ) ' . $reposta->texto);
                            $html = str_replace(['–' , '—'], '-' ,$html ); 
                            $html = str_replace(['”' , '“'], '"' ,$html );
                            $html = str_replace(['‘' , '’'], '"' ,$html );
                            $html = str_replace('…', '. . .' ,$html );
                            $html = utf8_decode($html); 
                            $pdf->WriteHTML( $html ); 
                        // Fpdf::Write( 5 , '(  ) ' . utf8_decode($reposta->texto));
                            $pdf->Ln();
                        }
                        $pdf->Ln();

                    }
                }
                
            }
            // Muda o tamanho da fonte
            $pdf->SetFont('arial', 'B', 15);
            
            $pdf->AddPage();
            $pdf->MultiCell( 0,5,'GABARITO ',0,'C' ); 
            // Fpdf::Write( 5 , 'GABARITO' );
            $pdf->Ln();

            foreach ($datas as $data) {

                if($data->deleted_at == ''){
                    if($data->status === 'Validada'  || $data->status === 'Finalizada' || (Auth::guard('api')->user()->can('Admin') && $data->status === 'Restrita') ){

                        if( $data->resposta_correta){
                            $pdf->SetFont('arial', '', 15);
                            $pdf->MultiCell( 0,5,'Pergunta ' . $data->id,0,'C' ); 
                            $pdf->SetFont('arial', 'u', 10);
                            
                            $html = html_entity_decode('Resposta Correta ----> ' . $data->resposta_correta->texto);
                            $html = str_replace(['–' , '—'], '-' ,$html ); 
                            $html = str_replace(['”' , '“'], '"' ,$html );
                            $html = str_replace(['‘' , '’'], '"' ,$html );
                            $html = str_replace('…', '. . .' ,$html );
                            $html = utf8_decode($html); 
                            $pdf->WriteHTML( $html ); 
                            
                            $pdf->Ln();
                            $pdf->Ln();
                             // $this->Write(5,$e);
                            $pdf->Write( 5, 'Comentario:' ); 
                            $pdf->Ln();   
                            $pdf->SetFont('arial', '', 10);
                            $html = html_entity_decode(  $data->resumo );
                            $html = str_replace(['–' , '—'], '-' ,$html ); 
                            $html = str_replace(['”' , '“'], '"' ,$html );
                            $html = str_replace(['‘' , '’'], '"' ,$html );
                            $html = str_replace('…', '. . .' ,$html );

                            $html = utf8_decode($html); 
                            $pdf->WriteHTML( $html ); 
                            $pdf->Ln();
                            $pdf->Ln();

                        }
                        
                    }
                }   

            }

        } else {

            // $pdf::Cell(0, 7, 'Nenhum registro de Atividades no periodo', 0, 1, 'C');
        }
        $pdf->Output('questoes.pdf', 'D');
        exit;
        // return  $this->service->Pdf( $request   ) ;
    }



}





















class NewPdf extends Fpdf {

    protected $B = 0;
    protected $I = 0;
    protected $U = 0;
    protected $HREF = '';

    function WriteHTML($html)
    {

        $html = str_replace("\n",' ',$html);
        $a = preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
        foreach($a as $i=>$e){
            if($i%2==0){ 
                if($this->HREF)
                    $this->PutLink($this->HREF,$e);
                else
                    $this->Write(5,$e);
            }
            else{ 
                if($e[0]=='/')
                    $this->CloseTag(strtoupper(substr($e,1)));
                else{ 
                    $a2 = explode(' ',$e);
                    $tag = strtoupper(array_shift($a2));
                    $attr = array();
                    foreach($a2 as $v){
                        if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
                            $attr[strtoupper($a3[1])] = $a3[2];
                    }
                    $this->OpenTag($tag,$attr);
                }
            }
        }
    }

    function OpenTag($tag, $attr){

        if($tag=='B' || $tag=='I' || $tag=='U')
            $this->SetStyle($tag,true);
        if($tag=='A')
            $this->HREF = $attr['HREF'];
        if($tag=='BR')
            $this->Ln(5); 
        if($tag=='IMG')
            $this->Image(public_path( strstr( $attr['SRC'] , '/img'  ) ),50,null,0,90);

    }

    function CloseTag($tag){     
        if($tag=='B' || $tag=='I' || $tag=='U')
            $this->SetStyle($tag,false);
        if($tag=='A')
            $this->HREF = '';
    }

    function SetStyle($tag, $enable){

        $this->$tag += ($enable ? 1 : -1);
        $style = '';
        foreach(array('B', 'I', 'U') as $s)
        {
            if($this->$s>0)
                $style .= $s;
        }
        $this->SetFont('',$style);
    }

    function PutLink($URL, $txt)
    {
    // Put a hyperlink
        $this->SetTextColor(0,0,255);
        $this->SetStyle('U',true);
        $this->Write(5,$txt,$URL);
        $this->SetStyle('U',false);
        $this->SetTextColor(0);
    }




    function Header()
    {
    // Logo   public_path('css/app.css')
        // Fpdf::Image('http://chs2018.educacao.ws/img/pmes.png',10,6,17);
        // $this->Image( public_path('img/pmes.png') ,10,6,17);
        // $this->Image(public_path('img/bolsonaro-2.jpg'),10,6,21);
        // $this->Image(public_path('img/tavares.jpeg'),10,6,20);
        // $this->Image(public_path('img/cavalaria.jpeg'),10,6,35);
        $this->Image(public_path('img/ubuntu.jpg'),10,6,30);
        
        // $this->Image( public_path('img/espada.jpg') ,10,6,35);
        // $this->Image( public_path('img/yin-yang.jpg') ,45,6,20);
        // Fpdf::Image('http://chs2018.educacao.ws/img/brasil.JPG',30,6,22);
        // Fpdf::Image(public_path('img/brasil.JPG'),30,6,22);
        // Fpdf::Image('http://chs2018.educacao.ws/img/cavalaria.jpeg',55,6,25);
        // Fpdf::Image(public_path('img/cavalaria.jpeg'),55,6,25);
    // Arial bold 15
        $this->SetFont('Arial','B',12);
    // Move to the right
        $this->Cell(80);
    // Title
        // $this->Cell(30,0,'Estado do Espirito Santo',0,0,'C');
        $texto = utf8_decode('CURSO DE HABILITAÇÃO DE SARGENTO');
        $this->Cell(30,0,$texto,0,0,'C');

        // $this->Ln(); 
        // $this->Cell(80); 
        // $this->Cell(30,9,'Policia Militar',0,0,'C');


        $texto = utf8_decode('3º Pelotão');
        // $this->Cell(30,10,$texto,0,0,'C');
        
        // $texto = utf8_decode('3º Pelotão'); 
        // $this->Ln(); 
        // $this->Cell(80); 
        // $this->Cell(30,1, $texto ,0,0,'C');

        $this->Ln(); 
        $this->Cell(80); 
        $this->Cell(30,10,'Perguntas para Estudo',0,0,'C');


        $this->Ln(); 
        $this->Cell(80); 
        $texto = utf8_decode('Respostas estão no final do arquivo');
        $this->Cell(30,1,$texto,0,0,'C');

        
        // Fpdf::Image('http://chs2018.educacao.ws/img/brasaoES.jpg',180,6,21);
        // $this->Image(public_path('img/bolsonaro-2.jpg'),157,6,21);
        $this->Image(public_path('img/brasaoES.jpg'),180,6,21);
        // Fpdf::Image('http://chs2018.educacao.ws/img/cfa.jpg',150,0,25);
        // Fpdf::Image(public_path('img/cfa.jpg'),150,0,25);
    // Line break
        $this->Ln(9);
        // $this->Ln(9);
    }

    function Footer()
    {
    // Position at 1.5 cm from bottom
        $this->SetY(-15);
    // Arial italic 8
        $this->SetFont('Arial','I',8);
    // Page number
        $this->Cell(0,7,'Page '.$this->PageNo().'/{nb}',0,0,'C');
        $this->Ln();
        $this->SetFont('Arial','BI',11);
        // $texto = utf8_decode('Solidários, seremos união. Separados uns dos outros seremos pontos de vista. Juntos, alcançaremos a realização de nossos propósitos.'); 
        // $autor = utf8_decode('"Bezerra de Menezes"!!');
        
        // $texto = utf8_decode('"Ubuntu, tio, como poderia um de nós ficar feliz se todos os outros estivessem tristes?"'); 
        // $texto = utf8_decode('"Deus dá as batalhas mais difíceis aos seus melhores soldados." (Papa Francisco) -  "O Inimigo Agora É Outro"'); 
        $texto = utf8_decode('"Welcome to the jungle we take it day by day ... Welcome to the jungle, it gets worse here every day"'); 
        
        $autor = utf8_decode('');

        // $texto = utf8_decode('A união do rebanho obriga o leão a deitar-se com fome.');
        // $autor = utf8_decode('"Provérbio africano"!!');   
        $this->SetTextColor(255,0,0);
        // $this->Write(2,$texto);
        $this->Cell(0,2,$texto,0,0,'C');
        $this->SetFont('Arial','I',7);
        $this->Ln();
        $this->SetTextColor(0,0,0);
        $this->Cell(0,5,$autor,0,1,'C');
    }

}