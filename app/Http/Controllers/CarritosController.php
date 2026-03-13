<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carritos;

class CarritosController extends Controller {
    
    /**
     * Display a listing of the resource.
     */
    public function index(){
        $carritos = Carritos::paginate(5);

        return response()->json($carritos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_usuario'  => 'required|integer',
            'cantidad'  => 'required|integer',
            'descuento'  => 'required|numeric',
            'id_producto'  => 'required|integer',
            'id_factura_pedido'  => 'required|integer',
            'id_tarjeta' => 'required|integer',
        ]);

        $carrito = Carritos::create([
            'id_usuario' => $validated['id_usuario'],
            'cantidad' => $validated['cantidad'],
            'descuento' => $validated['descuento'],
            'id_producto' => $validated['id_producto'],
            'id_factura_pedido' => $validated['id_factura_pedido'],
            'id_tarjeta' => $validated['id_tarjeta'],
        ]);

        return response()->json([
            'message' => 'Carrito creado correctamente',
            'data' => $carrito
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $carrito = Carritos::find($id);

        if (!$carrito) {
            return response()->json([
                'message' => 'Carrito no encontrado'
            ], 404);
        }

        return response()->json($carrito);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $carrito = Carritos::find($id);

        if (!$carrito) {
            return response()->json([
                'message' => 'Carrito no encontrado'
            ], 404);
        }

        $validated = $request->validate([
            'cantidad'  => 'sometimes|integer',
            'descuento'  => 'sometimes|numeric',
        ]);

        if (isset($validated['cantidad']))     $carrito->cantidad = $validated['cantidad'];
        if (isset($validated['descuento']))     $carrito->descuento = $validated['descuento'];

        $carrito->update();

        return response()->json([
            'message' => 'Carrito actualizado correctamente',
            'data' => $carrito
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $carrito = Carritos::find($id);

        if (!$carrito) {
            return response()->json([
                'message' => 'Carrito no encontrado'
            ], 404);
        }

        $carrito->delete();

        return response()->json([
            'message' => 'Carrito eliminado correctamente'
        ], 200);
    }
}

