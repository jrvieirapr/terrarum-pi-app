<?php

use App\Http\Controllers\DestinoController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\TipoProdutoController;
use App\Http\Controllers\UsuarioController;
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
Route::middleware('api')->prefix('tipo_produtos')->group(function () {
    Route::get('/', [TipoProdutoController::class, 'index']);
    Route::post('/', [TipoProdutoController::class, 'store']);
    Route::get('/{tipo_produto}', [TipoProdutoController::class, 'show']);
    Route::put('/{tipo_produto}', [TipoProdutoController::class, 'update']);
    Route::delete('/{tipo_produto}', [TipoProdutoController::class, 'destroy']);
});


//rotas do evento
Route::middleware('api')->prefix('eventos')->group(function () {
    Route::get('/', [EventoController::class, 'index']);
    Route::post('/', [EventoController::class, 'store']);
    Route::get('/{evento}', [EventoController::class, 'show']);
    Route::put('/{evento}', [EventoController::class, 'update']);
    Route::delete('/{evento}', [EventoController::class, 'destroy']);
});

//rotas do pedido
Route::middleware('api')->prefix('pedidos')->group(function () {
    Route::get('/', [PedidoController::class, 'index']);
    Route::post('/', [PedidoController::class, 'store']);
    Route::get('/{pedido}', [PedidoController::class, 'show']);
    Route::put('/{pedido}', [PedidoController::class, 'update']);
    Route::delete('/{pedido}', [PedidoController::class, 'destroy']);
});
//rotas do pedido
Route::middleware('api')->prefix('produtos')->group(function () {
    Route::get('/', [ProdutoController::class, 'index']);
    Route::post('/', [ProdutoController::class, 'store']);
    Route::get('/{pedido}', [ProdutoController::class, 'show']);
    Route::put('/{pedido}', [ProdutoController::class, 'update']);
    Route::delete('/{pedido}', [ProdutoController::class, 'destroy']);
});
//rotas do pedido
Route::middleware('api')->prefix('usuarios')->group(function () {
    Route::get('/', [UsuarioController::class, 'index']);
    Route::post('/', [UsuarioController::class, 'store']);
    Route::get('/{pedido}', [UsuarioController::class, 'show']);
    Route::put('/{pedido}', [UsuarioController::class, 'update']);
    Route::delete('/{pedido}', [UsuarioController::class, 'destroy']);
});
