<?php

namespace App\Http\Controllers;

use App\Http\Requests\Province\Create;
use App\Http\Requests\Province\Setting;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ProvincesRequest;
class ProvincesController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.province.province')->with('provinces', Province::all());
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Province\Add  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Create $request)
    {
        try {
            Province::create($request->all());
            session()->flash('success', 'Provincia criada com sucesso.');
            return redirect()->route('province.index');
        } catch (\Throwable $e) {
            session()->flash('error', 'Erro na criação da provincia.');
            return redirect()->route('province.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Province  $Province
     * @return \Illuminate\Http\Response
     */
    public function show(Province $province)
    {
        return $province;
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Province  $Province
     * @return \Illuminate\Http\Response
     */
    public function update(Setting $request, Province $province)
    {
        try {
            $province->update($request->all());
            session()->flash('success', 'Provincia actualizada com sucesso.');
            return redirect()->route('province.index');
        } catch (\Throwable $e) {
            session()->flash('error', 'Erro na actualização da provincia.');
            return redirect()->route('province.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Province  $Province
     * @return \Illuminate\Http\Response
     */
    public function destroy(Province $province)
    {


        if ($province && $province->neighborhoods()->count() == 0) {
            try {
                $province->delete();
                session()->flash('success', 'Provincia deletada com sucesso.');
                return redirect()->route('province.index');
            } catch (\Throwable $e) {
                session()->flash('error', 'Erro ao deletar provincia.');
                return redirect()->route('province.index');
            }
        } else {
            session()->flash('error', 'Erro ao deletar: " A província esta sendo usado em um bairro."');
            return redirect()->route('province.index');
        }
    }
}
