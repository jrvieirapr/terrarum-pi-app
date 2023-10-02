<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Http\Requests\StorePedidoRequest;
use App\Http\Requests\UpdatePedidoRequest;
use App\Models\DetalhePedido;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pedidos = Pedido::with('detalhesPedido')->get();

        return response()->json(['data' => $pedidos]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePedidoRequest $request)
    {
        $pedidoData = $request->only(['data', 'numero', 'esta_ativo', 'usuario_id']);
        $detalhesPedidoData = $request->input('detalhes_pedido');

        $pedido = Pedido::create($pedidoData);

        foreach ($detalhesPedidoData as $detalheData) {
            DetalhePedido::create([
                'pedido_id' => $pedido->id,
                'evento_id' => $detalheData['evento_id'],
                'produto_id' => $detalheData['produto_id'],
                'descricao' => $detalheData['descricao'],
                'quantidade' => $detalheData['quantidade'],
                'valor_unitario' => $detalheData['valor_unitario'],
                'valor_total' => $detalheData['valor_total'],
            ]);
        }

        // Retorna o pedido com os detalhes do pedido
        $pedido->load('detalhesPedido'); // Certifique-se de que a relação esteja definida no modelo Pedido
        return response()->json($pedido, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pedido = Pedido::with('detalhesPedido')->find($id);

        if (!$pedido) {
            return response()->json(['message' => 'Pedido não encontrado'], 404);
        }

        return response()->json($pedido, 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePedidoRequest $request, $id)
    {
        // Verifique se o pedido existe antes de continuar
        $pedido = Pedido::find($id);

        if (!$pedido) {
            return response()->json(['message' => 'Pedido não encontrado'], 404);
        }

        // Atualize os campos do pedido
        $pedido->update($request->only(['data', 'numero', 'esta_ativo', 'usuario_id']));

        // Atualize ou crie detalhes do pedido com base nos dados enviados
        foreach ($request->input('detalhes_pedido') as $detalheData) {
            // Verifique se a chave 'id' está presente no array $detalheData antes de usá-la
            $detalheId = isset($detalheData['id']) ? $detalheData['id'] : null;

            $pedido->detalhesPedido()->updateOrCreate(
                ['id' => $detalheId], // Use o ID se estiver presente
                [
                    'evento_id' => $detalheData['evento_id'],
                    'produto_id' => $detalheData['produto_id'],
                    'descricao' => $detalheData['descricao'],
                    'quantidade' => $detalheData['quantidade'],
                    'valor_unitario' => $detalheData['valor_unitario'],
                    'valor_total' => $detalheData['valor_total'],
                ]
            );
        }

        return response()->json($pedido);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pedido = Pedido::find($id);

        if (!$pedido) {
            return response()->json(['message' => 'Pedido não encontrado!'], 404);
        }

        // Tente excluir os detalhes do pedido
        $deletedDetalhes = DetalhePedido::where('pedido_id', $pedido->id)->delete();

        // Verifique se os detalhes do pedido foram excluídos com sucesso
        if ($deletedDetalhes === false) {
            return response()->json(['message' => 'Falha ao excluir detalhes do pedido.'], 500);
        }

        // Tente excluir o pedido
        if ($pedido->delete()) {
            return response()->json(['message' => 'Pedido deletado com sucesso!'], 200);
        } else {
            return response()->json(['message' => 'Falha ao excluir o pedido.'], 500);
        }
    }

    
}