<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDestinoRequest extends FormRequest
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
            'nome'=> 'required|min:1|max:20,'
            . $this->route('destino') . ',id|required',
            'coordenadas'=> 'required|min:1|unique:destinos,coordenadas, '
            . $this->route('destino') . ',id|required',
            //
        ];
    }
}
