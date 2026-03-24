<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacturaPedidos extends Model
{
    use HasFactory;

    protected $table = 'factura_pedidos';

    protected $primaryKey = 'id_factura_pedido';

    protected $fillable = [
        'id_usuario',
        "id_carrito",
        "id_tarjeta",
        'neto',
        'descuento',
        'status',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuarios::class, 'id_usuario');
    }

    public function carrito()
    {
        return $this->belongsTo(Carritos::class, 'id_carrito');
    }

    public function tarjeta()
    {
        return $this->belongsTo(TarjetasRegalo::class, 'id_tarjeta');
    }
}