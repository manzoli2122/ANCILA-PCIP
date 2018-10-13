<?php

namespace App\Service\Administrador ;

use App\Models\Administrador\Pergunta;
use Yajra\DataTables\DataTables;
use App\Service\VueService; 
use Illuminate\Http\Request; 
use DB;

use Fpdf;


class NewPdf extends Fpdf{

    protected $B = 0;
    protected $I = 0;
    protected $U = 0;
    protected $HREF = '';

    function WriteHTML($html)
    {
    // HTML parser
        $html = str_replace("\n",' ',$html);
        $a = preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
        foreach($a as $i=>$e)
        {
            if($i%2==0)
            {
            // Text
                if($this->HREF)
                    $this->PutLink($this->HREF,$e);
                else
                    Fpdf::Write(5,$e);
            }
            else
            {
            // Tag
                if($e[0]=='/')
                    $this->CloseTag(strtoupper(substr($e,1)));
                else
                {
                // Extract attributes
                    $a2 = explode(' ',$e);
                    $tag = strtoupper(array_shift($a2));
                    $attr = array();
                    foreach($a2 as $v)
                    {
                        if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
                            $attr[strtoupper($a3[1])] = $a3[2];
                    }
                    $this->OpenTag($tag,$attr);
                }
            }
        }
    }

    function OpenTag($tag, $attr)
    {
    // Opening tag
        if($tag=='B' || $tag=='I' || $tag=='U')
            $this->SetStyle($tag,true);
        if($tag=='A')
            $this->HREF = $attr['HREF'];
        if($tag=='BR')
            Fpdf::Ln(5);
    }

    function CloseTag($tag)
    {
    // Closing tag
        if($tag=='B' || $tag=='I' || $tag=='U')
            $this->SetStyle($tag,false);
        if($tag=='A')
            $this->HREF = '';
    }

    function SetStyle($tag, $enable)
    {
    // Modify style and select corresponding font
        $this->$tag += ($enable ? 1 : -1);
        $style = '';
        foreach(array('B', 'I', 'U') as $s)
        {
            if($this->$s>0)
                $style .= $s;
        }
        Fpdf::SetFont('',$style);
    }

    function PutLink($URL, $txt)
    {
    // Put a hyperlink
        Fpdf::SetTextColor(0,0,255);
        $this->SetStyle('U',true);
        Fpdf::Write(5,$txt,$URL);
        $this->SetStyle('U',false);
        Fpdf::SetTextColor(0);
    }
}


class PerguntaService extends VueService  implements PerguntaServiceInterface 
{


    protected $model;   


    protected $dataTable; 






    public function __construct( Pergunta $pergunta , DataTables $dataTable ){  
        $this->model = $pergunta ;    
        $this->dataTable = $dataTable ; 
    }




    public function  BuscarCriada( Request $request  ){
     return $this->model->where('status', 'Criada')->get();
 }



     /** 
    * Busca um model pelo id
    *
    * @param int $id
    *
    * @return $model
    */
     public function  BuscarPeloId( Request $request , $id ){ 
        $model = $this->model->with('assunto')->with('resposta')->find($id)  ;
        return   $model   ; 
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
        throw_if(!$model = $this->model->withTrashed()->find($id), ModelNotFoundException::class);
        $model->restore(); 
        return 'Ativado';
    }









    /**
    * Funcao para buscar as permissoes pelo datatable  
    *
    * @param Request $request 
    *
    * @return json
    */
    public function  BuscarDataTable( $request ){
        $models = $this->model->getDatatable();
        return $this->dataTable->eloquent($models)
        ->addColumn('action', function($linha) {

            if($linha->deleted_at != ''){
                return '<button data-id="'.$linha->id.'" btn-ativar class="btn btn-success btn-sm" title="Ativar"><i class="fa fa-thumbs-up"></i> </button>' 
                .'<button data-id="'.$linha->id.'" btn-excluir class="btn btn-danger btn-sm" title="Excluir Definitivamente"><i class="fa fa-trash"></i></button>';
            } 
            return 
            '<a href="#/edit/'.$linha->id.'" class="btn btn-success btn-sm" title="Editar"><i class="fa fa-pencil"></i></a>'
            . '<a href="#/show/'.$linha->id.'" class="btn btn-primary btn-sm" title="Visualizar" style="margin-left: 10px;"><i class="fa fa-search"></i></a>'
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

    

    



    /**
    * Função para excluir um model  
    *
    * @param int $id
    *    
    * @return void
    */
    public function  Apagar( Request $request , $id ){

        if( $model = $this->model->find($id)){
            // foreach ( $model->assuntos as $assunto ) {
            //     $assunto->delete();
            // } 
            $model->delete() ; 
            return; 
        }
        
        if( $model = $this->model->onlyTrashed()->find($id)){
            $model->forceDelete(); 
            return; 
        }

        throw_if( true , ModelNotFoundException::class);   

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

        $pdf::SetTitle("Questões para Estudo");
        $pdf::SetSubject("DTIC Sempre Presente, contruindo o seu futuro.");
        // $pdf ::SetAuthor('bruno'); 
        // $pdf ::SetKeywords('baon cco desempenho individual ');
        //Seta a posicao vertical e horizontal  
        $pdf::SetY(-10);
        $pdf::AddPage();
        $pdf::AliasNbPages();
        $pdf::SetAutoPageBreak(10, 10);

        $pdf::SetFont('Arial', 'u', 11);

        // Fpdf::Write(5,"To find out what's new in this tutorial, click ");
        

        if (count($datas) > 1) {

           

            foreach ($datas as $data) {


                if($data->deleted_at == ''){
                    if($data->status === 'Validada'  || $data->status === 'Finalizada' ){
                        
                        $pdf::SetFont('arial', '', 10);

                        $html = html_entity_decode( $data->id . ') ' . $data->texto);
                        $html = utf8_decode($html); 
                        $pdf->WriteHTML( $html ); 
                        Fpdf::Ln();
                        foreach ($data->resposta as $reposta) {
                            $pdf::SetFont('arial', '', 8);
                            $html = html_entity_decode( '(   ) ' . $reposta->texto);
                            $html = utf8_decode($html); 
                            $pdf->WriteHTML( $html ); 
                        // Fpdf::Write( 5 , '(  ) ' . utf8_decode($reposta->texto));
                            Fpdf::Ln();
                        }
                        Fpdf::Ln();

                    }
                }
                



            }
            // Muda o tamanho da fonte
            $pdf::SetFont('arial', '', 10);
            
            $pdf::AddPage();
            Fpdf::Write( 5 , 'GABARITO' );
            Fpdf::Ln();


            foreach ($datas as $data) {

                if($data->deleted_at == ''){
                    if($data->status === 'Validada'  || $data->status === 'Finalizada' ){
                        
                        if( $data->resposta_correta){
                            $pdf::SetFont('arial', '', 15);
                            Fpdf::MultiCell( 0,5,'Pergunta ' . $data->id,0,'C' ); 
                            $pdf::SetFont('arial', 'u', 10);
                            $html = html_entity_decode('Resposta ----> ' . $data->resposta_correta->texto);
                            $html = utf8_decode($html); 
                            $pdf->WriteHTML( $html ); 
                            Fpdf::Ln();   
                            $pdf::SetFont('arial', '', 10);
                            $html = html_entity_decode(  $data->resumo);
                            $html = utf8_decode($html); 
                            $pdf->WriteHTML( $html ); 
                            Fpdf::Ln();
                            Fpdf::Ln();




                        }

                        
                    }
                }   

            }


        } else {

            // $pdf::Cell(0, 7, 'Nenhum registro de Atividades no periodo', 0, 1, 'C');
        }
        $pdf::Output('questoes.pdf', 'D');
        exit;

    }




}
