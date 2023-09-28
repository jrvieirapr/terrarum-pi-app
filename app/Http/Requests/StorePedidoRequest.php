<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePedidoRequest extends FormRequest
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
            'data' => 'date|required',
            'produto' => 'min:2|required',
            'quant' => 'min:2|required', 
            'preco' => 'min:2|required',
            'total' => 'min:2|required',
            'obs' => 'min:2|required',
            'usuario_id' => 'required|exists:usuarios,id',
            'detalhes_pedido_id' => 'required|exists:detalhes_pedidos,id',
        ];
    }
}
