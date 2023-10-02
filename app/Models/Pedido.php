<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = ['data', 'numero', 'esta_ativo', 'usuario_id'];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function detalhesPedido()
    {
        return $this->hasMany(DetalhePedido::class);
    }
}
