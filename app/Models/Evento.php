<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'descricao', 'coordenadas', 'valor', 'obs', 'tipo_produto_id', 'destino_id'];

    public function destino()
    {
        return $this->belongsTo(Destino::class, 'destino_id');
    }

    public function tipo_de_produto()
    {
        return $this->belongsTo(TipoDeProduto::class, 'tipo_produto_id');
    }

    public function detalhesPedido()
    {
        return $this->hasMany(DetalhePedido::class);
    }
}