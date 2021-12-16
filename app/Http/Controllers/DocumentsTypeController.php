<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentType\Create;
use App\Http\Requests\DocumentType\Setting;
use App\Models\DocumentType;
class DocumentsTypeController extends Controller
{
         /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.document_type.document_type')->with('document_types', DocumentType::all());
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\DocumentType\Add  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Create $request)
    {
        try {
            DocumentType::create($request->all());
            session()->flash('success', 'Documento necessário criado com sucesso.');
            return redirect()->route('document_type.index');
        } catch (\Throwable $e) {
            session()->flash('error', 'Erro na criação do Documento necessário.');
            return redirect()->route('document_type.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DocumentType  $DocumentType
     * @return \Illuminate\Http\Response
     */
    public function show(DocumentType $document_type)
    {
        return $document_type;
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DocumentType  $DocumentType
     * @return \Illuminate\Http\Response
     */
    public function update(Setting $request, DocumentType $document_type)
    {
        try {
            $document_type->update($request->all());
            session()->flash('success', 'Documento necessário actualizado com sucesso.');
            return redirect()->route('document_type.index');
        } catch (\Throwable $e) {
            session()->flash('error', 'Erro na actualização do Documento necessário.');
            return redirect()->route('document_type.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DocumentType  $DocumentType
     * @return \Illuminate\Http\Response
     */
    public function destroy(DocumentType $document_type)
    {


        if ($document_type && $document_type->benificiaries()->count() == 0) {
            try {
                $document_type->delete();
                session()->flash('success', 'Documento necessário deletado com sucesso.');
                return redirect()->route('document_type.index');
            } catch (\Throwable $e) {
                session()->flash('error', 'Erro ao deletar Documento necessário.');
                return redirect()->route('document_type.index');
            }
        } else {
            session()->flash('error', 'Erro ao deletar: " O Documento necessário esta sendo usado em um benificiario."');
            return redirect()->route('document_type.index');
        }
    }
}
