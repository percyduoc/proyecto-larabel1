<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleCuenta extends Model
{
    use HasFactory;

    protected $table = 'detalle_cuentas';

    protected $fillable = [
        'id_cuenta',
        'id_prestaciones',
        'cantidad_producto',
        'valor_producto',
        'estado',
    ];

    /**
     * Relación con el modelo Cuenta.
     */
    public function cuenta()
    {
        return $this->belongsTo(Cuenta::class, 'id_cuenta');
    }

    /**
     * Relación con el modelo Producto.
     */
    public function prestacion()
    {
        return $this->belongsTo(Prestacion::class, 'id_prestaciones', 'codigo');
    }
    public function tipoPrestacion()
    {
        return $this->hasOneThrough(
            TipoPrestacion::class,
            Prestacion::class,
            'codigo',              // Clave f en Prestacion.
            'id',                  // Clave pri en TipoPrestacion.
            'id_prestaciones',     // Clave f en DetalleCuenta.
            'tipo_prestacion_id'   // Clave f en Prestacion.
        );
    }
}
