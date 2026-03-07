<?php

namespace App\Http\Controllers;

use App\Models\Resena;
use Illuminate\Http\Request;

class ResenasController extends Controller
{

    // LISTAR RESEÑAS
    public function index()
    {
        $resenas = Resena::with(['producto','usuario'])->get();
        return response()->json($resenas);
    }

    // CREAR RESEÑA
    public function store(Request $request)
    {
        $request->validate([
            'resena' => 'required|integer|min:1|max:5',
            'id_producto' => 'required|exists:productos,id_producto',
            'id_usuario' => 'required|exists:usuarios,id_usuario'
        ]);

        $resena = Resena::create($request->all());

        return response()->json([
            'message' => 'Reseña creada correctamente',
            'data' => $resena
        ], 201);
    }

    // MOSTRAR UNA RESEÑA
    public function show($id)
    {
        $resena = Resena::find($id);

        if(!$resena){
            return response()->json(['message'=>'Reseña no encontrada'],404);
        }

        return response()->json($resena);
    }

    // ACTUALIZAR RESEÑA
    public function update(Request $request, $id)
    {
        $resena = Resena::find($id);

        if(!$resena){
            return response()->json(['message'=>'Reseña no encontrada'],404);
        }

        $request->validate([
            'resena' => 'integer|min:1|max:5'
        ]);

        $resena->update($request->all());

        return response()->json([
            'message'=>'Reseña actualizada',
            'data'=>$resena
        ]);
    }

    // ELIMINAR RESEÑA
    public function destroy($id)
    {
        $resena = Resena::find($id);

        if(!$resena){
            return response()->json(['message'=>'Reseña no encontrada'],404);
        }

        $resena->delete();

        return response()->json([
            'message'=>'Reseña eliminada correctamente'
        ]);
    }
}