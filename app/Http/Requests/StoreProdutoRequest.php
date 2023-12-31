<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProdutoRequest extends FormRequest
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
            'descricao' => 'min:2|required|unique:produtos,descricao',
            'esta_ativo' => 'required|boolean',
            'tipo_produto_id' => 'required|exists:tipo_produtos,id',
            'destino_id' => 'required|exists:destinos,id',
        ];
    }
}
