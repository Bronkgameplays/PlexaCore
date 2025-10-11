<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conductor extends Model
{
    use HasFactory;

    // Desactivar timestamps automáticos
    public $timestamps = false;

    // Nombre exacto de la tabla
    protected $table = 'conductores';

    // ✅ Definir clave primaria personalizada
    protected $primaryKey = 'cedula';
    public $incrementing = false;
    protected $keyType = 'string';

    // Campos rellenables
    protected $fillable = [
        'cedula',
        'nombre',
        'apellido',
        'email',
        'celular',
        'tipo',
        'estado',
    ];

    // Relación con habitaciones (opcional)
    /*
    public function habitaciones()
    {
        return $this->hasMany(Habitacion::class, 'conductor_id');
    }
        */
}
