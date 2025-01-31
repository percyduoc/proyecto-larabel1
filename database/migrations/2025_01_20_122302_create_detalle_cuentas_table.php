<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('detalle_cuentas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_cuenta')->constrained('cuentas')->onDelete('cascade');
            $table->string('id_prestaciones');
            $table->integer('cantidad_producto');
            $table->integer('valor_producto');
            $table->boolean('estado')->default(true); // Activo por defecto
            $table->timestamps();

            // Definimos la clave foránea con el prefijo correcto
            $table->foreign('id_prestaciones')
                ->references('codigo')
                ->on('prestaciones')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_cuentas');
    }
};
