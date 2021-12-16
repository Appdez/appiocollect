<?php

namespace App\Console\Commands;

use App\Models\Neighborhood;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\EnviarRelatorio as MailEnviarRelatorio;
use App\Models\SendMail;
use App\Http\Controllers\DashbordController;
use Illuminate\Support\Facades\Storage;

class SendReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:report';
     public $controller;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send report with email to  especific users monthly';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->controller = new DashbordController();
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $mails = SendMail::all()->map(function($mail){
            $mail->details = [
                'title' => 'Relatório mensal de Base de Dados Biosp',
                'body' =>
                [
                'Bom dia, espero que esteja bem',

                    'Envio em anexo os relatórios de base de dados ' .
                    'referentes as datas de  ' . date_format(now(), 'd-M-Y') . ' a ' .
                    date_format(now(), 'd-M-Y')

                ], 'bairros' => $mail->neighborhoods];
                return $mail;
        });

        if ($mails->count() > 0) {
            try {
                foreach ($mails as $recipient) {

                    $paths = array();

                    foreach ($recipient->details['bairros'] as $value) {
                        $path = $this->controller->thisMonthForMail($value);
                        if($path != null) array_push($paths,$path);
                    }

                    Mail::to($recipient->email)->send(new MailEnviarRelatorio($recipient->details,$paths));
                }

                $this->info('Email sent successful.');
                Storage::deleteDirectory('rl');
                $this->info('Storage cleaned successful.');

            } catch (\Throwable $th) {
                $this->info('Fail with send email');
            }
        }else  $this->info('Fail with send email');

    }
}
