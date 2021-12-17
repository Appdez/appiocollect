<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectArea\Create;
use App\Http\Requests\ProjectArea\Setting;
use App\Models\ProjectArea;
class ProjectAreasController extends Controller
{/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.project_area.project_area')->with('project_areas', ProjectArea::all());
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ProjectArea\Add  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Create $request)
    {
        try {
            ProjectArea::create($request->all());
            session()->flash('success', 'Area do projecto criado com sucesso.');
            return redirect()->route('project_area.index');
        } catch (\Throwable $e) {
            session()->flash('error', 'Erro na criação da Area do projecto.');
            return redirect()->route('project_area.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProjectArea  $ProjectArea
     * @return \Illuminate\Http\Response
     */
    public function show(ProjectArea $project_area)
    {
        return $project_area;
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProjectArea  $ProjectArea
     * @return \Illuminate\Http\Response
     */
    public function update(Setting $request, ProjectArea $project_area)
    {
        try {
            $project_area->update($request->all());
            session()->flash('success', 'Area do projecto actualizada com sucesso.');
            return redirect()->route('project_area.index');
        } catch (\Throwable $e) {
            session()->flash('error', 'Erro na actualização da area do projecto.');
            return redirect()->route('project_area.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProjectArea  $ProjectArea
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProjectArea $project_area)
    {


        if ($project_area && $project_area->benificiaries()->count() == 0) {
            try {
                $project_area->delete();
                session()->flash('success', 'Area do projecto deletado com sucesso.');
                return redirect()->route('project_area.index');
            } catch (\Throwable $e) {
                session()->flash('error', 'Erro ao deletar area do projecto.');
                return redirect()->route('project_area.index');
            }
        } else {
            session()->flash('error', 'Erro ao deletar: " A area do projecto esta sendo usado em um benificiario."');
            return redirect()->route('project_area.index');
        }
    }

}
