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
            'nome' => 'min:2|max:50|required|unique:eventos,nome,' . $this->route("evento") . ',id',
            'descricao' => 'min:2|required',
            'coordenadas' => 'min:2|required',
            'valor' => 'min:2|max:10|required',
            'obs' => 'min:1|max:150|required',
            'tipo_produto_id' => 'required|exists:tipo_produtos,id',
            'destino_id' => 'required|exists:destinos,id',
        ];
    }
}