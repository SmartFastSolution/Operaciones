<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoRequerimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_requerimientos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('parametrizacion');
            $table->string('descripcion')->nullable();
            $table->enum('estado',['on','off'])->nullable();
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
        Schema::dropIfExists('tipo_requerimientos');
    }
}
