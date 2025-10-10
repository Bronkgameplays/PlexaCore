<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Habitacion extends Model
{
    use HasFactory;

    // Nombre exacto de la tabla en la base de datos
    protected $table = 'habitaciones';

    // Campos que pueden modificarse (ajústalos según tu tabla real)
    protected $fillable = [
        'numero',
        'estado',
        'conductor_id'
    ];

    // Relación: una habitación pertenece a un conductor
    public function conductor()
    {
        return $this->belongsTo(Conductor::class, 'conductor_id');
    }
}
