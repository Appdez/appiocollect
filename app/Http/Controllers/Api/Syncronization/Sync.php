<?php

namespace App\Http\Controllers\Api\Syncronization;

use App\Http\Controllers\Controller;
use App\Models\Benefit;
use App\Models\Benificiary;
use App\Models\District;
use App\Models\Genre;
use App\Models\ProjectArea;
use Illuminate\Http\Request;
class Sync extends Controller
{

    public function ben()
    {
        $beneficiaries = Benificiary::with(
            'project_areas'
        )->with(
            'benefits')->get();
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
            'benefits' => Benefit::all(),
            'districts' => District::all(),
            'genres' => Genre::all(),
            'project_areas' => ProjectArea::all(),
            'benificiaries' => $this->ben()
        ];
    }
}
