<?php

namespace App\Http\Controllers\Coordinador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
    }
	public function index()
	{
    	return view('coordinador.productos.index');	
	}
	public function show()
	{
    	return view('coordinador.productos.index');	
	}
	public function ingresos()
	{
    	return view('coordinador.productos.ingreso');	
	}
	public function egresos()
	{
    	return view('coordinador.productos.egreso');	
	}
	public function ingresoShow($id)
	{
    	return view('coordinador.productos.ingreso-detalles', compact('id'));	
	}
}
