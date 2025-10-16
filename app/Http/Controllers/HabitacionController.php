<?php

namespace App\Http\Controllers;

use App\Models\Habitacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Conductor;

class HabitacionController extends Controller
{
    // 1️⃣ Leer todas las habitaciones
    public function hotel()
    {
        $habitaciones = Habitacion::with('hconductor')->orderBy('numero')->get();
        $conductores = Conductor::orderBy('nombre')->get(); // ✅ Trae todos los conductores

        return view('hotel', compact('habitaciones', 'conductores'));
    }

    // 2️⃣ Leer una habitación por número
    public function show($numero)
    {
        $habitacion = Habitacion::find($numero);
        if (!$habitacion) {
            return redirect()->back()->with('error', 'Habitación no encontrada');
        }
        return view('detalle', compact('habitacion'));
    }

    // 3️⃣ Crear una habitación
    public function store(Request $request)
    {
        $data = $request->validate([
            'numero' => 'required|string|unique:habitaciones,numero',
            'estado' => 'nullable|int',
            'conductor' => 'nullable|string',
        ]);

        $habitacion = Habitacion::create($data);
        Log::info("Se creó una habitación número: {$habitacion->numero}");
        return redirect()->back()->with('success', 'Habitación creada');
    }

    // 4️⃣ Actualizar una habitación
    public function update(Request $request, $numero)
    {
        $habitacion = Habitacion::find($numero);
        if (!$habitacion) {
            return response()->json(['success' => false, 'error' => 'Habitación no encontrada'], 404);
        }
    
        $data = $request->validate([
            'numero' => 'nullable|string',
            'estado' => 'nullable|string|in:Disponible,Ocupada',
            'conductor' => 'nullable|string',
        ]);
    
        $habitacion->update($data);
    
        \Log::info("Se actualizó la habitación número: $numero con estado: {$habitacion->estado} y conductor: {$habitacion->conductor}");
    
        return response()->json([
            'success' => true,
            'message' => 'Habitación actualizada correctamente',
            'habitacion' => $habitacion
        ]);
    }    

    // 5️⃣ Borrar una habitación
    public function destroy($numero)
    {
        $habitacion = Habitacion::find($numero);
        if (!$habitacion) {
            return redirect()->back()->with('error', 'Habitación no encontrada');
        }

        $habitacion->delete();
        Log::info("Se eliminó la habitación número: $numero");
        return redirect()->back()->with('success', 'Habitación eliminada');
    }
    
}
