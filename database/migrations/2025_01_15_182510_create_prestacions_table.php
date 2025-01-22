<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration

{
    public function up()
    {
        Schema::create('prestaciones', function (Blueprint $table) {
            $table->string('codigo')->primary();
            $table->string('nombre', 255);
            $table->foreignId('tipo_prestacion_id')->constrained('tipo_prestaciones')->onDelete('cascade');
            $table->integer('valor');
            $table->boolean('estado')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('prestaciones');
    }
};
