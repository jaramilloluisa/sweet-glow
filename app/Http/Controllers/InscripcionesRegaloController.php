<?php

namespace App\Http\Controllers;

use App\Models\InscripcionRegalo;
use Illuminate\Http\Request;

class InscripcionesRegaloController extends Controller
{
    public function index()
    {
        return InscripcionRegalo::with(['usuario','factura'])->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_usuario' => 'required|exists:usuarios,id_usuario|unique:inscripciones_regalo,id_usuario',
            'id_factura_pedido' => 'required|exists:factura_pedidos,id_factura_pedido'
        ]);

        $inscripcion = InscripcionRegalo::create($request->all());

        return response()->json($inscripcion,201);
    }

    public function show($id)
    {
        return InscripcionRegalo::with(['usuario','factura'])->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $inscripcion = InscripcionRegalo::findOrFail($id);

        $inscripcion->update($request->all());

        return response()->json([
            "message" => "Inscripción actualizada correctamente"
        ]);
    }

    public function destroy($id)
    {
        $inscripcion = InscripcionRegalo::findOrFail($id);

        $inscripcion->delete();

        return response()->json([
            "message" => "Inscripción eliminada correctamente"
        ]);
    }
}