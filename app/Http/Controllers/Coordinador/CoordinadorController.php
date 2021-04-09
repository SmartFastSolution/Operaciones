<?php

namespace App\Http\Controllers\Coordinador;

use App\Http\Controllers\Controller;
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
    	return view('admin.index');	
	}
    public function perfil()
    {
        $user = Auth::user();
        return view('perfil', compact('user'));
    }
}
