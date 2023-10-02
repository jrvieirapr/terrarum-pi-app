<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoProduto extends Model
{
    use HasFactory;

    protected $fillable = ['descricao'];

    protected $table = 'tipo_produtos';


    public function produtos()
    {
        return $this->hasMany(Produto::class);
    }

    public function eventos()
    {
        return $this->hasMany(Evento::class);
    }
}
