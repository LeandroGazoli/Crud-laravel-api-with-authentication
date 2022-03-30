<?php

use App\Http\Controllers\api\RegisterAndLoginController;
use App\Http\Controllers\Despesa;
use App\Http\Controllers\DespesasController;
use App\Models\Despesas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::controller(RegisterAndLoginController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::middleware('auth:sanctum')->group( function () {
    // use App\Http\Controllers\PhotoController;
    Route::resource('despesa', Despesa::class);
    // Route::apiResource('/despesas', DespesasController::class);
    // Route::apiResource('despesa', DespesasController::class);
    // Route::post('despesas', DespesasController::class,)
});
