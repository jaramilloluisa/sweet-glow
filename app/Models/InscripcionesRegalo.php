<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Usuarios;
use App\Models\FacturaPedidos;

class InscripcionRegalo extends Model
{
    use HasFactory;

    protected $table = 'inscripciones_regalo';

    protected $primaryKey = 'id_inscripcion';

    protected $fillable = [
        'estado',
        'id_usuario',
        'id_factura_pedido'
    ];

    public $timestamps = false;

    // Relación con usuarios
    public function usuario()
    {
        return $this->belongsTo(Usuarios::class, 'id_usuario');
    }

    // Relación con factura pedidos
    public function factura()
    {
        return $this->belongsTo(FacturaPedidos::class, 'id_factura_pedido');
    }
}