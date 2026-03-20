<?php

namespace App\Http\Controllers;

use App\Models\TarjetasRegalo;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TarjetasRegaloController extends Controller
{
    // 🔹 LISTAR TODAS LAS TARJETAS
    public function index(Request $request)
    {
        $search = $request->search;

        $tarjetas = TarjetasRegalo::with('usuario')->when($search, function ($query, $search) {
            $query->where('id_tarjeta', 'like', "%{$search}%");
        })->paginate(5);
        return response()->json($tarjetas);
    }

    // 🔹 CREAR TARJETA
    public function store(Request $request)
    {
        $request->validate([
            'monto' => 'required|numeric|min:1',
            'fecha_expiracion' => 'required|date',
            'id_usuario' => 'required|exists:usuarios,id_usuario'
        ]);

        $tarjeta = TarjetasRegalo::create([
        'monto' => $request->monto,
        'fecha_expiracion' => $request->fecha_expiracion,
        'fecha_de_uso' => Carbon::now(),
        'id_usuario' => $request->id_usuario,
        'fecha_creacion' => Carbon::now(),
        'estado' => 'activa',
        ]);

        return response()->json($tarjeta, 201);
    }

    // 🔹 MOSTRAR UNA TARJETA
    public function show($id)
    {
        $tarjeta = TarjetasRegalo::with('usuario')->find($id);

        if (!$tarjeta) {
            return response()->json(['message' => 'Tarjeta no encontrada'], 404);
        }

        return response()->json($tarjeta);
    }

    // 🔹 ACTUALIZAR TARJETA
    public function update(Request $request, $id)
    {
        $tarjeta = TarjetasRegalo::find($id);
        if (!$tarjeta) {
            return response()->json(['message' => 'Tarjeta no encontrada'], 404);
        }

        $validated = $request->validate([
            'monto' => 'sometimes|numeric|min:1',
            'fecha_expiracion' => 'sometimes|date',
            'estado' => 'sometimes|string'
        ]);

        $tarjeta->update($validated);

        return response()->json($tarjeta);
    }

    // 🔹 USAR TARJETA
    public function usar($id)
    {
        $tarjeta = TarjetasRegalo::find($id);
        if (!$tarjeta) {
            return response()->json(['message' => 'Tarjeta no encontrada'], 404);
        }

        if ($tarjeta->estado !== 'activa') {
            return response()->json(['error' => 'La tarjeta no está activa'], 400);
        }

        $tarjeta->update([
            'estado' => 'usada',
            'fecha_de_uso' => Carbon::now()
        ]);

        return response()->json(['mensaje' => 'Tarjeta usada correctamente']);
    }

    // 🔹 ELIMINAR TARJETA
    public function destroy($id)
    {
        $tarjeta = TarjetasRegalo::find($id);
        if (!$tarjeta) {
            return response()->json(['message' => 'Tarjeta no encontrada'], 404);
        }

        $tarjeta->delete();

        return response()->json(['mensaje' => 'Tarjeta eliminada correctamente']);
    }
}



