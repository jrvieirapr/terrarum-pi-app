<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $fillable = ['nome, cpf_cnpj,cep,numero,telefone,login,senha,interesses'];

    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }
}