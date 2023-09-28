<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    protected $fillable = ['Nome','Descricao','Coordenadas','valor','Obs', 'tipos_de_produto_id','destino_id'];
}
