<?php

namespace App\Http\Controllers;

use App\Models\Resena;
use Illuminate\Http\Request;

class ResenasController extends Controller
{
    // LISTAR RESEÑAS CON PAGINACIÓN
    public function index(Request $request)
    {
        $perPage = $request->query('limit', 10);
        $perPage = min(max(1, (int)$perPage), 100);

        $resenas = Resena::with([
                'producto.categoria',   // carga producto Y su categoría
                'producto.marca',       // carga producto Y su marca
                'usuario'
            ])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return response()->json([
            'valid'        => true,
            'resenas'      => $resenas->items(),
            'current_page' => $resenas->currentPage(),
            'last_page'    => $resenas->lastPage(),
            'per_page'     => $resenas->perPage(),
            'total'        => $resenas->total()
        ]);
    }

    // CREAR RESEÑA
    public function store(Request $request)
    {
        $request->validate([
            'resena'       => 'required|integer|min:1|max:5',
            'id_producto'  => 'required|exists:productos,id_producto',
            'id_usuario'   => 'required|exists:usuarios,id_usuario'
        ]);

        $resena = Resena::create($request->all());

        return response()->json([
            'valid'   => true,
            'message' => 'Reseña creada correctamente',
            'data'    => $resena
        ], 201);
    }

    // MOSTRAR UNA RESEÑA
    public function show($id)
    {
        $resena = Resena::with([
                'producto.categoria',
                'producto.marca',
                'usuario'
            ])->find($id);

        if (!$resena) {
            return response()->json(['message' => 'Reseña no encontrada'], 404);
        }

        return response()->json([
            'valid'  => true,
            'resena' => $resena
        ]);
    }

    // ACTUALIZAR RESEÑA (solo calificación)
    public function update(Request $request, $id)
    {
        $resena = Resena::find($id);

        if (!$resena) {
            return response()->json(['message' => 'Reseña no encontrada'], 404);
        }

        $request->validate([
            'resena' => 'required|integer|min:1|max:5'
        ]);

        $resena->update($request->only('resena'));

        return response()->json([
            'valid'   => true,
            'message' => 'Reseña actualizada',
            'data'    => $resena
        ]);
    }

    // ELIMINAR RESEÑA
    public function destroy($id)
    {
        $resena = Resena::find($id);

        if (!$resena) {
            return response()->json(['message' => 'Reseña no encontrada'], 404);
        }

        $resena->delete();

        return response()->json([
            'valid'   => true,
            'message' => 'Reseña eliminada correctamente'
        ]);
    }
}