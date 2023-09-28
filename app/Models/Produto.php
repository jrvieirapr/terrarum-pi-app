<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $fillable = ['tipo','destino_id','tipos_de_produtos_id','esta_ativo'];
    public $timestamps = false;
}

