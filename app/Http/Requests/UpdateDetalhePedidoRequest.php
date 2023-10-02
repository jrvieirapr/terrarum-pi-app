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
            //
            'pedido_id' => 'required|exists:pedidos,id',
            'evento_id' => 'required|exists:eventos,id',
            'produto_id' => 'required|exists:produtos,id',
            'descricao' => 'min:2|required',
            'quantidade' => 'required|number',
            'valor_unitario' => 'required|number',
            'valor_total' => 'required|number',
        ];
    }
}
