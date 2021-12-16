<?php

namespace App\Http\Controllers\Api\Syncronization;

use App\Http\Controllers\Controller;
use App\Models\DocumentType;
use App\Models\ForwardedService;
use App\Models\Genre;
use App\Models\Neighborhood;
use App\Models\Provenace;
use App\Models\PurposeOfVisit;
use App\Models\ReasonOpeningCase;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BenificiaryController as Server;
use App\Models\Benificiary;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
class Sync extends Controller
{

    public function ben()
    {
        $beneficiaries =  collect(Benificiary::where('neighborhood_uuid', Auth::user()->neighborhood_uuid)->get());
        $benificiaries = $beneficiaries->map(function($ben,$key){
             $ben->created_at = $ben->created_at->format('Y-m-d H:i:s.u');
             $ben->updated_at = $ben->updated_at->format('Y-m-d H:i:s.u');
             return $ben;
        });
        return $benificiaries;
    }

    public function addCreated(Request  $request)
    {
        $errorOnCreating = Array();
        $created = $request->all();


        //return $created; //dd(Storage::put('json.json', $created));
        //$created = collect($created)->sortBy('created_at');
        foreach ($created as $ben) {
            try {
                 Benificiary::create($ben);
               } catch (\Throwable $th) {
                   array_push($errorOnCreating,$ben);
               }
        }
        return $errorOnCreating;
    }

    public function updateUpdated(Request  $request)
    {
        $errorOnUpdating = Array();
        $updated = $request->all();

        foreach ($updated as $ben) {
           try {
            Benificiary::where('uuid',$ben['uuid'])->get()->first()->update($ben);
           } catch (\Throwable $th) {
            if( Benificiary::where('uuid',$ben['uuid'])->count() > 0){
                array_push($errorOnDeleting,$ben);
            }
           }
        }
        return $errorOnUpdating;
    }

    public function deleteDeleted(Request $request)
    {
        $errorOnDeleting = Array();
        $deleted = $request->all();
        foreach ($deleted as $ben) {
            try {
                Benificiary::where('uuid',$ben['uuid'])->get()->first()->delete();
               } catch (\Throwable $th) {
                    if( Benificiary::where('uuid',$ben['uuid'])->count() > 0){
                        array_push($errorOnDeleting,$ben);
                    }
               }
        }
        return $errorOnDeleting;
    }


    public function settings()
    {
        return [
            'document_types' => DocumentType::all(),
            'forwarded_services' => ForwardedService::all(),
            'genres' => Genre::all(),
            'neighborhoods' => Neighborhood::where('uuid', auth()->user()->neighborhood_uuid)
                ->get(),
            'provenances' => Provenace::all(),
            'propuses_of_visits' => PurposeOfVisit::all(),
            'reason_of_opening_cases' => ReasonOpeningCase::all(),
            'benificiaries' => $this->ben()
        ];
    }
}
