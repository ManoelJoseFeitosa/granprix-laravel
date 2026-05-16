<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    protected $fillable = ['voto_id', 'criterio_id', 'valor'];
    public function voto() { return $this->belongsTo(Voto::class); }
    public function criterio() { return $this->belongsTo(Criterio::class); }
}