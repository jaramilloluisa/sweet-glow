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
        'status',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuarios::class, 'id_usuario');
    }

    public function elementos()
    {
        return $this->hasMany(ElementosCarritos::class, 'id_carrito', 'id_carrito');
    }
}
