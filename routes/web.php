<?php


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashbordController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ProvincesController;
use App\Http\Controllers\DocumentsTypeController;
use App\Http\Controllers\GenresController;
use App\Http\Controllers\NeighborhoodsController;
use App\Http\Controllers\ProvenacesContoller;
use App\Http\Controllers\BenificiariesController;
use App\Http\Controllers\ForwardedServicesController;
use App\Http\Controllers\PurposeOfVisitsController;
use App\Http\Controllers\ReasonOpeningCasesController;
use App\Http\Controllers\SendMailController;
use Illuminate\Support\Facades\File;
use App\Models\Benificiary;
use App\Models\SendMail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Auth::routes([
    "register" => false,
    "confirm" =>false,
    "reset" => false
]);


//
Route::get('/', function () {
 /*   try{
//dd(File::link(storage_path('app/public'), __DIR__ . "/../../public_html/biosp/storage"));

    }
catch(\Throwable $e){
    throw $e;
}*/
    return  redirect('/dashboard');
});

Route::any('/relatorio/{bairro}',[DashbordController::class,'thisMonth'])->name('relatorio');

Route::middleware(['auth'])->group(function () {

    Route::get('/filtered_data/{startDate}/{endDate}',[DashbordController::class,'filterDateJson']);
    Route::post('/filtered_data',[DashbordController::class,'filtroJson']);
    Route::get('/relatorio_geral',[DashbordController::class,'all'])->name('relatorio.geral');

    Route::get('/relatorio_geral/{bairro}',[DashbordController::class,'allByNeighborhood'])->name('relatorio.bairro');

    Route::get('/relatorio_actual/{bairro}',[DashbordController::class,'thisMonth'])->name('relatorio.mes.actual');

    Route::post('/relatorio/filtro',[DashbordController::class,'filtro'])->name('relatorio.filtro');

    Route::get('/dashboard',[DashbordController::class,'index'])->name('dashboard.index');
});

Route::group(['middleware'=> ['auth', 'role:admin']],function(){
     Route::resource('province', ProvincesController::class);
     Route::resource('document_type', DocumentsTypeController::class);
     Route::resource('bairro', NeighborhoodsController::class);
     Route::resource('genre', GenresController::class);
     Route::resource('provenace', ProvenacesContoller::class);
     Route::resource('forwarded_service', ForwardedServicesController::class);
     Route::resource('purpose_of_visit', PurposeOfVisitsController::class);
     Route::resource('reason_opening_case', ReasonOpeningCasesController::class);
     Route::resource('user', UsersController::class);
     Route::resource('sendMail', SendMailController::class);
});


