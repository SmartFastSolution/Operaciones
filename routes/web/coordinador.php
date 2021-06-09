<?php

use Illuminate\Support\Facades\Route;
Route::prefix('coordinador')->group(function() {
    Route::group(['middleware' => ['role:coordinador']], function () {
        Route::get('/', 'Coordinador\CoordinadorController@index')->name('coordinador.index');
        Route::get('/perfil', 'Coordinador\CoordinadorController@perfil')->name('coordinador.perfil.me');
        Route::get('/mapa', 'Coordinador\CoordinadorController@mapa')->name('coordinador.mapa');
        Route::get('/calendario', 'Coordinador\CoordinadorController@calendario')->name('coordinador.calendario');
        Route::get('/productos', 'Coordinador\ProductoController@index')->name('coordinador.producto.index');
        Route::get('/productos/ingresos', 'Coordinador\ProductoController@ingresos')->name('coordinador.producto.ingreso');
        Route::get('/productos/ingresos/{id}', 'Coordinador\ProductoController@ingresoShow')->name('coordinador.producto.ingresoshow');
        Route::get('/productos/egresos', 'Coordinador\ProductoController@egresos')->name('coordinador.producto.egreso');
        Route::get('/productos/egresos/{id}', 'Coordinador\ProductoController@egresoShow')->name('coordinador.producto.egresoshow');
        Route::get('/productos/{id}', 'Coordinador\ProductoController@show')->name('coordinador.producto.show');
        Route::get('/requerimientos', 'Coordinador\RequerimientoController@index')->name('coordinador.requerimiento.index');
        Route::get('/requerimientos/asignacion', 'Coordinador\RequerimientoController@asignacion')->name('coordinador.requerimiento.asignar');
        Route::get('/requerimiento/{id}', 'Coordinador\RequerimientoController@show')->name('coordinador.requerimiento.show');
        Route::get('/requerimiento/{id}/informacion', 'Coordinador\RequerimientoController@datos')->name('coordinador.requerimiento.datos');
        // Route::get('/requerimiento/{id}/atencion', 'Coordinador\RequerimientoController@show')->name('coordinador.requerimiento.atencion');

        Route::get('/requerimiento/{id}/atencion', 'Coordinador\RequerimientoController@atencion')->name('coordinador.requerimiento.atencion');
        Route::post('/requerimiento/{id}/atencion', 'Coordinador\RequerimientoController@store')->name('coordinador.requerimiento.store');
        Route::get('/requerimiento/{id}/atencion/{atencion}/edit', 'Coordinador\RequerimientoController@edit')->name('coordinador.requerimiento.edit');
        Route::post('/requerimiento/{id}/atencion/{atencion}/update', 'Coordinador\RequerimientoController@update')->name('coordinador.requerimiento.update');



    });
});