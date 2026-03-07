<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Premiados extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_premiado';

    protected $fillable = [
        'id_premio',
        'id_usuario',
        'id_inscripcion'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuarios::class, 'id_usuario', 'id_usuario');
    }

    public function premio()
    {
        return $this->belongsTo(Premio::class, 'id_premio', 'id_premio');
    }

    public function inscripcion()
    {
        return $this->belongsTo(InscripcionesRegalo::class, 'id_inscripcion', 'id_inscripcion');
    }
}
