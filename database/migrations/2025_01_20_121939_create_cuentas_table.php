<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cuentas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 255);
            $table->string('direccion', 255);
            $table->foreignId('sucursal_id')->constrained('sucursals')->onDelete('cascade');
            $table->foreignId('tipo_venta_id')->constrained('tipo_ventas')->onDelete('cascade');
            $table->boolean('estado')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cuentas');
    }
};
