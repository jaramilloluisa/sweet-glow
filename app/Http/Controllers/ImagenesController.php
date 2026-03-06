<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Imagenes;
use Illuminate\Support\Facades\Storage; // Importante para borrar archivos

class ImagenesController extends Controller
{
    // 1. LISTAR TODO
    public function index()
    {
        return response()->json(Imagenes::all(), 200);
    }

    // 2. GUARDAR IMAGEN
    public function store(Request $request)
    {
        $request->validate([
            'filename' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'id_producto' => 'required|exists:productos,id_producto'
        ]);

        if ($request->hasFile('filename')) {
            // Guarda en storage/app/public/imagenes_productos
            $path = $request->file('filename')->store('imagenes_productos', 'public');

            $imagen = Imagenes::create([
                'filename' => $path,
                'id_producto' => $request->id_producto
            ]);

            return response()->json(['message' => 'Creado', 'data' => $imagen], 201);
        }
    }

    // 3. VER UNA SOLA IMAGEN
    public function show($id)
    {
        $imagen = Imagenes::find($id);
        if (!$imagen) return response()->json(['message' => 'No encontrado'], 404);
        return response()->json($imagen, 200);
    }

    // 4. ACTUALIZAR (Cambiar una imagen por otra)
    public function update(Request $request, $id)
    {
        $imagen = Imagenes::find($id);
        if (!$imagen) return response()->json(['message' => 'No encontrado'], 404);

        if ($request->hasFile('filename')) {
            // Borramos la imagen vieja del disco
            Storage::disk('public')->delete($imagen->filename);
            
            // Subimos la nueva
            $path = $request->file('filename')->store('imagenes_productos', 'public');
            $imagen->update(['filename' => $path]);
        }
        
        return response()->json(['message' => 'Actualizado', 'data' => $imagen], 200);
    }

    // 5. ELIMINAR (Limpieza total)
    public function destroy($id)
    {
        $imagen = Imagenes::find($id);
        if (!$imagen) return response()->json(['message' => 'No encontrado'], 404);

        // Borra el archivo físico de storage/app/public/...
        Storage::disk('public')->delete($imagen->filename);

        // Borra el registro de la BD
        $imagen->delete();

        return response()->json(['message' => 'Eliminado físicamente y de la BD'], 200);
    }
}