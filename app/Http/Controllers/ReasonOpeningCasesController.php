<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReasonOpeningCase\Create;
use App\Http\Requests\ReasonOpeningCase\Setting;
use App\Models\ReasonOpeningCase;

class ReasonOpeningCasesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.reason_opening_case.reason_opening_case')->with('reason_opening_cases', ReasonOpeningCase::all());
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ReasonOpeningCase\Add  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Create $request)
    {
        try {
            ReasonOpeningCase::create($request->all());
            session()->flash('success', 'Motivo de abertura de processo criado com sucesso.');
            return redirect()->route('reason_opening_case.index');
        } catch (\Throwable $e) {
            session()->flash('error', 'Erro na criação do Motivo de abertura de processo.');
            return redirect()->route('reason_opening_case.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ReasonOpeningCase  $ReasonOpeningCase
     * @return \Illuminate\Http\Response
     */
    public function show(ReasonOpeningCase $reason_opening_case)
    {
        return $reason_opening_case;
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ReasonOpeningCase  $ReasonOpeningCase
     * @return \Illuminate\Http\Response
     */
    public function update(Setting $request, ReasonOpeningCase $reason_opening_case)
    {
        try {
            $reason_opening_case->update($request->all());
            session()->flash('success', 'Motivo de abertura de processo actualizada com sucesso.');
            return redirect()->route('reason_opening_case.index');
        } catch (\Throwable $e) {
            session()->flash('error', 'Erro na actualização do objectivo da visita.');
            return redirect()->route('reason_opening_case.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReasonOpeningCase  $ReasonOpeningCase
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReasonOpeningCase $reason_opening_case)
    {


        if ($reason_opening_case && $reason_opening_case->benificiaries()->count() == 0) {
            try {
                $reason_opening_case->delete();
                session()->flash('success', 'Motivo de abertura de processo deletado com sucesso.');
                return redirect()->route('reason_opening_case.index');
            } catch (\Throwable $e) {
                session()->flash('error', 'Erro ao deletar objectivo da visita.');
                return redirect()->route('reason_opening_case.index');
            }
        } else {
            session()->flash('error', 'Erro ao deletar: " O objectivo da visita esta sendo usado em um benificiario."');
            return redirect()->route('reason_opening_case.index');
        }
}
}
