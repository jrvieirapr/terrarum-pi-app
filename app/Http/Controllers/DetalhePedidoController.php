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
        $detalhepedido = DetalhePedido::all();
        //pegar a lista do banco

        $DetalhePedidos = DetalhePedido::all();

 

        //retornar lista em formato json

        return response()->json(['data' => $DetalhePedidos]);
    }
 
     /**
      * Store a newly created resource in storage.
      */
     public function store(StoreDetalhePedidoRequest $request)
     {
        // crie um novo evento

        $DetalhePedido = DetalhePedido::create($request->all());

        //retorne o evento e o 201

        return response()->json($DetalhePedido, 201);
      
       
       
         //
     }
 
     /**
      * Display the specified resource.
      */
     public function show($id)
     {
         //procure evento por id

        $DetalhePedido = DetalhePedido::find($id);

        if (!$DetalhePedido) {

            return response()->json(['message' => 'Evento não encontrado'], 404);

        }

        return response()->json($DetalhePedido);
     
     }
     
 
     /**
      * Update the specified resource in storage.
      */
     public function update(UpdateDetalhePedidoRequest $request, $id)
     {
         $data = $request->all();
         // Procure o tipo pela id

        $detalhepedido= DetalhePedido::find($id);

        if (!$detalhepedido) {

            return response()->json(['message' => 'Detalhepedido não encontrado'], 404);

        }

        //faça o update do evento
         $detalhepedido->update($data);
         return redirect()->route('detalhespedidos.index');
     }
 
 
     /**
      * Remove the specified resource from storage.
      */
     public function destroy($id)
     {
        //encontre um  evento pelo ID

        $DetalhePedido = DetalhePedido::find($id);

        if (!$DetalhePedido) {

            return response()->json(['message' => 'DetalhePedido não encontrado!'], 404);

        }

        //se tiver filho retornar erro

        // delete o brand

        $DetalhePedido->delete();

        return response()->json(['message' => 'DetalhePedido deletado com sucesso!'], 200);
    }
}
    
 
 
 
     
 
 
    

    