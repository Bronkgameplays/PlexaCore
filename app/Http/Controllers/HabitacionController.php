<?php

namespace App\Http\Controllers;

use App\Models\Habitacion;
use App\Models\Conductor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HabitacionController extends Controller
{
    // 1️⃣ Leer todas las habitaciones
    public function hotel()
    {
        // Trae las habitaciones con su conductor asignado
        $habitaciones = Habitacion::with('hconductor')->orderBy('numero')->get();

        // Trae solo los conductores que NO estén ocupando una habitación
        $conductoresOcupados = Habitacion::whereNotNull('conductor')->pluck('conductor');
        $conductores = Conductor::whereNotIn('cedula', $conductoresOcupados) // ✅ usamos 'cedula', no 'id'
                                ->orderBy('nombre')
                                ->get();

        return view('hotel', compact('habitaciones', 'conductores'));
    }

    // 2️⃣ Asignar conductor a una habitación
    public function asignarConductor(Request $request, $id)
    {
        // ✅ Validar usando 'cedula'
        $request->validate([
            'conductor' => 'required|exists:conductores,cedula',
        ]);

        // Buscar habitación
        $habitacion = Habitacion::findOrFail($id);

        // Evitar que el conductor ya esté asignado a otra habitación
        $yaAsignado = Habitacion::where('conductor', $request->conductor)
                                ->where('numero', '!=', $habitacion->numero)
                                ->exists();

        if ($yaAsignado) {
            return redirect()->back()->with('error', 'Este conductor ya tiene una habitación asignada.');
        }

        // Asignar conductor y cambiar estado
        $habitacion->conductor = $request->conductor;
        $habitacion->estado = 'Ocupada';
        $habitacion->save();

        Log::info("Habitación {$habitacion->numero} asignada al conductor CÉDULA: {$request->conductor}");

        return redirect()->back()->with('success', 'Habitación asignada correctamente.');
    }

    // 3️⃣ Desasignar conductor (liberar habitación)
    public function desasignarConductor($id)
    {
        $habitacion = Habitacion::findOrFail($id);

        $habitacion->conductor = null;
        $habitacion->estado = 'Disponible';
        $habitacion->save();

        Log::info("Habitación {$habitacion->numero} liberada.");

        return redirect()->back()->with('success', 'Habitación liberada correctamente.');
    }

    // 4️⃣ Mostrar una habitación específica
    public function show($numero)
    {
        $habitacion = Habitacion::find($numero);
        if (!$habitacion) {
            return redirect()->back()->with('error', 'Habitación no encontrada');
        }
        return view('detalle', compact('habitacion'));
    }

    // 5️⃣ Crear una habitación
    public function store(Request $request)
    {
        $data = $request->validate([
            'numero' => 'required|string|unique:habitaciones,numero',
            'estado' => 'nullable|string',
            'conductor' => 'nullable|string', // ✅ cambiamos a string porque la cédula no es numérica
        ]);

        $habitacion = Habitacion::create($data);
        Log::info("Se creó una habitación número: {$habitacion->numero}");
        return redirect()->back()->with('success', 'Habitación creada correctamente.');
    }

    // 6️⃣ Actualizar una habitación
    public function update(Request $request, $numero)
    {
        $habitacion = Habitacion::find($numero);
        if (!$habitacion) {
            return redirect()->back()->with('error', 'Habitación no encontrada');
        }

        $data = $request->validate([
            'numero' => 'required|string|unique:habitaciones,numero,' . $numero . ',numero',
            'estado' => 'nullable|string',
            'conductor' => 'nullable|string', // ✅ también aquí
        ]);

        $habitacion->update($data);
        Log::info("Se actualizó la habitación número: $numero");
        return redirect()->back()->with('success', 'Habitación actualizada correctamente.');
    }

    // 7️⃣ Eliminar una habitación
    public function destroy($numero)
    {
        $habitacion = Habitacion::find($numero);
        if (!$habitacion) {
            return redirect()->back()->with('error', 'Habitación no encontrada');
        }

        $habitacion->delete();
        Log::info("Se eliminó la habitación número: $numero");
        return redirect()->back()->with('success', 'Habitación eliminada correctamente.');
    }
}
