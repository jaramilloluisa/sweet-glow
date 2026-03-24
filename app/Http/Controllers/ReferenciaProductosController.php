<?php

namespace App\Http\Controllers;

use App\Models\ReferenciaProductos;
use Illuminate\Http\Request;

class ReferenciaProductosController extends Controller
{
    public function index()
    {
        $referencias = ReferenciaProductos::paginate(5);
        return response()->json($referencias);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo' => 'required|string|max:100|unique:referencia_productos,codigo',
            'color'  => 'required|string|max:100',
            'tamano' => 'required|string|max:100',
        ]);

        $referencia = ReferenciaProductos::create($validated);

        return response()->json([
            'message' => 'Referencia creada correctamente',
            'data'    => $referencia
        ], 201);
    }

    public function show(int $id)
    {
        $referencia = ReferenciaProductos::find($id);

        if (!$referencia) {
            return response()->json([
                'message' => 'Referencia no encontrada'
            ], 404);
        }

        return response()->json($referencia, 200);
    }

    public function update(Request $request, int $id)
    {
        $referencia = ReferenciaProductos::find($id);

        if (!$referencia) {
            return response()->json([
                'message' => 'Referencia no encontrada'
            ], 404);
        }

        $validated = $request->validate([
            'codigo' => 'sometimes|string|max:100|unique:referencia_productos,codigo,' . $id . ',id_referencia',
            'color'  => 'sometimes|string|max:100',
            'tamano' => 'sometimes|string|max:100',
        ]);

        $referencia->update($validated);

        return response()->json([
            'message' => 'Referencia actualizada correctamente',
            'data'    => $referencia
        ], 200);
    }

    public function destroy(int $id)
    {
        $referencia = ReferenciaProductos::find($id);

        if (!$referencia) {
            return response()->json([
                'message' => 'Referencia no encontrada'
            ], 404);
        }

        $referencia->delete();

        return response()->json([
            'message' => 'Referencia eliminada correctamente'
        ], 200);
    }
}