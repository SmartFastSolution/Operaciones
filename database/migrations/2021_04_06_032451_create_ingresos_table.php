<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngresosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingresos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->nullable();
            $table->text('descripcion')->nullable();
            $table->float('total_ingreso', 10,3)->nullable();
            $table->timestamps();
        });

           Schema::create('ingreso_product', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ingreso_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('cantidad');
            $table->float('precio', 10,3);
            $table->float('total', 10,3);
            $table->foreign('ingreso_id')->references('id')->on('ingresos')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
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
        Schema::dropIfExists('ingreso_product');
        Schema::dropIfExists('ingresos');
    }
}
