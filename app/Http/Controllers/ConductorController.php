<?php

namespace App\Http\Controllers;

use App\Models\Conductor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ConductorController extends Controller
{
    // 1️⃣ Leer todos los conductores
    public function index()
    {
        $conductores = Conductor::all();
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
            'documento' => 'required|unique:conductores,documento',
            'nombre' => 'required|string',
            'telefono' => 'nullable|string',
            'email' => 'nullable|email',
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
            'telefono' => 'nullable|string',
            'email' => 'nullable|email',
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
}
