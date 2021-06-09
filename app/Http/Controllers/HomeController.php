<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $iconos = config('fonts-awesome.datos');
        return view('landing.index');
    }
     public function novedades()
    {
        // $iconos = config('fonts-awesome.datos');
        return view('landing.novedades');
    }
        public function calendario($id)
    {
      
      return redirect()->route('coordinador.requerimiento.show', $id); 
      
    }
    public function datos($id)
    {
        $coordinador =  User::with(['documentos', 'sector' => function($query){
            $query->select('id', 'nombre');
        }])->find($id);

        $imagenes = $coordinador->documentos->whereIn('extension',  ['png','jpeg', 'jpg'])->pluck('archivo');


  return response(array(
        'success'     => true,
        'coordinador' => $coordinador,
        'img'         => $imagenes,
    ),200,[]);
        // return $coordinador;
    }
}
