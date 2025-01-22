<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestacion extends Model
{
    use HasFactory;

    protected $primaryKey = 'codigo';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'prestaciones';
    protected $fillable = [
        'codigo',
        'nombre',
        'tipo_prestacion_id',
        'valor',
        'estado',
    ];

    public function tipoPrestacion()
    {
        return $this->belongsTo(TipoPrestacion::class);
    }
}
