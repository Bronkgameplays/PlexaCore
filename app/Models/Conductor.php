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
    protected $keyType = 'int'; // 👈 esto es lo correcto

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
}
