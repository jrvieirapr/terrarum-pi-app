<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = ['data', 'produto', 'quant', 'preco', 'total', 'obs', 'usuario_id', 'detalhes_pedido_id'];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function detalhes_pedido()
    {
        return $this->hasMany(DetalhePedido::class, 'detalhes_pedido_id');
    }
}