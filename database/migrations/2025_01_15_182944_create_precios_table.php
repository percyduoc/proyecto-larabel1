<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('precios', function (Blueprint $table) {
            $table->id();
            $table->string('id_prestaciones');
            $table->integer('valor');
            $table->date('fecha_desde');
            $table->date('fecha_hasta')->nullable();
            $table->boolean('estado')->default(true);
            $table->timestamps();

            // Relaciones
            $table->foreign('id_prestaciones')->references('codigo')->on('prestaciones')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('precios');
    }
};
