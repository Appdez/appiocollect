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
        $beneficiaries =  Benificiary::with(
            'project_areas'
        )->with(
            'benefits')->get()->unique(function ($item) {
            return $item['full_name'] .
            $item['district_uuid'] .
            $item['project_area_uuid'] .
            $item['age'] .
            $item['qualification'] .
            $item['zone'] .
            $item['location'];
        })->values()->all();
        $beneficiaries  = collect($beneficiaries);
        $benificiaries = $beneficiaries->map(function ($ben, $key) {
            $ben->created_at = $ben->created_at->format('Y-m-d H:i:s.u');
            $ben->updated_at = $ben->updated_at->format('Y-m-d H:i:s.u');
            return $ben;
        });
        return $benificiaries;
    }

    public function addCreated(Request  $request)
    {
        $errorOnCreating = array();
        $created = $request->all();

        foreach ($created as $ben) {
            try {
                 $benificiary = Benificiary::create([
                    'full_name' => $ben['full_name'] ,
                    'age'=> $ben['age'],
                    'qualification'=> $ben['qualification'],
                    'form_number'=> $ben['form_number'],
                    'zone'=> $ben['zone'],
                    'location'=> $ben['location'],
                    'district_uuid'=> $ben['district_uuid'],
                    'genre_uuid'=> $ben['genre_uuid']
                 ]);

                 $benificiary->project_areas()->sync(collect($ben['project_areas'])->pluck('uuid'));
                 $benificiary->benefits()->sync(collect($ben['benefits'])->pluck('uuid'));

               } catch (\Throwable $th) {
                   array_push($errorOnCreating,$ben);
               }
        }
        return $errorOnCreating;
    }

    public function updateUpdated(Request  $request)
    {
        $errorOnUpdating = array();
        $updated = $request->all();

        foreach ($updated as $ben) {
           try {
            Benificiary::where('uuid',$ben['uuid'])->get()->first()->update(
                [
                    'full_name' => $ben['full_name'] ,
                    'age'=> $ben['age'],
                    'qualification'=> $ben['qualification'],
                    'form_number'=> $ben['form_number'],
                    'zone'=> $ben['zone'],
                    'location'=> $ben['location'],
                    'district_uuid'=> $ben['district_uuid'],
                    'genre_uuid'=> $ben['genre_uuid']
                 ]
            );
            $benificiary =  Benificiary::where('uuid',$ben['uuid'])->get()->first();
            $benificiary->project_areas()->sync(collect($ben['project_areas'])->pluck('uuid'));
            $benificiary->benefits()->sync(collect($ben['benefits'])->pluck('uuid'));
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
        $errorOnDeleting = array();
        $deleted = $request->all();
        foreach ($deleted as $ben) {
            try {

                $benificiary =   Benificiary::where('uuid',$ben['uuid'])->get()->first();
                $benificiary->project_areas()->sync([]);
                $benificiary->benefits()->sync([]);
                $benificiary->delete();
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
