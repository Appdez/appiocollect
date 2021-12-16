<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForwardedService\Create;
use App\Http\Requests\ForwardedService\Setting;
use App\Models\ForwardedService;

class ForwardedServicesController extends Controller
{
/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.forwarded_service.forwarded_service')->with('forwarded_services', ForwardedService::all());
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ForwardedService\Add  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Create $request)
    {
        try {
            ForwardedService::create($request->all());
            session()->flash('success', 'Genero criado com sucesso.');
            return redirect()->route('forwarded_service.index');
        } catch (\Throwable $e) {
            session()->flash('error', 'Erro na criação da Genero.');
            return redirect()->route('forwarded_service.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ForwardedService  $ForwardedService
     * @return \Illuminate\Http\Response
     */
    public function show(ForwardedService $forwarded_service)
    {
        return $forwarded_service;
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ForwardedService  $ForwardedService
     * @return \Illuminate\Http\Response
     */
    public function update(Setting $request, ForwardedService $forwarded_service)
    {
        try {
            $forwarded_service->update($request->all());
            session()->flash('success', 'Genero actualizada com sucesso.');
            return redirect()->route('forwarded_service.index');
        } catch (\Throwable $e) {
            session()->flash('error', 'Erro na actualização do Serviço encaminhado.');
            return redirect()->route('forwarded_service.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ForwardedService  $ForwardedService
     * @return \Illuminate\Http\Response
     */
    public function destroy(ForwardedService $forwarded_service)
    {


        if ($forwarded_service && $forwarded_service->benificiaries()->count() == 0) {
            try {
                $forwarded_service->delete();
                session()->flash('success', 'Genero deletado com sucesso.');
                return redirect()->route('forwarded_service.index');
            } catch (\Throwable $e) {
                session()->flash('error', 'Erro ao deletar Serviço encaminhado.');
                return redirect()->route('forwarded_service.index');
            }
        } else {
            session()->flash('error', 'Erro ao deletar: " O Serviço encaminhado esta sendo usado em um benificiario."');
            return redirect()->route('forwarded_service.index');
        }
    }
}
