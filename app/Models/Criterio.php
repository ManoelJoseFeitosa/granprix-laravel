<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Criterio extends Model
{
    protected $fillable = ['titulo', 'pergunta', 'peso_maximo'];
    public function votacaos() { return $this->belongsToMany(Votacao::class); }
}