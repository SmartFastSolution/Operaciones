<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/home', 'HomeController@index')->name('index');
Route::prefix('admin')->group(function () {
	Route::group(['middleware' => ['role:super-admin|admin']], function () {
    	Route::get('/', 'Admin\AdminController@index')->name('admin.index');
    	Route::get('/perfil', 'Admin\AdminController@perfil')->name('admin.perfil.me');
		Route::get('/usuarios', 'Admin\UserController@index')->name('usuario.index');
		Route::get('/sectores', 'Admin\SectorController@index')->name('sector.index');
        Route::get('/unidades-de-medidas', 'Admin\MedidaController@index')->name('medida.index');
		Route::get('/tipos-de-requerimiento', 'Admin\TipoRequerimientoController@index')->name('tipo-requerimiento.index');
	});
});

Route::prefix('coordinador')->group(function() {
	Route::group(['middleware' => ['role:coordinador']], function () {
    	Route::get('/', 'Coordinador\CoordinadorController@index')->name('coordinador.index');
    	Route::get('/perfil', 'Coordinador\CoordinadorController@perfil')->name('coordinador.perfil.me');
        Route::get('/productos', 'Coordinador\ProductoController@index')->name('coordinador.producto.index');
        Route::get('/productos/ingresos', 'Coordinador\ProductoController@ingresos')->name('coordinador.producto.ingreso');
        Route::get('/productos/{id}', 'Coordinador\ProductoController@show')->name('coordinador.producto.show');
    	Route::get('/productos/ingresos/{id}', 'Coordinador\ProductoController@ingresoShow')->name('coordinador.producto.ingresoshow');
        Route::get('/productos/egresos', 'Coordinador\ProductoController@egresos')->name('coordinador.producto.egreso');
    	Route::get('/productos/egresos/{id}', 'Coordinador\ProductoController@egresos')->name('coordinador.producto.egresoshow');
	});
});