<?php
use Illuminate\Support\Facades\Route;
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