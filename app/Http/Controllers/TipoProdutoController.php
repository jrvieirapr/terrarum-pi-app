<?php

namespace App\Http\Controllers;

use App\Models\TipoProduto;
use App\Http\Requests\StoreTipoProdutoRequest;
use App\Http\Requests\UpdateTipoProdutoRequest;

class TipoProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tipos_produtos = TipoProduto::all();

        //Retornar lista em formato json
        return response()->json(['data' => $tipos_produtos]);
        //
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTipoProdutoRequest $request)
    {
        $tipos_produtos = TipoProduto::create($request->all());

        // // Retorne o tipo e o code 201
        return response()->json($tipos_produtos, 201);
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $tipos_produtos = TipoProduto::find($id);

        if (!$tipos_produtos) {
            return response()->json(['message' => 'Tipo não encontrado'], 404);
        }

        return response()->json($tipos_produtos);
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTipoProdutoRequest $request, $id)
    {
        $tipos_produtos = TipoProduto::find($id);

        if (!$tipos_produtos) {
            return response()->json(['message' => 'Tipo não encontrado'], 404);
        }

        // Faça o update do tipo
        $tipos_produtos->update($request->all());

        // Retorne o tipo
        return response()->json($tipos_produtos);
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $tipos_produtos = TipoProduto::find($id);

          if (!$tipos_produtos) {
              return response()->json(['message' => 'Tipo não encontrado'], 404);
          }
          //sempre verificar se existe e se há classes dependentes, se sim, retornar erro.

          // Delete the brand
          $tipos_produtos->delete();

          return response()->json(['message' => 'Tipo deletado com sucesso'], 200);
        //
    }
}