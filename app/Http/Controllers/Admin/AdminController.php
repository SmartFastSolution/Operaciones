<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Requerimiento;
use App\Sector;
use App\TipoRequerimiento;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
    }
    public function index()
    {
        $usuarios      = User::count();
        $activos       = User::where('estado', 'on')->count();
        $coordinadores = User::role('coordinador')->where('estado', 'on')->count();
        $operadores = User::role('operador')->where('estado', 'on')->count();
        $operadoresmas = User::withcount(['requerimientos' => function($query){ $query->where('estado', 'ejecutado'); }])->role('operador')->orderBy('requerimientos_count','desc')->get()->take(5);
        $atendidos     = Requerimiento::where('estado', 'ejecutado')->count();
        $pendiente     = Requerimiento::where('estado', 'pendiente')->count();
        $total         = Requerimiento::count();
        $tipos         = TipoRequerimiento::withcount('requerimientos')->orderBy('requerimientos_count','desc')->get()->take(3);
        $sectores      = Sector::withcount('requerimientos')->orderBy('requerimientos_count','desc')->get()->take(3);
        // return $operadoresmas;
        // $requerimientos = Requerimiento::orderBy('id', 'asc')
        //         ->latest()
        //         ->take(5) 
        //         ->get(['id', 'codigo', 'cuenta', 'nombres']);
        return view('admin.index',  compact('atendidos', 'pendiente', 'total', 'usuarios', 'activos', 'tipos', 'sectores', 'coordinadores', 'operadores','operadoresmas')); 
    }
    public function perfil()
    {
        $user = Auth::user();
        return view('admin.users.perfil', compact('user'));
    }
}
