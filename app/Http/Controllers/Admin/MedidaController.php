<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Medida;
use Illuminate\Http\Request;

class MedidaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
    	// $medida = Medida::with(['conversiones', 'conversiones.medida'])->find(4);
    	// return $medida->conversiones[0]->medida->unidad;
        return view('admin.medidas.index');
    }
}
