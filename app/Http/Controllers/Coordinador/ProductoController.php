<?php

namespace App\Http\Controllers\Coordinador;

use App\ConversionUnidad;
use App\Egreso;
use App\Http\Controllers\Controller;
use App\Ingreso;
use App\Medida;
use App\Product;
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
    public function show($id)
    {
        $producto = Product::findOrFail($id, ['id', 'nombre']);
        return view('coordinador.productos.producto-detalles', compact('id', 'producto'));
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
        $ingreso = Ingreso::findOrFail($id);
        return view('coordinador.productos.ingreso-detalles', compact('id'));
    }
    public function egresoShow($id)
    {
        $egreso = Egreso::findOrFail($id);

        return view('coordinador.productos.egreso-detalles', compact('id', 'egreso'));
    }
}
