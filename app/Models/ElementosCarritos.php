<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ElementosCarritos extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_elemento_carrito';

    protected $fillable = ["id_carrito", "id_producto", "cantidad", "price"];

    public function producto()
    {  
        return $this->belongsTo(Productos::class, 'id_producto');
    }

    public function carrito()
    {  
        return $this->belongsTo(Carritos::class, 'id_carrito');
    }
}
