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
        'id_producto',
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
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto', 'codigo');
    }
}
