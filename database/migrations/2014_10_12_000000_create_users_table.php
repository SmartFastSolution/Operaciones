<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cedula')->unique();
            $table->string('username')->unique();
            $table->string('nombres');
            $table->string('domicilio')->nullable();
            $table->unsignedBigInteger('sector_id')->nullable();
            $table->string('telefono')->nullable();
            $table->string('celular')->nullable();
            $table->string('email')->unique();
            $table->string('password');    
            $table->text('actividad_personal')->nullable();
            $table->text('detalle_actividad')->nullable();    
            $table->string('horario_atencion')->nullable();
            $table->string('avatar')->nullable();
            $table->double('latitud')->nullable();        
            $table->double('longitud')->nullable();        
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('activated_at')->nullable();
            $table->timestamp('access_at')->nullable();
            $table->enum('estado',['on','off'])->nullable();
            $table->foreign('sector_id')->references('id')->on('sectors')->onDelete('set null');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
