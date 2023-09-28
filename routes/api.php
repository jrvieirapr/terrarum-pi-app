<?php

use App\Http\Controllers\DestinoController;
use App\Http\Controllers\EventoController;
use App\Models\TipoProduto;
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


//Rotas Destinos
Route::middleware('api')->prefix('destinos')->group(function () {
    Route::get('/', [DestinoController::class, 'index']);
    Route::post('/', [DestinoController::class, 'store']);
    Route::get('/{destino}', [DestinoController::class, 'show']);
    Route::put('/{destino}', [DestinoController::class, 'update']);
    Route::delete('/{destino}', [DestinoController::class, 'destroy']);
});

//Rotas Tipo de Produtos
Route::middleware('api')->prefix('tipos_de_produtos')->group(function () {
    Route::get('/', [TipoProdutoController::class, 'index']);
    Route::post('/', [TipoProdutoController::class, 'store']);
    Route::get('/{tipo_produto}', [TipoProdutoController::class, 'show']);
    Route::put('/{tipo_produto}', [TipoProdutoController::class, 'update']);
    Route::delete('/{tipo_produto}', [TipoProdutoController::class, 'destroy']);
});




//rotas do evento
Route::middleware('api')->prefix('eventos')->group(function(){
    Route::get('/',[EventoController::class,'index']);
    Route::post('/', [EventoController::class,'store']);
    Route::get('/{evento}',[EventoController::class, 'show']);
    Route::put('/{evento}',[EventoController::class, 'update']);
    Route::delete('/{evento}',[EventoController::class, 'destroy']);
});
