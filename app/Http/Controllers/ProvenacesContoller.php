<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Provenace;
use App\Http\Requests\ProvenacesRequest;
use App\Http\Requests\Provenance\Create;
use App\Http\Requests\Provenance\Setting;

class ProvenacesContoller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.provenace.provenace')->with('provenaces', Provenace::all());
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Provenace\Add  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Create $request)
    {
        try {
            Provenace::create($request->all());
            session()->flash('success', 'Genero criado com sucesso.');
            return redirect()->route('provenace.index');
        } catch (\Throwable $e) {
            session()->flash('error', 'Erro na criação do Genero.');
            return redirect()->route('provenace.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Provenace  $Provenace
     * @return \Illuminate\Http\Response
     */
    public function show(Provenace $provenace)
    {
        return $provenace;
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Provenace  $Provenace
     * @return \Illuminate\Http\Response
     */
    public function update(Setting $request, Provenace $provenace)
    {
        try {
            $provenace->update($request->all());
            session()->flash('success', 'Genero actualizada com sucesso.');
            return redirect()->route('provenace.index');
        } catch (\Throwable $e) {
            session()->flash('error', 'Erro na actualização do proviniência.');
            return redirect()->route('provenace.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Provenace  $Provenace
     * @return \Illuminate\Http\Response
     */
    public function destroy(Provenace $provenace)
    {


        if ($provenace && $provenace->benificiaries()->count() == 0) {
            try {
                $provenace->delete();
                session()->flash('success', 'Genero deletado com sucesso.');
                return redirect()->route('provenace.index');
            } catch (\Throwable $e) {
                session()->flash('error', 'Erro ao deletar proviniência.');
                return redirect()->route('provenace.index');
            }
        } else {
            session()->flash('error', 'Erro ao deletar: " O proviniência esta sendo usado em um benificiario."');
            return redirect()->route('provenace.index');
        }
    }

}
