<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GuiaRegalos;

class GuiaRegalosController extends Controller
{
    public function index()
    {
        $guias = GuiaRegalos::paginate(5);
        return response()->json($guias);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'      => 'required|string|max:150|unique:guia_regalos,nombre',
            'descripcion' => 'nullable|string|max:255'
        ]);

        $guia = GuiaRegalos::create([
            'nombre'      => $validated['nombre'],
            'descripcion' => $validated['descripcion'] ?? null
        ]);

        return response()->json([
            'message' => 'Guía de regalos creada correctamente',
            'data'    => $guia
        ], 201);
    }

    public function show(string $id)
    {
        $guia = GuiaRegalos::find($id);

        if (!$guia) {
            return response()->json([
                'message' => 'Guía de regalos no encontrada'
            ], 404);
        }

        return response()->json($guia);
    }

    public function update(Request $request, string $id)
    {
        $guia = GuiaRegalos::find($id);

        if (!$guia) {
            return response()->json([
                'message' => 'Guía de regalos no encontrada'
            ], 404);
        }

        $validated = $request->validate([
            'nombre'      => 'sometimes|string|max:150|unique:guia_regalos,nombre,' . $id . ',id_guia',
            'descripcion' => 'nullable|string|max:255'
        ]);

        if (isset($validated['nombre'])) $guia->nombre = $validated['nombre'];
        if (array_key_exists('descripcion', $validated)) $guia->descripcion = $validated['descripcion'];

        $guia->save();

        return response()->json([
            'message' => 'Guía de regalos actualizada correctamente',
            'data'    => $guia
        ], 200);
    }

    public function destroy(string $id)
    {
        $guia = GuiaRegalos::find($id);

        if (!$guia) {
            return response()->json([
                'message' => 'Guía de regalos no encontrada'
            ], 404);
        }

        $guia->delete();

        return response()->json([
            'message' => 'Guía de regalos eliminada correctamente'
        ], 200);
    }
}
