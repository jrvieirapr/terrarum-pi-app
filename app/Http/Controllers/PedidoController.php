<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Http\Requests\StorePedidoRequest;
use App\Http\Requests\UpdatePedidoRequest;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         //pegar a lista do banco
         $pedidos = Pedido::all();

         //retornar lista em formato json
         return response()->json(['data' => $pedidos]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePedidoRequest $request)
    {
         // crie um novo pedido
         $pedido = Pedido::create($request->all());
         //retorne o evento e o 201
         return response()->json($pedido, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
         //procure pedido por id
         $pedido = Pedido::find($id);
         if (!$pedido) {
             return response()->json(['message' => 'Pedido não encontrado'], 404);
         }
         return response()->json($pedido);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pedido $pedido)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePedidoRequest $request, $id)
    {
         // Procure o pedido pela id
         $pedido = Pedido::find($id);
         if (!$pedido) {
             return response()->json(['message' => 'Pedido não encontrado'], 404);
         }
         //faça o update do evento
         $pedido->update($request->all());
         //retorne o evento
         return response()->json($pedido);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
         //encontre um  pedido pelo ID
         $pedido = Pedido::find($id);
         if (!$pedido) {
             return response()->json(['message' => 'Pedido não encontrado!'], 404);
         }
         //se tiver filho retornar erro
         // delete o brand
         $pedido->delete();
         return response()->json(['message' => 'Pedido deletado com sucesso!'], 200);
    }
}
