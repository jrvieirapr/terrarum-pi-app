<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProdutoRequest extends FormRequest
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
            'id' =>'min:2|required',
            'tipo' =>'min:2|max:50|unique:produtos,tipo|required',
            'destino_id' =>'min:2|max:50|required',
            'tipos_de_produtos_id' =>'min:2|unique:produtos,tipo_de_produto|required',
            'esta_ativo' =>'min:2|max:10|unique:produtos,esta_ativo|required',
        ];
    }
}
