<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Votacao extends Model
{
    protected $fillable = ['nome', 'esta_ativa'];
    public function criterios() { return $this->belongsToMany(Criterio::class); }
    public function votos() { return $this->hasMany(Voto::class); }
}