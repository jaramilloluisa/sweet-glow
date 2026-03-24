<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FacturaPedidos;

class FacturaPedidosController extends Controller {
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request){
        $search = $request->search;

        $facturaPedidos = FacturaPedidos::with([
            'usuario',
            'carrito',
            'tarjeta',
        ])->when($search, function ($query, $search) {
            $query->where('id_factura_pedido', 'like', "%{$search}%");
        })->paginate(5);

        return response()->json($facturaPedidos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_usuario'  => 'required|integer',
            'id_carrito'  => 'required|integer',
            'id_tarjeta'  => 'sometimes',
            'neto'  => 'required|numeric',
            'descuento'  => 'required|numeric',
            'status'  => 'required|string',
        ]);

        $facturaPedido = FacturaPedidos::create([
            'id_usuario' => $validated['id_usuario'],
            'id_carrito' => $validated['id_carrito'],
            'id_tarjeta' => $validated['id_tarjeta'],
            'status' => $validated['status'],
            'descuento' => $validated['descuento'],
            'neto' => $validated['neto'],
        ]);

        return response()->json([
            'message' => 'Factura creada correctamente',
            'data' => $facturaPedido
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $facturaPedido = FacturaPedidos::with([
            'usuario',
            'carrito',
            'tarjeta',
        ])->find($id);

        if (!$facturaPedido) {
            return response()->json([
                'message' => 'Factura no encontrada'
            ], 404);
        }

        return response()->json($facturaPedido);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $facturaPedido = FacturaPedidos::find($id);

        if (!$facturaPedido) {
            return response()->json([
                'message' => 'Factura no encontrada'
            ], 404);
        }

        $validated = $request->validate([
            'id_usuario'  => 'sometimes|integer',
            'id_carrito'  => 'sometimes|integer',
            'id_tarjeta'  => 'sometimes',
            'neto'  => 'sometimes|numeric',
            'descuento'  => 'sometimes|numeric',
            'status'  => 'sometimes|string',
        ]);

        if (isset($validated['neto']))     $facturaPedido->neto = $validated['neto'];
        if (isset($validated['id_usuario']))     $facturaPedido->id_usuario = $validated['id_usuario'];
        if (isset($validated['id_carrito']))     $facturaPedido->id_carrito = $validated['id_carrito'];
        if (isset($validated['id_tarjeta']))     $facturaPedido->id_tarjeta = $validated['id_tarjeta'];
        if (isset($validated['descuento']))     $facturaPedido->descuento = $validated['descuento'];
        if (isset($validated['status']))     $facturaPedido->status = $validated['status'];

        $facturaPedido->update();

        return response()->json([
            'message' => 'Factura actualizada correctamente',
            'data' => $facturaPedido
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $facturaPedido = FacturaPedidos::find($id);

        if (!$facturaPedido) {
            return response()->json([
                'message' => 'Factura no encontrada'
            ], 404);
        }

        $facturaPedido->delete();

        return response()->json([
            'message' => 'Factura eliminada correctamente'
        ], 200);
    }
}
