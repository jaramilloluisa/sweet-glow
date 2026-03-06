<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class TarjetasRegalo extends Model
{
    // Tabla asociada
    protected $table = 'tarjetas_regalo';

    // Clave primaria personalizada
    protected $primaryKey = 'id_tarjeta';

    // Timestamps automáticos (created_at / updated_at)
    public $timestamps = true;

    // Asignación masiva
    protected $fillable = [
        'monto',
        'fecha_expiracion',
        'fecha_de_uso',
        'estado',
        'id_usuario'
    ];

    // Conversión automática de fechas
    protected $dates = [
        'fecha_creacion',
        'fecha_expiracion',
        'fecha_de_uso',
        'created_at',
        'updated_at'
    ];

    // Relación con el usuario
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuarios::class, 'id_usuario', 'id_usuario');
    }

    // Función de ayuda para marcar la tarjeta como usada
    public function usar()
    {
        if ($this->estado !== 'activa') {
            throw new \Exception('La tarjeta no está activa');
        }

        $this->estado = 'usada';
        $this->fecha_de_uso = Carbon::now();
        $this->save();
    }
}