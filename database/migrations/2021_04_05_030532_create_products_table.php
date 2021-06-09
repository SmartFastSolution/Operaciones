<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('medida_id')->nullable();
            $table->string('nombre')->nullable();
            $table->float('presentacion')->nullable();
            $table->float('precio_compra')->nullable();
            $table->float('precio_venta')->nullable();
            $table->boolean('porcentual')->nullable();
            $table->integer('iva')->nullable();
            $table->float('stock', 10,2)->nullable()->default(0);
            $table->float('cantidad')->nullable()->default(0);
            $table->string('cuenta_contable')->nullable();
            $table->string('foto')->nullable();
            $table->enum('estado',['on','off'])->nullable();
            $table->timestamps();
            $table->foreign('medida_id')->references('id')->on('medidas')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
