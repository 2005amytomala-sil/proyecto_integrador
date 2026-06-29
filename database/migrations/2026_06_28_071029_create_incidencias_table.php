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
        Schema::create('incidencias', function (Blueprint $table) {
            $table->id();

            $table->foreignId('ciudadano_id')->constrained('users')->restrictOnDelete();
            $table->foreignId('ciudad_id')->constrained('ciudades')->restrictOnDelete();
            $table->foreignId('tipo_incidencia_id')->constrained('tipos_incidencia')->restrictOnDelete();
            $table->foreignId('subtipo_incidencia_id')->constrained('subtipos_incidencia')->restrictOnDelete();
            $table->foreignId('estado_id')->constrained('estados')->restrictOnDelete();
            $table->foreignId('prioridad_id')->constrained('prioridades')->restrictOnDelete();
            $table->string('titulo', 150);
            $table->text('descripcion');
            $table->decimal('latitud', 10, 8)->nullable();
            $table->decimal('longitud', 11, 8)->nullable();
            $table->timestamp('fecha_resolucion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidencias');
    }
};
