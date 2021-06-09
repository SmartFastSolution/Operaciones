<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RequerimientoExport implements FromView
{
 	use Exportable;
    protected $requerimientos;
    
    public function __construct($requerimientos)
    {
        $this->requerimientos = $requerimientos;
    }
   

   public function view(): View
   {
             return view('Reportes.coordinador.requerimientos',[
                 'requerimientos' => $this->requerimientos
             ]);
   }
}
