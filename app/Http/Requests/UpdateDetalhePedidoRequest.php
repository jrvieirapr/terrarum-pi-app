<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDetalhePedidoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

            'descricao' => 'min:2|max:50|unique:detalhes_pedido,descricao|required',
            'data'=> 'required|date',
            'quantidade' => 'min:2|max:50|detalhes_pedido|required',$this->route('DetalhePedido') . ',id|required',
            'valor_unitario' => 'min:2|max:50|unique:detalhes_pedido,valor_unitario|required', $this->route('DetalhePedido') . ',id|required',
            'total' => 'numeric|required',
            'produtos_id' => 'required|exists:produtos,id',
            'eventos_id' => 'required|exists:eventos,id',

        ];
    }
}
