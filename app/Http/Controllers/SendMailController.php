<?php

namespace App\Http\Controllers;

use App\Models\Neighborhood;
use App\Models\SendMail;
use App\Models\SendMailNeighborhood;
use Illuminate\Http\Request;

use function PHPSTORM_META\map;

class SendMailController extends Controller
{
 /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $emails = SendMail::all()->map(function($mail){
            $mail->bairros = $mail->neighborhoods;
           // dd($mail);
            return $mail;
        });
       // dd($emails);
        return view('backend.sendMail.sendMail')->with('sendMails', $emails)->with('bairros',Neighborhood::all());
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\SendMail\Add  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // dd($request->all());
        $request->validate([
            'email' => 'required|email|unique:send_mails',
            'neiborhoods' => 'required|array'
        ]);

        try {
            $email = SendMail::create(['email'=>$request->email]);
            foreach ($request->neiborhoods as $neiborhood) {
                SendMailNeighborhood::create([
                    'send_mail_uuid' => $email->uuid,
                    'neighborhood_uuid' => $neiborhood
                ]);
            }
            session()->flash('success', 'Email criado com sucesso.');
            return redirect()->route('sendMail.index');
        } catch (\Throwable $e) {
            throw $e;
            session()->flash('error', 'Erro na criação do email.');
            return redirect()->route('sendMail.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SendMail  $SendMail
     * @return \Illuminate\Http\Response
     */
    public function show(SendMail $sendMail)
    {
        return $sendMail;
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SendMail  $SendMail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SendMail $sendMail)
    {
        $request->validate([
            'email' => 'required|email',
            'neiborhoods' => 'required|array'
        ]);
        try {
             $sendMail->update([
                'email' => $request->email
             ]);

            $mails =  SendMailNeighborhood::where('send_mail_uuid',$sendMail->uuid)->get();

            foreach ($mails as  $mail) {
                $mail->delete();
            }

            foreach ($request->neiborhoods as $neiborhood) {
                SendMailNeighborhood::create([
                    'send_mail_uuid' => $sendMail->uuid,
                    'neighborhood_uuid' => $neiborhood
                ]);
            }

            session()->flash('success', 'Email actualizado com sucesso.');
            return redirect()->route('sendMail.index');
        } catch (\Throwable $e) {
            session()->flash('error', 'Erro na actualização do email.');
            return redirect()->route('sendMail.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SendMail  $SendMail
     * @return \Illuminate\Http\Response
     */
    public function destroy(SendMail $sendMail)
    {


        if ($sendMail) {
            try {
                $mails =  SendMailNeighborhood::where('send_mail_uuid',$sendMail->uuid)->get();

                foreach ($mails as  $mail) {
                    $mail->delete();
                }
                $sendMail->delete();
                session()->flash('success', 'Email deletado com sucesso.');
                return redirect()->route('sendMail.index');
            } catch (\Throwable $e) {
                session()->flash('error', 'Erro ao deletar email.');
                return redirect()->route('sendMail.index');
            }
        } else {
            session()->flash('error', 'Erro ao deletar: " A província esta sendo usado em um bairro."');
            return redirect()->route('sendMail.index');
        }
    }
}
