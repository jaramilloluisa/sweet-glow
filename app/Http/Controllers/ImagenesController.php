<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Imagenes;
use Illuminate\Support\Facades\Storage;

class ImagenesController extends Controller
{
    public function index()
    {
        $imagenes = Imagenes::with('producto')->paginate(5);
        return response()->json($imagenes);
    }

    public function store(Request $request)
    {
        $request->validate([
            'filename'    => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'id_producto' => 'required|exists:productos,id_producto'
        ]);

        $path = $request->file('filename')->store('imagenes_productos', 'public');

        $imagen = Imagenes::create([
            'filename'    => $path,
            'id_producto' => $request->id_producto
        ]);

        return response()->json([
            'message' => 'Imagen creada correctamente',
            'data'    => $imagen
        ], 201);
    }

    public function show(string $id)
    {
        $imagen = Imagenes::with('producto')->find($id);

        if (!$imagen) {
            return response()->json([
                'message' => 'Imagen no encontrada'
            ], 404);
        }

        return response()->json($imagen);
    }

    public function update(Request $request, string $id)
    {
        $imagen = Imagenes::find($id);

        if (!$imagen) {
            return response()->json([
                'message' => 'Imagen no encontrada'
            ], 404);
        }

        $request->validate([
            'filename'    => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            'id_producto' => 'sometimes|exists:productos,id_producto'
        ]);

        if ($request->hasFile('filename')) {
            Storage::disk('public')->delete($imagen->filename);
            $path = $request->file('filename')->store('imagenes_productos', 'public');
            $imagen->filename = $path;
        }

        if ($request->filled('id_producto')) {
            $imagen->id_producto = $request->id_producto;
        }

        $imagen->save();

        return response()->json([
            'message' => 'Imagen actualizada correctamente',
            'data'    => $imagen
        ], 200);
    }

    public function destroy(string $id)
    {
        $imagen = Imagenes::find($id);

        if (!$imagen) {
            return response()->json([
                'message' => 'Imagen no encontrada'
            ], 404);
        }

        Storage::disk('public')->delete($imagen->filename);
        $imagen->delete();

        return response()->json([
            'message' => 'Imagen eliminada correctamente'
        ], 200);
    }
}