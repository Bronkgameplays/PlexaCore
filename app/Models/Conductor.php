<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conductor extends Model
{
    use HasFactory;

    // Nombre exacto de la tabla en la base de datos
    protected $table = 'conductores';

    // Campos que se pueden llenar de forma masiva
    protected $fillable = [
        'id',
        'documento',
        'nombre',
        'telefono',
        'email',
        'fecha de registro',
        // agrega aquí los demás campos que existan en tu tabla "conductores"
    ];

    // Relación con la tabla habitaciones (si una habitación pertenece a un conductor)
    public function habitaciones()
    {
        return $this->hasMany(Habitacion::class, 'conductor_id');
    }
}