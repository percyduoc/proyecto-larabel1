<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Precio extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_producto',
        'id_prestacion',
        'valor',
        'fecha_desde',
        'fecha_hasta',
        'estado',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto', 'codigo');
    }

    public function prestacion()
    {
        return $this->belongsTo(Prestacion::class, 'id_prestacion', 'codigo');
    }
}
