<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuenta extends Model
{
    use HasFactory;
    protected $table = 'cuentas';
    protected $fillable = [
        'nombre',
        'direccion',
        'sucursal_id',
        'tipo_venta_id',
        'estado',
    ];

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }

    public function tipoVenta()
    {
        return $this->belongsTo(TipoVenta::class);
    }
    
}
