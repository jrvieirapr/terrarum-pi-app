<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUsuarioRequest extends FormRequest
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
        $userId = $this->route('usuario');
        return [
            'nome' => 'required|string',
            'cpf_cnpj' => 'required|string|unique:usuarios',
            'cep' => 'required|string',
            'numero' => 'required|string', // Atualizado para aceitar uma string
            'telefone' => 'required|string',
            'login' => 'required|string|unique:usuarios',
            'senha' => 'required|string',
            'interesses' => 'required|string',
            //
        ];
    }
}
