<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    protected $fillable = ['Nome', 'Tipo','Descricao','Coordenadas','valor','Obs', 'tipoproduto_id','destino_id'];
}
