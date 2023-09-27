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
            'nome' =>'min:2|max:50|required',
            'tipo' =>'min:2|max:50|unique:produtos,tipo|required',
            'destino_id' =>'min:2|max:50|required',
            'tipo_de_produtos' =>'min:2|max:50|unique:produtos,tipo_de_produto|required',
            'esta_ativo' =>'min:2|max:10|unique:produtos,esta_ativo|required',
        ];
    }
}
