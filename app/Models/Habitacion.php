<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Habitacion extends Model
{
    use HasFactory;

    // Desactivar timestamps automáticos
    public $timestamps = false;

    // Nombre exacto de la tabla
    protected $table = 'habitaciones';

    // ✅ Definir clave primaria personalizada
    protected $primaryKey = 'numero';
    public $incrementing = false;
    protected $keyType = 'string';

    // Campos rellenables
    protected $fillable = [
        'numero',
        'estado',
        'conductor',
    ];

    public function hconductor()
    {
        return $this->belongsTo(Conductor::class, 'conductor', 'cedula');
        // 'conductor' es la columna en habitaciones
        // 'cedula' es la clave primaria en la tabla conductores
    }
}
