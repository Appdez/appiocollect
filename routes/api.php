<?php

use App\Http\Controllers\Api\BenificiaryController;
use App\Http\Controllers\Api\Syncronization\Sync;
use App\Http\Controllers\Api\UserController;
use App\Http\Resources\BenificiaryResource;
use App\Models\Benificiary;
use App\Models\Syncronization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashbordController;
use App\Models\Neighborhood;
use Illuminate\Support\Facades\URL;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/






Route::get('/connected', function () {
    return true;
});

Route::post('/login',[UserController::class,'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout',[UserController::class,'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::any('sync/report/{bairro}',function (Neighborhood $bairro)
    {
       return  URL::temporarySignedRoute('relatorio', now()->addDays(1), $bairro->uuid);
    });

    Route::get('ben', function () {
      // return  Benificiary::all()->map(function($element){
     //      return $element->;
     //  });
        return BenificiaryResource::collection(Benificiary::all());
    });
    Route::get('/sync/settings',[Sync::class,'settings']);
    Route::post('/sync/create',[Sync::class,'addCreated']);
    Route::post('/sync/update',[Sync::class,'updateUpdated']);
    Route::post('/sync/delete',[Sync::class,'deleteDeleted']);
});

