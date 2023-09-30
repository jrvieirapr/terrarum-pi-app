<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalhePedido extends Model
{
    use HasFactory;

    protected $fillable = ['pedido_id', 'evento_id',  'produto_id', 'descricao', 'valor', 'data', 'quantidade', 'valor_unitario', 'valor_total'];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }

    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }
}