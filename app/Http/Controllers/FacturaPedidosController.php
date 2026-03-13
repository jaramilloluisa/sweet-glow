<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FacturaPedidos;

class FacturaPedidosController extends Controller {
    
    /**
     * Display a listing of the resource.
     */
    public function index(){
        $facturaPedidos = FacturaPedidos::paginate(5);

        return response()->json($facturaPedidos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_usuario'  => 'required|integer',
            'neto'  => 'required|numeric',
        ]);

        $facturaPedido = FacturaPedidos::create([
            'id_usuario' => $validated['id_usuario'],
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
        $facturaPedido = FacturaPedidos::find($id);

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
            'neto'  => 'sometimes|numeric',
        ]);

        if (isset($validated['neto']))     $facturaPedido->neto = $validated['neto'];

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
