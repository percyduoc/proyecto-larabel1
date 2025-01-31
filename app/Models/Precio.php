<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Precio extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_prestaciones',
        'valor',
        'fecha_desde',
        'fecha_hasta',
        'estado',
    ];

    public function prestaciones()
    {
        return $this->belongsTo(Prestacion::class, 'id_prestaciones');
    }



}
