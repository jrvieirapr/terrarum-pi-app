<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destino extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'coordenadas'];


    public function produtos()
    {
        return $this->hasMany(Produto::class);
    }

    public function eventos()
    {
        return $this->hasMany(Evento::class);
    }
}