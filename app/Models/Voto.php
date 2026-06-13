<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voto extends Model
{
    use HasFactory;

    // Correção: Liberação da inserção em massa para o envio do formulário
    protected $fillable = [
        'votacao_id',
        'jurado',
        'escuderia_id',
    ];

    public function notas()
    {
        return $this->hasMany(Nota::class);
    }

    public function escuderia()
    {
        return $this->belongsTo(Escuderia::class);
    }

    public function votacao()
    {
        return $this->belongsTo(Votacao::class);
    }
}
