<?php

namespace App\Http\Controllers;

use App\Models\Premio;
use Illuminate\Http\Request;

class PremioController extends Controller
{
    public function index()
    {
        $premios = Premio::with('producto')->paginate(5);
        return response()->json($premios);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_producto' => 'required|exists:productos,id_producto'
        ]);

        $premio = Premio::create($validated);

        return response()->json([
            'message' => 'Premio creado correctamente',
            'data'    => $premio
        ], 201);
    }

    public function show(string $id)
    {
        $premio = Premio::with('producto')->find($id);

        if (!$premio) {
            return response()->json(['message' => 'Premio no encontrado'], 404);
        }

        return response()->json($premio);
    }

    public function update(Request $request, string $id)
    {
        $premio = Premio::find($id);

        if (!$premio) {
            return response()->json(['message' => 'Premio no encontrado'], 404);
        }

        $validated = $request->validate([
            'id_producto' => 'required|exists:productos,id_producto'
        ]);

        $premio->update($validated);

        return response()->json([
            'message' => 'Premio actualizado correctamente',
            'data'    => $premio
        ], 200);
    }

    public function destroy(string $id)
    {
        $premio = Premio::find($id);

        if (!$premio) {
            return response()->json(['message' => 'Premio no encontrado'], 404);
        }

        $premio->delete();

        return response()->json(['message' => 'Premio eliminado correctamente'], 200);
    }
}