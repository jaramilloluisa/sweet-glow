<?php

namespace App\Http\Controllers;

use App\Models\Premiados;
use Illuminate\Http\Request;

class PremiadosController extends Controller
{
    public function index()
    {
        return response()->json(
            Premiados::with(['usuario', 'premio', 'inscripcion'])->get()
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_premio' => 'required|exists:premios,id_premio',
            'id_usuario' => 'required|exists:usuarios,id_usuario',
            'id_inscripcion' => 'required|exists:inscripciones_regalo,id_inscripcion'
        ]);

        $premiado = Premiados::create($validated);

        return response()->json($premiado, 201);
    }

     public function show($id)
    {
        $premiado = Premiados::with(['usuario', 'premio', 'inscripcion'])->find($id);
        if (!$premiado) {
            return response()->json(['message' => 'Premiado no encontrado'], 404);
        }
        return response()->json($premiado);
    }

    // Para editar (PUT)
    public function update(Request $request, $id)
    {
        $premiado = Premiados::find($id);
        if (!$premiado) {
            return response()->json(['message' => 'No existe ese premiado'], 404);
        }
        $premiado->update($request->all());
        return response()->json($premiado, 200);
    }

    // Para borrar (DELETE)
    public function destroy($id)
    {
        $premiado = Premiados::find($id);
        if (!$premiado) {
            return response()->json(['message' => 'No se pudo borrar, no existe'], 404);
        }
        $premiado->delete();
        return response()->json(['message' => 'Premiado eliminado correctamente'], 200);
    }
}