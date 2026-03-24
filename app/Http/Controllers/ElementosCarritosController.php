<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ElementosCarritos;

class ElementosCarritosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        $elementosCarritos = ElementosCarritos::with([
            'producto',
            "carrito"
        ])->paginate(5);

        return response()->json($elementosCarritos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_carrito'  => 'required|integer',
            'id_producto'  => 'required|integer',
            'cantidad'  => 'required|integer',
            'price'  => 'required|integer',
        ]);

        $carrito = ElementosCarritos::create([
            'id_carrito' => $validated['id_carrito'],
            'id_producto' => $validated['id_producto'],
            'cantidad' => $validated['cantidad'],
            'price' => $validated['price'],
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
        $carrito = ElementosCarritos::with([
            'producto',
            "carrito"
        ])->find($id);

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
        $carrito = ElementosCarritos::find($id);

        if (!$carrito) {
            return response()->json([
                'message' => 'Carrito no encontrado'
            ], 404);
        }

        $validated = $request->validate([
            'id_carrito'  => 'sometimes|integer',
            'id_producto'  => 'sometimes|integer',
            'cantidad'  => 'sometimes|integer',
            'price'  => 'sometimes|integer',
        ]);

        if (isset($validated['id_carrito']))     $carrito->id_carrito = $validated['id_carrito'];
        if (isset($validated['id_producto']))     $carrito->id_producto = $validated['id_producto'];
        if (isset($validated['cantidad']))     $carrito->cantidad = $validated['cantidad'];
        if (isset($validated['price']))     $carrito->price = $validated['price'];

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
        $carrito = ElementosCarritos::find($id);

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
