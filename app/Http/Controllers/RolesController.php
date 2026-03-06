<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Roles;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Roles::paginate(5);

        return response()->json($roles);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100|unique:roles,nombre'
        ]);

        $rol = Roles::create([
            'nombre' => $validated['nombre']
        ]);

        return response()->json([
            'message' => 'Rol creado correctamente',
            'data' => $rol
        ], 201);
    } 

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rol = Roles::find($id);

        if (!$rol) {
            return response()->json([
                'message' => 'Rol no encontrado'
            ], 404);
        }

        return response()->json($rol);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rol = Roles::find($id);

        if (!$rol) {
            return response()->json([
                'message' => 'Rol no encontrado'
            ], 404);
        }

        $validated = $request->validate([
            'id_rol' => 'sometimes|string|max:100',
            'nombre' => 'sometimes|string|max:100|unique:roles,nombre'
        ]);

        if (isset($validated['id_rol']))     $rol->id_rol = $validated['id_rol'];
        if (isset($validated['nombre']))     $rol->nombre = $validated['nombre'];

        $rol->update();

        return response()->json([
            'message' => 'Rol actualizado correctamente',
            'data' => $rol
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rol = Roles::find($id);

        if (!$rol) {
            return response()->json([
                'message' => 'Rol no encontrado'
            ], 404);
        }

        $rol->delete();

        return response()->json([
            'message' => 'Rol eliminado correctamente'
        ], 200);
    }
}
