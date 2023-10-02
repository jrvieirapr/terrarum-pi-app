<?php

namespace App\Http\Controllers;

use App\Models\DetalhePedido;
use App\Http\Requests\StoreDetalhePedidoRequest;
use App\Http\Requests\UpdateDetalhePedidoRequest;

class DetalhePedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $detalhePedidos = DetalhePedido::all();

        return response()->json(['data' => $detalhePedidos]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDetalhePedidoRequest $request)
    {
        $detalhePedido = DetalhePedido::create($request->all());

        // // Retorne o tipo e o code 201
        return response()->json($detalhePedido, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $detalhePedido = DetalhePedido::find($id);

        if (!$detalhePedido) {
            return response()->json(['message' => 'Detalhe Pedido não encontrado'], 404);
        }

        return response()->json($detalhePedido);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDetalhePedidoRequest $request, $id)
    {
        $detalhePedido = DetalhePedido::find($id);

        if (!$detalhePedido) {
            return response()->json(['message' => 'Detalhe Pedido não encontrado'], 404);
        }

        // Faça o update do tipo
        $detalhePedido->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $detalhePedido = DetalhePedido::find($id);

        if (!$detalhePedido) {
            return response()->json(['message' => 'Detalhe Pedido não encontrado!'], 404);
        }

        //sempre verificar se existe e se há classes dependentes, se sim, retornar erro.

        // // Delete the brand
        //

        $detalhePedido->delete();

        return response()->json(['message' => 'Detalhe Pedido deletado com sucesso!'], 200);
    }
}