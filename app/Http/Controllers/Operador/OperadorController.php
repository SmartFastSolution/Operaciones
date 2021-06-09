<?php

namespace App\Http\Controllers\Operador;

use App\Http\Controllers\Controller;
use App\Requerimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OperadorController extends Controller
{
   public function __construct()
    {
       $this->middleware('auth');
    }
	public function index()
	{
    	  $atendidos      = Requerimiento::where('operador_id', Auth::id())->where('estado', 'ejecutado')->count();
                $pendiente      = Requerimiento::where('operador_id', Auth::id())->where('estado', 'pendiente')->count();
                $total          = Requerimiento::where('operador_id', Auth::id())->count();
                $requerimientos = Requerimiento::where('operador_id', Auth::id())
                ->orderBy('id', 'asc')
                ->latest()
                ->take(5) 
                ->get(['id', 'codigo', 'cuenta', 'nombres']);
      return view('operador.index', compact('atendidos', 'pendiente', 'total', 'requerimientos'));  
	}
	    public function perfil()
    {
        $user = Auth::user();
        return view('operador.perfil.perfil', compact('user'));
    }
}
