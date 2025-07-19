<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Persona extends Model
{
    protected $table = 'personas';
    protected $fillable = [
        'nombre',
        'telefono',
        'tipo',
    ];

    public function prestamos(): HasMany
    {
        return $this->hasMany(Prestamo::class);
    }
}
