<?php

namespace App\Http\Controllers;

use App\Http\Resources\BenificiaryResource;
use App\Models\Benificiary;
use Illuminate\Http\Request;
use App\Imports\Biosp as BiospImport;
use App\Exports\Biosp as BiospExport;
use Maatwebsite\Excel\Facades\Excel;

class DashbordController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         return view('backend.dashboard')->with([
                'benifiarios' => collect(Benificiary::all()->unique(function ($item) {
                    return $item['full_name'] .
                    $item['district_uuid'] .
                    $item['project_area_uuid'] .
                    $item['age'] .
                    $item['qualification'] .
                    $item['zone'] .
                    $item['location'];
                })->values()->all())
            ]);
    }

    public function importCollection($dataCollection, $bairro, $toSave = false)
    {
        $collection = Excel::toCollection(new BiospImport, storage_path('BD.xlsx'));
        $data = $dataCollection;
        $collection[0][0][0] .= '' . $bairro;

        /**
         * @author @inkomomutane
         * Generating report
         */

        for ($i = 0; $i < $data->count(); $i++) {
            $collection[0][3 + $i] = collect($data[$i])->values();
        }
        if ($toSave) {
            $path = 'rl/' . "Base de dados" . date_format(now(), "d-M-Y") . '.xlsx';
            try {
                Excel::store(new BiospExport($collection), $path);
                return $path;
            } catch (\Throwable $th) {
                return null;
            }

            return $path;
        } else
            return Excel::download(new BiospExport($collection),    "Base de dados" . date_format(now(), "d-M-Y-H-m-s") . '.xlsx');
    }


    public function all(Request $request)
    {
        if (
            $request->hasValidSignature()
        ) {
            return  $this->importCollection(BenificiaryResource::collection(Benificiary::all()->unique(function ($item) {
                return $item['full_name'] .
                $item['district_uuid'] .
                $item['project_area_uuid'] .
                $item['age'] .
                $item['qualification'] .
                $item['zone'] .
                $item['location'];
            })->values()->all()), "Base de dados");

        } elseif (auth()->check()) {
            if (
                auth()->user()->hasRole('admin')
            ) {
                return  $this->importCollection(BenificiaryResource::collection(Benificiary::all()->unique(function ($item) {
                    return $item['full_name'] .
                    $item['district_uuid'] .
                    $item['project_area_uuid'] .
                    $item['age'] .
                    $item['qualification'] .
                    $item['zone'] .
                    $item['location'];
                })->values()->all()), '');
            }
        } else {
            return abort(403);
        }
    }

}
