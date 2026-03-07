<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carritos extends Model
{
    use HasFactory;

    protected $table = 'carritos';

    protected $primaryKey = 'id_carrito';

    protected $fillable = [
        'id_usuario',
        'cantidad',
        'descuento',
        'id_producto',
        'id_factura_pedido',
        'id_tarjeta'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuarios::class, 'id_usuario', 'id_usuario');
    }

    public function producto()
    {
        return $this->belongsTo(Productos::class, 'id_producto', 'id_producto');
    }

    public function facturaPedido()
    {
        return $this->belongsTo(FacturaPedidos::class, 'id_factura_pedido', 'id_factura_pedido');
    }

    public function tarjetaRegalo()
    {
        return $this->belongsTo(TarjetasRegalo::class, 'id_tarjeta', 'id_tarjeta');
    }
}
