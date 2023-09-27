<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventoRequest extends FormRequest
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
            'Nome' =>'min:2|max:50|required',
            'Tipo' =>'min:2|max:50|unique:eventos,tipo|required',
            'Descricao' =>'min:2|max:50|required',
            'Coordenadas' =>'min:2|max:50|unique:eventos,coordenada|required',
            'valor' =>'min:2|max:10|unique:eventos,valor|required',
            'Obs' =>'min:1|max:150|required',
            'tipoproduto_id' => 'required|integer|exists:tipoprodutos_id',
            'destino_id' => 'required|integer|exists:destinos_id',
        ];
    }
}
