<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voto extends Model
{
    protected $fillable = ['votacao_id', 'jurado', 'escuderia_id'];
    public function votacao() { return $this->belongsTo(Votacao::class); }
    public function escuderia() { return $this->belongsTo(Escuderia::class); }
    public function notas() { return $this->hasMany(Nota::class); }
}