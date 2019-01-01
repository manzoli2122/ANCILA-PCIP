<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetSenhaMail extends Mailable
{
    use Queueable, SerializesModels;

    private $senha;

    /**
     * The subject of the message.
     *
     * @var string
     */
    public $subject ;



    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($senha)
    {
        $this->subject = "Nova senha do " . env('APP_NAME') ;
        $this->senha =$senha ;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.resetsenha.reset' )->with('senha' , $this->senha );
        // return $this->view('view.name');
    }
}
