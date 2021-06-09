<?php

namespace App\Http\Controllers\Coordinador;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;

class EgresoController extends Controller
{
    public function productos()
    {
    	$productos = Product::where('estado', 'on')->with(['medida' => function($query) {
    	            $query->select('id', 'simbolo');
    	        }])->get();
    }
}
