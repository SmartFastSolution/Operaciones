<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ProductosExport implements FromView
{
 	use Exportable;
    protected $productos;
    
    public function __construct($datos)
    {
        $this->productos = $datos;
    }
   

   public function view(): View
   {
             return view('Reportes.documento.productos',[
                 'productos' => $this->productos
             ]);
   }
}
