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
            'neto',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuarios::class, 'id_usuario', 'id_usuario');
    }
}