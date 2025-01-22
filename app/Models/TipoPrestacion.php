<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoPrestacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'estado',
        'descripcion',
    ];
    protected $table = 'tipo_prestaciones';
}
