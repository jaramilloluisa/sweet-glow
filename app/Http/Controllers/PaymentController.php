<?php

namespace App\Http\Controllers;

use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Exceptions\MPApiException;
use MercadoPago\MercadoPagoConfig;
use App\Models\FacturaPedidos;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function createPreference(Request $request)
    {
        MercadoPagoConfig::setAccessToken(config('services.mp.token'));

        $client = new PreferenceClient();

        $factura = FacturaPedidos::findOrFail($request->invoice_id);

        
        if ($factura->status === 'paid') {
            return response()->json([
                'error' => 'La factura ya fue pagada'
            ], 400);
        }

        
        $total = (float)$factura->neto;
        $descuento = (float)$factura->descuento;
        
        $totalFinal = $total - $descuento;
        
        $items = [
            [
                "title" => "Pago de factura #" . $factura->id_factura_pedido . " Sweet Glow",
                "quantity" => 1,
                "unit_price" => round($totalFinal, 2)
            ]
        ];

        try {
            $preference = $client->create([
                "items" => $items,
                "external_reference" => (string)$factura->id_factura_pedido,
                // "back_urls" => [
                //     "success" => "http://localhost:5173/payment/success",
                //     "failure" => "http://localhost:5173/payment/failure",
                //     "pending" => "http://localhost:5173/payment/pending"
                // ],
                // "auto_return" => "approved",
            ]);

            return response()->json([
                "init_point" => $preference->init_point
            ]);

        } catch (MPApiException $e) {

            return response()->json([
                'error' => $e->getApiResponse()->getContent()
            ], 500);
        }
    }
}