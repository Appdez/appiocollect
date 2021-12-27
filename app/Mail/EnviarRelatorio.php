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

     public $paths;

    public function __construct($paths)
    {
        $this->paths = $paths;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email =  $this->subject('Base de dados de inquérito.')
        ->view('backend.relatorios');
        foreach ($this->paths as $path) {
            $email->attachFromStorage($path);
        }
    }
}
