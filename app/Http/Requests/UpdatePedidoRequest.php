<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePedidoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'data' => 'required|date',
            'numero' => 'required|integer|unique:pedidos,numero,' . $this->route('pedido'),
            'esta_ativo' => 'required|boolean',
            'usuario_id' => 'required|exists:usuarios,id',
            'detalhes_pedido.*.evento_id' => 'required|exists:eventos,id',
            'detalhes_pedido.*.produto_id' => 'required|exists:produtos,id',
            'detalhes_pedido.*.descricao' => 'required|string',
            'detalhes_pedido.*.quantidade' => 'required|integer|min:1',
            'detalhes_pedido.*.valor_unitario' => 'required|numeric',
            'detalhes_pedido.*.valor_total' => 'required|numeric',
        ];
    }
}