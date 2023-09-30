<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $fillable = ['descricao', 'esta_ativo', 'tipos_de_produto_id', 'destino_id'];

    public function destino()
    {
        return $this->belongsTo(Destino::class, 'destino_id');
    }

    public function tipo_de_produto()
    {
        return $this->belongsTo(TipoDeProduto::class, 'tipos_de_produto_id');
    }
}