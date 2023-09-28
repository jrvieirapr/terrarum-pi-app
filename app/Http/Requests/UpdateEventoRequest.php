<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventoRequest extends FormRequest
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
            'Nome' =>'min:2|max:50|required',
            'Descricao' =>'min:2|required',
            'Coordenadas' =>'min:2|required',
            'valor' =>'min:2|max:10|required',
            'Obs' =>'min:1|max:150|required',
            'tipos_de_produto_id' => 'required|integer|exists:tipos_de_produtos,id',
            'destino_id' => 'required|integer|exists:destinos,id',
        ];
    }
}
