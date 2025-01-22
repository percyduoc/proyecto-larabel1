<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    use HasFactory;
    protected $table = 'sucursals';

    protected $fillable = [
        'nombre', 
        'region', 
        'descripcion',
        'estado'
    ];


    public function cuentas()
    {
        return $this->hasMany(Cuenta::class);
    }
}
