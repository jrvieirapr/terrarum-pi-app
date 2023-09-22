<?php

use App\Http\Controllers\EventoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//rotas do evento
Route::middleware('api')->prefix('eventos')->group(function(){
    Route::get('/',[EventoController::class,'index']);
    Route::post('/', [EventoController::class,'store']);
    Route::get('/{evento}',[EventoController::class, 'show']);
    Route::put('/{evento}',[EventoController::class, 'update']);
    Route::delete('/{evento}',[EventoController::class, 'destroy']);
});