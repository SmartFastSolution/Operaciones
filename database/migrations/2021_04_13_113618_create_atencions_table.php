<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAtencionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('atencions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('requerimiento_id')->nullable();
            $table->unsignedBigInteger('operador_id')->nullable();
            $table->unsignedBigInteger('coordinador_id')->nullable();
            $table->text('detalle');
            $table->longText('observacion');
            $table->date('fecha_atencion')->nullable();
            $table->float('distancia')->nullable();        
            $table->double('latitud')->nullable();        
            $table->double('longitud')->nullable(); 
            $table->foreign('operador_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('coordinador_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('requerimiento_id')->references('id')->on('requerimientos')->onDelete('set null');
            $table->timestamps();
        });
            Schema::table('egresos', function (Blueprint $table) {
            $table->unsignedBigInteger('atencion_id')->nullable();
            $table->foreign('atencion_id')->references('id')->on('atencions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('atencions');
    }
}
