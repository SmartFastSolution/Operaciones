<?php

namespace App\Http\Controllers\Coordinador;

use App\Http\Controllers\Controller;
use App\Requerimiento;
use App\Sector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CoordinadorController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
    }
	public function index()
	{
    	 $atendidos = Requerimiento::where('user_id', Auth::id())->where('estado', 'ejecutado')->count();
        $pendiente = Requerimiento::where('user_id', Auth::id())->where('estado', 'pendiente')->count();
        $total = Requerimiento::where('user_id', Auth::id())->count();
        $requerimientos = Requerimiento::where('user_id', Auth::id())
                ->orderBy('id', 'asc')
                ->latest()
                ->take(5) 
                ->get(['id', 'codigo', 'cuenta', 'nombres']);
                // return $requerimientos;
        return view('coordinador.index', compact('atendidos', 'pendiente', 'total', 'requerimientos')); 
	}
    public function perfil()
    {
        $user = Auth::user();
        $sectores = Sector::where('estado', 'on')->get(['id', 'nombre']);
        // return $sectores;
        return view('perfil', compact('user', 'sectores'));
    }
    public function mapa()
    {
        return view('coordinador.mapa.index'); 
    }
     public function calendario()
    {
         $requerimientos = Requerimiento::select('fecha_maxima as date', 'estado', 'nombres as title', 'id')
                ->orderBy('requerimientos.created_at','desc')
                // ->whereDate('fecha_maxima', now())
                // ->where('user_id', Auth::id())
                ->get();
        // $requerimientos = Requerimiento::select('fecha_maxima as date', 'nombres as title')
        //         ->orderBy('created_at','desc')
        //         // ->whereDate('fecha_maxima', now())
        //         ->get();

                // return $requerimientos;
        return view('coordinador.calendario.index', compact('requerimientos')); 
    }
}
