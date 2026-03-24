<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imagenes extends Model
{
    use HasFactory;

    protected $table = 'imagenes';
    protected $primaryKey = 'id_imagen';

    protected $fillable = [
        'filename',
        'id_producto'
    ];

    public function producto()
    {
        return $this->belongsTo(Productos::class, 'id_producto', 'id_producto');
    }
}