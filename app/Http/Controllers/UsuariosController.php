<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuarios;

class UsuariosController extends Controller {
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request){
        $search = $request->search;

        $users = Usuarios::with([
            'rol',
        ])->when($search, function ($query, $search) {
            $query->where('nombres', 'like', "%{$search}%")
                  ->orWhere('apellidos', 'like', "%{$search}%")
                  ->orWhere('correo', 'like', "%{$search}%")
                  ->orWhere('num_documento', 'like', "%{$search}%")
                  ->orWhere('telefono', 'like', "%{$search}%");
        })->paginate(5);

        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombres'  => 'required|string|max:100',
            'apellidos'  => 'required|string|max:100',
            'tipo_documento'  => 'required|string|max:20',
            'num_documento'  => 'required|string|max:20',
            'telefono'  => 'required|string|max:20',
            'direccion'  => 'required|string|max:255',
            'id_rol'  => 'required|integer',
            'correo' => 'required|email|unique:usuarios,correo',
            'contrasena' => 'required|min:6',
        ]);

        $user = Usuarios::create([
            'nombres' => $validated['nombres'],
            'apellidos' => $validated['apellidos'],
            'tipo_documento' => $validated['tipo_documento'],
            'num_documento' => $validated['num_documento'],
            'telefono' => $validated['telefono'],
            'correo' => $validated['correo'],
            'id_rol'  => $validated['id_rol'],
            'direccion' => $validated['direccion'],
            'contrasena' => bcrypt($validated['contrasena']),
        ]);

        return response()->json([
            'message' => 'Usuario creado correctamente',
            'data' => $user
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = Usuarios::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'Usuario no encontrado'
            ], 404);
        }

        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = Usuarios::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'Usuario no encontrado'
            ], 404);
        }

        $validated = $request->validate([
            'nombres'  => 'sometimes|string|max:100',
            'apellidos'  => 'sometimes|string|max:100',
            'tipo_documento'  => 'sometimes|string|max:20',
            'num_documento'  => 'sometimes|string|max:20',
            'telefono'  => 'sometimes|string|max:20',
            'direccion'  => 'sometimes|string|max:255',
            'correo' => 'sometimes|email|unique:usuarios,correo,' . $id . ',id_usuario',
            'contrasena' => 'sometimes|min:6',
            'id_rol' => 'sometimes|integer',
        ]);

        if (isset($validated['nombres']))     $user->nombres = $validated['nombres'];
        if (isset($validated['apellidos']))     $user->apellidos = $validated['apellidos'];
        if (isset($validated['tipo_documento']))     $user->tipo_documento = $validated['tipo_documento'];
        if (isset($validated['num_documento']))     $user->num_documento = $validated['num_documento'];
        if (isset($validated['telefono']))     $user->telefono = $validated['telefono'];
        if (isset($validated['direccion']))     $user->direccion = $validated['direccion'];
        if (isset($validated['correo']))     $user->correo = $validated['correo'];
        if (isset($validated['contrasena'])) $user->contrasena = bcrypt($validated['contrasena']);
        if (isset($validated['id_rol']))     $user->id_rol = $validated['id_rol'];

        $user->update();

        return response()->json([
            'message' => 'Usuario actualizado correctamente',
            'data' => $user
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = Usuarios::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'Usuario no encontrado'
            ], 404);
        }

        $user->delete();

        return response()->json([
            'message' => 'Usuario eliminado correctamente'
        ], 200);
    }
}
