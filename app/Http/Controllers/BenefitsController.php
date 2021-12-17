<?php

namespace App\Http\Controllers;

use App\Http\Requests\Beneficio\Create;
use App\Http\Requests\Beneficio\Setting;
use App\Models\Benefit;
class BenefitsController extends Controller
{/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.benefit.benefit')->with('benefits', Benefit::all());
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Benefit\Add  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Create $request)
    {
        try {
            Benefit::create($request->all());
            session()->flash('success', 'Beneficio criado com sucesso.');
            return redirect()->route('benefit.index');
        } catch (\Throwable $e) {
            session()->flash('error', 'Erro na criação da Beneficio.');
            return redirect()->route('benefit.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Benefit  $Benefit
     * @return \Illuminate\Http\Response
     */
    public function show(Benefit $benefit)
    {
        return $benefit;
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Benefit  $Benefit
     * @return \Illuminate\Http\Response
     */
    public function update(Setting $request, Benefit $benefit)
    {
        try {
            $benefit->update($request->all());
            session()->flash('success', 'Beneficio actualizada com sucesso.');
            return redirect()->route('benefit.index');
        } catch (\Throwable $e) {
            session()->flash('error', 'Erro na actualização do beneficio.');
            return redirect()->route('benefit.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Benefit  $Benefit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Benefit $benefit)
    {


        if ($benefit && $benefit->benificiaries()->count() == 0) {
            try {
                $benefit->delete();
                session()->flash('success', 'Beneficio deletado com sucesso.');
                return redirect()->route('benefit.index');
            } catch (\Throwable $e) {
                session()->flash('error', 'Erro ao deletar beneficio.');
                return redirect()->route('benefit.index');
            }
        } else {
            session()->flash('error', 'Erro ao deletar: " O beneficio esta sendo usado em um benificiario."');
            return redirect()->route('benefit.index');
        }
    }

}
