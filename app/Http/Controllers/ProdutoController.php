<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Http\Requests\StoreProdutoRequest;
use App\Http\Requests\UpdateProdutoRequest;

class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //pegar a lista do banco
        $produtos = Produto::all();

        //retornar lista em formato json
        return response()->json(['data' => $produtos]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProdutoRequest $request)
    {
        // crie um novo pedido
        $produto = Produto::create($request->all());
        //retorne o evento e o 201
        return response()->json($produto, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //procure Produto por id
        $produto = Produto::find($id);
        if (!$produto) {
            return response()->json(['message' => 'Produto não encontrado!'], 404);
        }
        return response()->json($produto);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProdutoRequest $request, $id)
    {
        // Procure o Produto pela id
        $produto = Produto::find($id);
        if (!$produto) {
            return response()->json(['message' => 'Produto não encontrado!'], 404);
        }
        //faça o update do evento
        $produto->update($request->all());
        //retorne o evento
        return response()->json($produto);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //encontre um  Produto pelo ID
        $produto = Produto::find($id);
        if (!$produto) {
            return response()->json(['message' => 'Produto não encontrado!'], 404);
        }
        // Verifique se existem detalhes de pedidos dependentes
        if ($produto->detalhesPedido->count() > 0) {
            return response()->json(['message' => 'Não é possível excluir o produto, pois existem detalhes de pedidos dependentes associados a ele.'], 422);
        }
        // delete o brand
        $produto->delete();
        return response()->json(['message' => 'Produto deletado com sucesso!'], 200);
    }
}
