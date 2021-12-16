<?php

namespace App\Http\Controllers;

use App\Http\Requests\Genero\Create;
use App\Http\Requests\Genero\Setting;
use App\Models\Genre;
class GenresController extends Controller
{/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.genre.genre')->with('genres', Genre::all());
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Genre\Add  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Create $request)
    {
        try {
            Genre::create($request->all());
            session()->flash('success', 'Genero criado com sucesso.');
            return redirect()->route('genre.index');
        } catch (\Throwable $e) {
            session()->flash('error', 'Erro na criação da Genero.');
            return redirect()->route('genre.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Genre  $Genre
     * @return \Illuminate\Http\Response
     */
    public function show(Genre $genre)
    {
        return $genre;
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Genre  $Genre
     * @return \Illuminate\Http\Response
     */
    public function update(Setting $request, Genre $genre)
    {
        try {
            $genre->update($request->all());
            session()->flash('success', 'Genero actualizada com sucesso.');
            return redirect()->route('genre.index');
        } catch (\Throwable $e) {
            session()->flash('error', 'Erro na actualização do genero.');
            return redirect()->route('genre.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Genre  $Genre
     * @return \Illuminate\Http\Response
     */
    public function destroy(Genre $genre)
    {


        if ($genre && $genre->benificiaries()->count() == 0) {
            try {
                $genre->delete();
                session()->flash('success', 'Genero deletado com sucesso.');
                return redirect()->route('genre.index');
            } catch (\Throwable $e) {
                session()->flash('error', 'Erro ao deletar genero.');
                return redirect()->route('genre.index');
            }
        } else {
            session()->flash('error', 'Erro ao deletar: " O genero esta sendo usado em um benificiario."');
            return redirect()->route('genre.index');
        }
    }

}
