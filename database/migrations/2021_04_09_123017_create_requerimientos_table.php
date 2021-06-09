<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequerimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requerimientos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->unsignedBigInteger('operador_id')->nullable();
            $table->foreign('operador_id')->references('id')->on('users')->onDelete('set null');
            $table->string('codigo', 100);
            $table->string('cuenta', 100)->nullable();
            $table->string('codigo_catastral')->nullable();
            $table->string('nombres');
            $table->text('telefonos');
            $table->text('correos');
            $table->text('direccion');
            $table->unsignedBigInteger('sector_id')->nullable();
            $table->foreign('sector_id')->references('id')->on('sectors')->onDelete('set null');
            $table->unsignedBigInteger('tipo_requerimiento_id')->nullable();
            $table->foreign('tipo_requerimiento_id')->references('id')->on('tipo_requerimientos')->onDelete('set null');
            $table->text('detalle');
            $table->string('cedula', 13);
            $table->longText('observacion')->nullable();
            $table->date('fecha_maxima');
            $table->double('latitud')->nullable();        
            $table->double('longitud')->nullable(); 
            $table->enum('estado',['ejecutado','pendiente','asignado'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requerimientos');
    }
}
