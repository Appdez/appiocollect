<?php

namespace App\Http\Controllers;

use App\Http\Resources\BenificiaryResource;
use App\Models\Benificiary;
use App\Models\ForwardedService;
use App\Models\Genre;
use App\Models\Neighborhood;
use App\Models\Provenace;
use App\Models\PurposeOfVisit;
use App\Models\ReasonOpeningCase;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Imports\Biosp as BiospImport;
use App\Exports\Biosp as BiospExport;
use App\Traits\SumProduct;
use Maatwebsite\Excel\Facades\Excel;

class DashbordController extends Controller
{
    use SumProduct;

    private $startDate;
    private $endDate;
    private $visits;
    private $queries;
    private $auxQueries;
    private $visitsPlus5;


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (auth()->user()->hasRole('admin')) {
            return view('backend.dashboard')->with([
                'bairros' => Neighborhood::whereNotIn('uuid', ['3e6816de-ade8-3902-bdb5-11393d32badd'])->get(),
                'generos' => Genre::all(),
                'proviniencias' => Provenace::all(),
                'razoes_das_visitas' => PurposeOfVisit::all(),
                'motivos_de_abertura_de_processos' => ReasonOpeningCase::all(),
                'servicos_encaminhados' => ForwardedService::all(),
            ]);
        } else
            return view('backend.dashboard')->with([
                'bairros' => Neighborhood::where('uuid', auth()->user()->neighborhood_uuid)->get(),
                'generos' => Genre::all(),
                'proviniencias' => Provenace::all(),
                'razoes_das_visitas' => PurposeOfVisit::all(),
                'motivos_de_abertura_de_processos' => ReasonOpeningCase::all(),
                'servicos_encaminhados' => ForwardedService::all(),
            ]);
    }

    public function filterDateJson($startDate = null, $endDate = null)
    {
        if (auth()->user()->hasRole('admin')) {
            $this->startDate = $startDate != null ? $startDate : today();
            $this->endDate = $endDate != null ? $endDate : today();
            $data = Neighborhood::whereNotIn('uuid', ['3e6816de-ade8-3902-bdb5-11393d32badd'])
                ->pluck('uuid', 'name')->map(function ($uuid) {
                    return Benificiary::where('neighborhood_uuid', $uuid)
                        ->whereDate('service_date', '>=', Carbon::parse($this->startDate))
                        ->whereDate('service_date', '<=', Carbon::parse($this->endDate))
                        ->count();
                });
            return [
                'keys'  => collect($data)->keys(),
                "values" => collect($data)->values(),
                'data' => collect($data)
            ];
        } else
            $this->startDate = $startDate != null ? $startDate : today();
        $this->endDate = $endDate != null ? $endDate : today();
        $data = Neighborhood::where('uuid', auth()->user()->neighborhood_uuid)
            ->pluck('uuid', 'name')->map(function ($uuid) {
                return Benificiary::where('neighborhood_uuid', $uuid)
                    ->whereDate('service_date', '>=', Carbon::parse($this->startDate))
                    ->whereDate('service_date', '<=', Carbon::parse($this->endDate))
                    ->count();
            });
        $data[] = 0;
        $data = collect($data);
        $data =  $data->reverse();
        return [
            'keys'  => collect($data)->keys(),
            "values" => collect($data)->values(),
            'data' => collect($data)
        ];
    }
    public function filtroJson(Request $request)
    {
        $request->validate([
            'minAge' => 'nullable|integer|min:0',
            'maxAge' => 'nullable|integer|max:500'
        ]);
        $this->queries =  $request;
        $this->visits = Benificiary::all()->unique('number_of_visits')->pluck('number_of_visits');
        $this->visitsPlus5 = Benificiary::where('number_of_visits', '>=', 5)->get()->unique('number_of_visits')->pluck('number_of_visits');
        $this->auxQueries = $request->number_of_visits;
        if ($this->auxQueries != null && array_search(5, $this->auxQueries) !== false) {
            foreach ($this->visitsPlus5 as $value) {
                array_push($this->auxQueries, $value);
            }
        }

        if (auth()->user()->hasRole('admin')) {
            $data = Neighborhood::whereIn('uuid', $this->queries->neighborhood_uuid != NULL ? $this->queries->neighborhood_uuid :  Neighborhood::all()->pluck('uuid'))
                ->pluck('uuid', 'name')->map(function ($uuid) {
                    return  Benificiary::where('neighborhood_uuid', $uuid)
                        ->WhereIn('genre_uuid', $this->queries->genre_uuid != NULL ? $this->queries->genre_uuid : Genre::all()->pluck('uuid'))
                        ->WhereIn('provenace_uuid', $this->queries->provenace_uuid != NULL ? $this->queries->provenace_uuid :  Provenace::all()->pluck('uuid'))
                        ->WhereIn('purpose_of_visit_uuid', $this->queries->purpose_of_visit_uuid != NULL ? $this->queries->purpose_of_visit_uuid :  PurposeOfVisit::all()->pluck('uuid'))
                        ->WhereIn('reason_opening_case_uuid', $this->queries->reason_opening_case_uuid != NULL ? $this->queries->reason_opening_case_uuid :  ReasonOpeningCase::all()->pluck('uuid'))
                        ->WhereIn('forwarded_service_uuid', $this->queries->forwarded_service_uuid != NULL ? $this->queries->forwarded_service_uuid :  ForwardedService::all()->pluck('uuid'))
                        ->WhereIn('number_of_visits', $this->queries->number_of_visits != NULL
                            ? $this->auxQueries
                            : $this->visits)
                        ->whereDate('service_date', '>=', \Carbon\Carbon::parse($this->queries->start_date))
                        ->whereDate('service_date', '<=', \Carbon\Carbon::parse($this->queries->end_date))
                        ->WhereYear('birth_date', '>=', $this->queries->maxAge != null ? (now()->year -  $this->queries->maxAge)  : 0)
                        ->WhereYear('birth_date', '<=', $this->queries->minAge != null ? (now()->year -  $this->queries->minAge)  :  now()->year)
                        ->count();
                });
        } else
            $data = Neighborhood::whereIn('uuid', $this->queries->neighborhood_uuid != NULL ? $this->queries->neighborhood_uuid :  Neighborhood::where('uuid', auth()->user()->neighborhood_uuid)->pluck('uuid'))
                ->pluck('uuid', 'name')->map(function ($uuid) {
                    return  Benificiary::where('neighborhood_uuid', $uuid)
                        ->WhereIn('genre_uuid', $this->queries->genre_uuid != NULL ? $this->queries->genre_uuid : Genre::all()->pluck('uuid'))
                        ->WhereIn('provenace_uuid', $this->queries->provenace_uuid != NULL ? $this->queries->provenace_uuid :  Provenace::all()->pluck('uuid'))
                        ->WhereIn('purpose_of_visit_uuid', $this->queries->purpose_of_visit_uuid != NULL ? $this->queries->purpose_of_visit_uuid :  PurposeOfVisit::all()->pluck('uuid'))
                        ->WhereIn('reason_opening_case_uuid', $this->queries->reason_opening_case_uuid != NULL ? $this->queries->reason_opening_case_uuid :  ReasonOpeningCase::all()->pluck('uuid'))
                        ->WhereIn('forwarded_service_uuid', $this->queries->forwarded_service_uuid != NULL ? $this->queries->forwarded_service_uuid :  ForwardedService::all()->pluck('uuid'))
                        ->WhereIn('number_of_visits', $this->queries->number_of_visits != NULL
                            ? $this->auxQueries
                            : $this->visits)
                        ->whereDate('service_date', '>=', \Carbon\Carbon::parse($this->queries->start_date))
                        ->whereDate('service_date', '<=', \Carbon\Carbon::parse($this->queries->end_date))
                        ->WhereYear('birth_date', '>=', $this->queries->maxAge != null ? (now()->year -  $this->queries->maxAge)  : 0)
                        ->WhereYear('birth_date', '<=', $this->queries->minAge != null ? (now()->year -  $this->queries->minAge)  :  now()->year)
                        ->count();
                });

        $data[] = 0;
        $data = collect($data);
        $data =  $data->reverse();
        return [
            'keys'  => $data->keys(),
            "values" => $data->values(),
            'data' => $data
        ];
    }

    public function importCollection($dataCollection, $bairro, $toSave = false)
    {
        $collection = Excel::toCollection(new BiospImport, storage_path('SA.xlsx'));
        $data = $dataCollection;
        $collection[0][0][0] .= '-' . $bairro;

        /**
         * @author @inkomomutane
         * Generating report
         */

        for ($i = 0; $i < $data->count(); $i++) {
            $collection[0][3 + $i] = collect($data[$i])->values();
        }

        $collection[1]= $this->relatorio($dataCollection,$bairro);

        if ($toSave) {
            $path = 'rl/' . "Relatório do bairro de " . $bairro . " " . date_format(now(), "d-M-Y") . '.xlsx';
            try {
                Excel::store(new BiospExport($collection), $path);
                return $path;
            } catch (\Throwable $th) {
                return null;
            }

            return $path;
        } else
            return Excel::download(new BiospExport($collection), "Relatório do bairro de " . $bairro . " " . date_format(now(), "d-M-Y") . '.xlsx');
    }

    public function lastMonth(Request $request, Neighborhood $bairro)
    {
        if (
            $request->hasValidSignature()
        ) {
            return  $this->importCollection(BenificiaryResource::collection(Benificiary::where('neighborhood_uuid', $bairro->uuid)->whereMonth('service_date', (now()->month - 1))->get()), $bairro->name);
        } elseif (auth()->check()) {
            if (
                auth()->user()->hasRole('admin') ||
                auth()->user()->neighborhood_uuid == $bairro->uuid
            ) {
                return  $this->importCollection(BenificiaryResource::collection(Benificiary::where('neighborhood_uuid', $bairro->uuid)->whereMonth('service_date', (now()->month - 1))->get()), $bairro->name);
            }
            abort(404);
        } else {
            return abort(404);
        }
    }

    public function thisMonth(Request $request, Neighborhood $bairro)
    {
        if (
            $request->hasValidSignature()
        ) {
            return  $this->importCollection(BenificiaryResource::collection(Benificiary::where('neighborhood_uuid', $bairro->uuid)->whereMonth('service_date', (now()->month))->get()), $bairro->name);
        } elseif (auth()->check()) {
            if (
                auth()->user()->hasRole('admin') ||
                auth()->user()->neighborhood_uuid == $bairro->uuid
            ) {
                return  $this->importCollection(BenificiaryResource::collection(Benificiary::where('neighborhood_uuid', $bairro->uuid)->whereMonth('service_date', (now()->month))->get()), $bairro->name);
            }
        } else {
            return abort(403);
        }
    }

    public function thisMonthForMail(Neighborhood $bairro)
    {
        return $this->importCollection(BenificiaryResource::collection(Benificiary::where('neighborhood_uuid', $bairro->uuid)->whereMonth('service_date', (now()->month))->get()), $bairro->name, true);
    }


    public function allByNeighborhood(Request $request, Neighborhood $bairro)
    {
        if (
            $request->hasValidSignature()
        ) {
            return  $this->importCollection(BenificiaryResource::collection(Benificiary::where('neighborhood_uuid', $bairro->uuid)->whereMonth('service_date', (now()->month - 1))->get()), $bairro->name);
        } elseif (auth()->check()) {
            if (
                auth()->user()->hasRole('admin') ||
                auth()->user()->neighborhood_uuid == $bairro->uuid
            ) {
                return  $this->importCollection(BenificiaryResource::collection(Benificiary::where('neighborhood_uuid', $bairro->uuid)->get()), $bairro->name);
            }
        } else {
            return abort(403);
        }
    }

    public function all(Request $request)
    {
        if (
            $request->hasValidSignature()
        ) {
            return  $this->importCollection(BenificiaryResource::collection(Benificiary::where('neighborhood_uuid', $bairro->uuid)->whereMonth('service_date', (now()->month - 1))->get()), $bairro->name);
        } elseif (auth()->check()) {
            if (
                auth()->user()->hasRole('admin')
            ) {
                return  $this->importCollection(BenificiaryResource::collection(Benificiary::all()), 'Todos');
            }
        } else {
            return abort(403);
        }
    }


    public function filtro(Request $request)
    {


        $request->validate([
            'minAge' => 'nullable|integer|min:0',
            'maxAge' => 'nullable|integer|max:500'
        ]);
        $queries =  $request;
        $visits = Benificiary::all()->unique('number_of_visits')->pluck('number_of_visits');
        $visitsPlus5 = Benificiary::where('number_of_visits', '>=', 5)->get()->unique('number_of_visits')->pluck('number_of_visits');
        $auxQueries = $request->number_of_visits;
        if ($auxQueries != null && array_search(5, $auxQueries) !== false) {
            foreach ($visitsPlus5 as $value) {
                array_push($auxQueries, $value);
            }
        }
        if (auth()->user()->hasRole('admin')) {
            return $this->importCollection(BenificiaryResource::collection(
                Benificiary::whereIn('neighborhood_uuid', $queries->neighborhood_uuid != NULL ? $queries->neighborhood_uuid :  Neighborhood::all()->pluck('uuid'))
                    ->WhereIn('genre_uuid', $queries->genre_uuid != NULL ? $queries->genre_uuid : Genre::all()->pluck('uuid'))
                    ->WhereIn('provenace_uuid', $queries->provenace_uuid != NULL ? $queries->provenace_uuid :  Provenace::all()->pluck('uuid'))
                    ->WhereIn('purpose_of_visit_uuid', $queries->purpose_of_visit_uuid != NULL ? $queries->purpose_of_visit_uuid :  PurposeOfVisit::all()->pluck('uuid'))
                    ->WhereIn('reason_opening_case_uuid', $queries->reason_opening_case_uuid != NULL ? $queries->reason_opening_case_uuid :  ReasonOpeningCase::all()->pluck('uuid'))
                    ->WhereIn('forwarded_service_uuid', $queries->forwarded_service_uuid != NULL ? $queries->forwarded_service_uuid :  ForwardedService::all()->pluck('uuid'))
                    ->WhereIn('number_of_visits', $queries->number_of_visits != NULL
                        ? $auxQueries
                        : $visits)
                    ->whereDate('service_date', '>=', \Carbon\Carbon::parse($queries->start_date))
                    ->whereDate('service_date', '<=', \Carbon\Carbon::parse($queries->end_date))
                    ->WhereYear('birth_date', '>=', $queries->maxAge != null ? (now()->year -  $queries->maxAge)  : 0)
                    ->WhereYear('birth_date', '<=', $queries->minAge != null ? (now()->year -  $queries->minAge)  :  now()->year)
                    ->get()
            ), '[Filtrado]');
        } else {
            return $this->importCollection(BenificiaryResource::collection(
                Benificiary::whereIn('neighborhood_uuid', $queries->neighborhood_uuid != NULL ? $queries->neighborhood_uuid :  Neighborhood::where('uuid', auth()->user()->neighborhood_uuid)->pluck('uuid'))
                    ->WhereIn('genre_uuid', $queries->genre_uuid != NULL ? $queries->genre_uuid : Genre::all()->pluck('uuid'))
                    ->WhereIn('provenace_uuid', $queries->provenace_uuid != NULL ? $queries->provenace_uuid :  Provenace::all()->pluck('uuid'))
                    ->WhereIn('purpose_of_visit_uuid', $queries->purpose_of_visit_uuid != NULL ? $queries->purpose_of_visit_uuid :  PurposeOfVisit::all()->pluck('uuid'))
                    ->WhereIn('reason_opening_case_uuid', $queries->reason_opening_case_uuid != NULL ? $queries->reason_opening_case_uuid :  ReasonOpeningCase::all()->pluck('uuid'))
                    ->WhereIn('forwarded_service_uuid', $queries->forwarded_service_uuid != NULL ? $queries->forwarded_service_uuid :  ForwardedService::all()->pluck('uuid'))
                    ->WhereIn('number_of_visits', $queries->number_of_visits != NULL
                        ? $auxQueries
                        : $visits)
                    ->whereDate('service_date', '>=', \Carbon\Carbon::parse($queries->start_date))
                    ->whereDate('service_date', '<=', \Carbon\Carbon::parse($queries->end_date))
                    ->WhereYear('birth_date', '>=', $queries->maxAge != null ? (now()->year -  $queries->maxAge)  : 0)
                    ->WhereYear('birth_date', '<=', $queries->minAge != null ? (now()->year -  $queries->minAge)  :  now()->year)
                    ->get()
            ), '[Filtrado]');
        }
    }
}
