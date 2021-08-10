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
            // ->orderBy('id', 'asc')
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
        $fechas = Requerimiento::where('user_id', Auth::id())->where('estado', 'pendiente')->pluck('fecha_maxima')->unique();
        $requerimientos = collect();
        foreach ($fechas as $fecha) {
            $filtros = Requerimiento::select('fecha_maxima as date', 'estado', 'nombres as title', 'id')
                ->where('user_id', Auth::id())
                ->whereDate('fecha_maxima', $fecha)
                ->orderBy('requerimientos.created_at', 'desc')
                // ->where('user_id', Auth::id())
                ->take(20)
                ->get();
            foreach ($filtros as $key => $fl) {
                $requerimientos->push($fl);
            }
        }
        // $requerimientos = Requerimiento::select('fecha_maxima as date', 'estado', 'nombres as title', 'id')
        //     ->where('user_id', Auth::id())
        //     ->orderBy('requerimientos.created_at', 'desc')
        //     // ->whereDate('fecha_maxima', now())
        //     // ->where('user_id', Auth::id())
        //     ->take(500)
        //     ->get();
        // $requerimientos = Requerimiento::select('fecha_maxima as date', 'nombres as title')
        //         ->orderBy('created_at','desc')
        //         // ->whereDate('fecha_maxima', now())
        //         ->get();

        // return $collection;
        return view('coordinador.calendario.index', compact('requerimientos'));
    }
}
