<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class EgresosExport implements FromView
{
	use Exportable;
    protected $egresos;
    
    public function __construct($datos)
    {
        $this->egresos = $datos;
    }
   

   public function view(): View
   {
             return view('Reportes.documento.egresos',[
                 'egresos' => $this->egresos
             ]);
   }
}
