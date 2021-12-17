<?php

namespace App\Http\Controllers;

use App\Http\Requests\Distrito\Create;
use App\Http\Requests\Distrito\Setting;
use App\Models\District;
class DistrictsController extends Controller
{/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.district.district')->with('districts', District::all());
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\District\Add  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Create $request)
    {
        try {
            District::create($request->all());
            session()->flash('success', 'Distrito criado com sucesso.');
            return redirect()->route('district.index');
        } catch (\Throwable $e) {
            session()->flash('error', 'Erro na criação da Distrito.');
            return redirect()->route('district.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\District  $District
     * @return \Illuminate\Http\Response
     */
    public function show(District $district)
    {
        return $district;
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\District  $District
     * @return \Illuminate\Http\Response
     */
    public function update(Setting $request, District $district)
    {
        try {
            $district->update($request->all());
            session()->flash('success', 'Distrito actualizada com sucesso.');
            return redirect()->route('district.index');
        } catch (\Throwable $e) {
            session()->flash('error', 'Erro na actualização do distrito.');
            return redirect()->route('district.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\District  $District
     * @return \Illuminate\Http\Response
     */
    public function destroy(District $district)
    {


        if ($district && $district->benificiaries()->count() == 0) {
            try {
                $district->delete();
                session()->flash('success', 'Distrito deletado com sucesso.');
                return redirect()->route('district.index');
            } catch (\Throwable $e) {
                session()->flash('error', 'Erro ao deletar distrito.');
                return redirect()->route('district.index');
            }
        } else {
            session()->flash('error', 'Erro ao deletar: " O distrito esta sendo usado em um benificiario."');
            return redirect()->route('district.index');
        }
    }

}
