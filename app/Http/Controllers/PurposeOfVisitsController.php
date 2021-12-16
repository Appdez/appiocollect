<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurposeOfVisits\Create;
use App\Http\Requests\PurposeOfVisits\Setting;
use App\Models\PurposeOfVisit;

class PurposeOfVisitsController extends Controller
{//
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.purpose_of_visit.purpose_of_visit')->with('purpose_of_visits', PurposeOfVisit::all());
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\PurposeOfVisit\Add  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Create $request)
    {
        try {
            PurposeOfVisit::create($request->all());
            session()->flash('success', 'Objectivo da visita criado com sucesso.');
            return redirect()->route('purpose_of_visit.index');
        } catch (\Throwable $e) {
            session()->flash('error', 'Erro na criação do Objectivo da visita.');
            return redirect()->route('purpose_of_visit.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PurposeOfVisit  $PurposeOfVisit
     * @return \Illuminate\Http\Response
     */
    public function show(PurposeOfVisit $purpose_of_visit)
    {
        return $purpose_of_visit;
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PurposeOfVisit  $PurposeOfVisit
     * @return \Illuminate\Http\Response
     */
    public function update(Setting $request, PurposeOfVisit $purpose_of_visit)
    {
        try {
            $purpose_of_visit->update($request->all());
            session()->flash('success', 'Objectivo da visita actualizada com sucesso.');
            return redirect()->route('purpose_of_visit.index');
        } catch (\Throwable $e) {
            session()->flash('error', 'Erro na actualização do objectivo da visita.');
            return redirect()->route('purpose_of_visit.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PurposeOfVisit  $PurposeOfVisit
     * @return \Illuminate\Http\Response
     */
    public function destroy(PurposeOfVisit $purpose_of_visit)
    {


        if ($purpose_of_visit && $purpose_of_visit->benificiaries()->count() == 0) {
            try {
                $purpose_of_visit->delete();
                session()->flash('success', 'Objectivo da visita deletado com sucesso.');
                return redirect()->route('purpose_of_visit.index');
            } catch (\Throwable $e) {
                session()->flash('error', 'Erro ao deletar objectivo da visita.');
                return redirect()->route('purpose_of_visit.index');
            }
        } else {
            session()->flash('error', 'Erro ao deletar: " O objectivo da visita esta sendo usado em um benificiario."');
            return redirect()->route('purpose_of_visit.index');
        }
    }

}
