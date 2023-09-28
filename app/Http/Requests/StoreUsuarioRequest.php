<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUsuarioRequest extends FormRequest
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
            'nome'=>'required|min:1|',
            'cpf_cnpj'=> 'required|min:1|unique:usuario,cpf_cnpj',
            'cep'=>'required|min:1|',
            'numero'=> 'required|min:1|',
            'telefone'=>'required|min:1|',
            'login'=> 'required|min:1|unique:usuario,login',
            'senha'=> 'required|min:1|',
            'interesses'=> 'required|min:1|',
            //
        ];
    }
}
