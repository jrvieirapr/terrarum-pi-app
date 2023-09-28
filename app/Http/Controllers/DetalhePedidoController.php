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
        //$detalhepedido = DetalhePedido::all();
         $detalhes_pedido = DetalhePedido::Paginate(50);
         $total = DetalhePedido::all()->count();
         return view("detalhes_pedidos.index", compact(["detalhes_pedidos", "total"]));
     }
 
 
     /**
      * Store a newly created resource in storage.
      */
     public function store(StoreDetalhePedidoRequest $request)
     {
         //$data = $request->all();
         $Detalhes_Pedido = DetalhePedido::create($data);
         return redirect()->route('detalhespedido.index');
         //
     }
 
     /**
      * Display the specified resource.
      */
     public function show(DetalhePedido $Detalhepedido)
     {
         return view("detalhes_produto.show", compact(["detalheproduto"]));
     
     }
     
 
     /**
      * Update the specified resource in storage.
      */
     public function update(UpdateDetalhePedidoRequest $request, DetalhePedido $detalhepedido)
     {
         $data = $request->all();
         $detalhepedido->update($data);
         return redirect()->route('detalhespedidos.index');
     }
 
 
     /**
      * Remove the specified resource from storage.
      */
     public function destroy(DetalhePedido $detalhepedido)
     {
         //
         if (isset($detalhespedido)) {
             $detalhespedido->delete();
             //
         }
         return redirect()->route('detalhespedidos.index');
     }
    }
    
    
 
 
 
     
 
 
    

    