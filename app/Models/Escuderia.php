<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Escuderia extends Model
{
    protected $fillable = ['nome'];
    public function votos() { return $this->hasMany(Voto::class); }
    public function notas() { return $this->hasManyThrough(Nota::class, Voto::class); }
}