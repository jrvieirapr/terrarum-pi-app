<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalhePedido extends Model
{
    use HasFactory;

    protected $filablle = ['descricao','data','quantidade','valor_unitario', 'total', 'produtos_id', 'eventos_id',];
}


