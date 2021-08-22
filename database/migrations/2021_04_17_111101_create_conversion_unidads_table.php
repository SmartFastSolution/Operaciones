<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConversionUnidadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conversion_unidads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('medida_base');
            $table->unsignedBigInteger('medida_conversion');
            $table->float('factor', 20, 8);
            $table->enum('accion', ['multiplicar', 'dividir'])->nullable();
            $table->foreign('medida_base')->references('id')->on('medidas')->onDelete('cascade');
            $table->foreign('medida_conversion')->references('id')->on('medidas')->onDelete('cascade');
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
        Schema::dropIfExists('conversion_unidads');
    }
}
