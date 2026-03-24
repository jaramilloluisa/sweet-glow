<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function handle(Request $request)
    {
        $data = $request->all();

        // Aquí validas el pago consultando a Mercado Pago
        // usando el payment_id

        return response()->json(['status' => 'ok']);
    }
}
