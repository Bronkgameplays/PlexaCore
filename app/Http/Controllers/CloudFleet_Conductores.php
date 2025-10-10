<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CloudFleet_Conductores extends Controller
{
    public function obtenerTodos()
    {
        $apiKey = env('CLOUDFLEET_API_KEY');
        $url = "https://fleet.cloudfleet.com/api/v1/people/";
        $conductores = [];

        do {
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$apiKey}",
                'Content-Type' => 'application/json; charset=utf-8',
            ])->get($url);

            if (!$response->successful()) {
                return response()->json([
                    'error' => 'Error al conectar con la API CloudFleet',
                    'status' => $response->status(),
                    'body' => $response->body()
                ], $response->status());
            }

            // Decodificar los registros actuales
            $data = $response->json();

            if (is_array($data)) {
                $conductores = array_merge($conductores, $data);
            }

            // Revisar si hay siguiente página
            $url = $response->header('X-NextPage');

        } while ($url); // Continua mientras haya siguiente página

        // Retornar la vista con todos los conductores
        return view('conductores', compact('conductores'));
    }
}
