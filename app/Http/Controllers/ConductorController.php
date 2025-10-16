<?php

namespace App\Http\Controllers;

use App\Models\Conductor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ConductorController extends Controller
{
    // 1️⃣ Leer todos los conductores para la vista tablas
    public function tablas()
    {
        $conductores = Conductor::orderBy('nombre')->get();
        return view('tablas', compact('conductores'));
    }

    // 2️⃣ Leer un conductor por ID
    public function show($id)
    {
        $conductor = Conductor::find($id);
        if (!$conductor) {
            return redirect()->back()->with('error', 'Conductor no encontrado');
        }
        return view('detalle', compact('conductor'));
    }

    // 3️⃣ Crear un conductor
    public function store(Request $request)
    {
        $data = $request->validate([
            'cedula' => 'required|unique:conductores,documento',
            'nombre' => 'required|string',
            'apellido' => 'nullable|string',
            'email' => 'nullable|email',
            'celular' => 'nullable|string',
            'tipo' => 'nullable|string',
            'estado' => 'nullable|int',
        ]);

        $conductor = Conductor::create($data);
        Log::info("Se creó un conductor ID: {$conductor->id}");
        return redirect()->back()->with('success', 'Conductor creado');
    }

    // 4️⃣ Actualizar un conductor
    public function update(Request $request, $id)
    {
        $conductor = Conductor::find($id);
        if (!$conductor) {
            return redirect()->back()->with('error', 'Conductor no encontrado');
        }

        $data = $request->validate([
            'documento' => 'required|unique:conductores,documento,' . $id,
            'nombre' => 'required|string',
            'apellido' => 'nullable|string',
            'email' => 'nullable|email',
            'celular' => 'nullable|string',
            'tipo' => 'nullable|string',
            'estado' => 'nullable|int',
        ]);

        $conductor->update($data);
        Log::info("Se actualizó el conductor ID: $id");
        return redirect()->back()->with('success', 'Conductor actualizado');
    }

    // 5️⃣ Borrar un conductor
    public function destroy($id)
    {
        $conductor = Conductor::find($id);
        if (!$conductor) {
            return redirect()->back()->with('error', 'Conductor no encontrado');
        }

        $conductor->delete();
        Log::info("Se eliminó el conductor ID: $id");
        return redirect()->back()->with('success', 'Conductor eliminado');
    }

    // 6️⃣ Buscar conductores disponibles por nombre o documento
    public function buscarDisponibles(Request $request)
    {
        $termino = $request->input('term');

        // 🔹 Evitar caracteres especiales no deseados
        $termino = preg_replace('/[^a-zA-Z0-9\s%]/', '', $termino);

        // 🔹 Buscar conductores no asignados (estado = 1 por ejemplo)
        $conductores = Conductor::where('estado', 1)
            ->where(function ($query) use ($termino) {
                $query->where('nombre', 'LIKE', "%{$termino}%")
                      ->orWhere('apellido', 'LIKE', "%{$termino}%")
                      ->orWhere('documento', 'LIKE', "%{$termino}%");
            })
            ->orderBy('nombre')
            ->get(['id', 'nombre', 'apellido', 'documento']);

        // 🔹 Retornar JSON para el autocompletado
        return response()->json($conductores);
    }
}
