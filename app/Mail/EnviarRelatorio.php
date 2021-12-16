<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EnviarRelatorio extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

     public $detalhes;
     public $paths;

    public function __construct($detalhes,$paths)
    {   $this->detalhes = $detalhes;
        $this->paths = $paths;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email =  $this->subject('Relatório mensal de base de dados BIOSP.')
        ->view('backend.relatorios');
        foreach ($this->paths as $path) {
            $email->attachFromStorage($path);
        }
    }
}
