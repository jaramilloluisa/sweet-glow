<?php

namespace App\Http\Controllers;

use App\Models\Premiados;
use Illuminate\Http\Request;

class PremiadosController extends Controller
{
    public function index()
    {
        $premiados = Premiados::with(['usuario', 'premio'])->paginate(5);
        return response()->json($premiados);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_premio'      => 'required|exists:premios,id_premio',
            'id_usuario'     => 'required|exists:usuarios,id_usuario',
            'id_inscripcion' => 'required|integer'
        ]);

        $premiado = Premiados::create($validated);

        return response()->json([
            'message' => 'Premiado creado correctamente',
            'data'    => $premiado
        ], 201);
    }

    public function show($id)
    {
        $premiado = Premiados::with(['usuario', 'premio'])->find($id);

        if (!$premiado) {
            return response()->json(['message' => 'Premiado no encontrado'], 404);
        }

        return response()->json($premiado);
    }

    public function update(Request $request, $id)
    {
        $premiado = Premiados::find($id);

        if (!$premiado) {
            return response()->json(['message' => 'Premiado no encontrado'], 404);
        }

        $validated = $request->validate([
            'id_premio'      => 'sometimes|exists:premios,id_premio',
            'id_usuario'     => 'sometimes|exists:usuarios,id_usuario',
            'id_inscripcion' => 'sometimes|integer'
        ]);

        $premiado->update($validated);

        return response()->json([
            'message' => 'Premiado actualizado correctamente',
            'data'    => $premiado
        ], 200);
    }

    public function destroy($id)
    {
        $premiado = Premiados::find($id);

        if (!$premiado) {
            return response()->json(['message' => 'Premiado no encontrado'], 404);
        }

        $premiado->delete();

        return response()->json(['message' => 'Premiado eliminado correctamente'], 200);
    }
}