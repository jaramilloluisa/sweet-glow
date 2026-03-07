<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resena extends Model
{
    use HasFactory;

    protected $table = 'resenas';

    protected $primaryKey = 'id_resena';

    protected $fillable = [
        'resena',
        'id_producto',
        'id_usuario'
    ];

    public function producto()
    {
        return $this->belongsTo(Productos::class, 'id_producto');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuarios::class, 'id_usuario');
    }
}