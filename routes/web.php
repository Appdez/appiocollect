<?php

use App\Http\Controllers\BenefitsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashbordController;
use App\Http\Controllers\DistrictsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\GenresController;
use App\Http\Controllers\NeighborhoodsController;
use App\Http\Controllers\ProjectAreasController;
use App\Http\Controllers\SendMailController;
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

Route::get('/', function () {
    return  redirect('/dashboard');
});


Route::middleware(['auth'])->group(function () {

    Route::get('/relatorio_geral',[DashbordController::class,'all'])->name('relatorio.geral');
    Route::get('/dashboard',[DashbordController::class,'index'])->name('dashboard.index');
});

Route::group(['middleware'=> ['auth', 'role:admin']],function(){
     Route::resource('district', DistrictsController::class);
     Route::resource('benefit', BenefitsController::class);
     Route::resource('project_area', ProjectAreasController::class);
     Route::resource('genre', GenresController::class);
     Route::resource('user', UsersController::class);
     Route::resource('sendMail', SendMailController::class);
});


