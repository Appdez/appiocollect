<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Resources\NeighborhoodsResource;
use App\Models\Neighborhood;
use App\Http\Requests\NeighborhoodsRequest;
use App\Http\Requests\Neighbornhood\Create;
use App\Http\Requests\Neighbornhood\Setting;
use App\Models\Province;

class NeighborhoodsController extends Controller
{
       /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.bairro.bairro')->with('bairros', Neighborhood::all())->with('cidades',Province::all());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Neighborhood\Setting  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Create $request)
    {
        try {
            Neighborhood::create($request->all());
            session()->flash('success', 'Bairro criado com sucesso.');
            return redirect()->route('bairro.index');
        } catch (\Throwable $e) {
            session()->flash('error', 'Erro na criação do bairro.');
            return redirect()->route('bairro.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Neighborhood  $bairro
     * @return \Illuminate\Http\Response
     */
    public function show(Neighborhood $bairro)
    {
        return $bairro;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Neighborhood  $bairro
     * @return \Illuminate\Http\Response
     */
    public function edit(Neighborhood $bairro)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Neighborhood  $bairro
     * @return \Illuminate\Http\Response
     */
    public function update(Setting $request, Neighborhood $bairro)
    {
        try {
            $bairro->update($request->all());
            session()->flash('success', 'Bairro actualizado com sucesso.');
            return redirect()->route('bairro.index');
        } catch (\Throwable $e) {
            session()->flash('error', 'Erro na actualização do bairro.');
            return redirect()->route('bairro.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Neighborhood  $bairro
     * @return \Illuminate\Http\Response
     */
    public function destroy(Neighborhood $bairro)
    {


        if ($bairro && $bairro->benificiaries()->count() == 0) {
            try {
                $bairro->delete();
                session()->flash('success', 'Bairro deletado com sucesso.');
                return redirect()->route('bairro.index');
            } catch (\Throwable $e) {
                session()->flash('error', 'Erro ao deletar bairro.');
                return redirect()->route('bairro.index');
            }
        } else {
            session()->flash('error', 'Erro ao deletar: " O bairro esta sendo usado em um benificiario."');
            return redirect()->route('bairro.index');
        }
    }
}
