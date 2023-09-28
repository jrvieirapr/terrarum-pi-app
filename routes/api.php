<?php

use App\Http\Controllers\TipoProdutoController;
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

Route::get('/tipoproduto', [TipoProdutoController::class, 'index']);
Route::post('/tipoproduto', [TipoProdutoController::class, 'store']);
Route::get('/tipoproduto', [TipoProdutoController::class, 'show']);
Route::put('/tipoproduto', [TipoProdutoController::class, 'update']);
Route::delete('/tipoproduto', [TipoProdutoController::class, 'destroy']);

Route::middleware('api')->prefix('detalhespedidos')->group (function(){

Route::get('/', [DetalhePedidoController::class, 'index']);
Route::post('/', [DetalhePedidoController::class, 'store']);
Route::get('/detalhepedido', [DetalhePedidoController::class, 'show']);
Route::put('/detalhepedido', [DetalhePedidoController::class, 'update']);
Route::delete('/detalhepedido', [DetalhePedidoController::class, 'destroy']);

});