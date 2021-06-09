<?php

namespace App\Http\Livewire\Coordinador\Producto;

use App\Egreso;
use Livewire\Component;

class EgresoDetalles extends Component
{	
	public $egreso_id;
	public $egreso;
	public function mount($id)
	{
		$this->egreso_id = $id;
	}
    public function render()
    {
    	$this->egreso = Egreso::with('productos')->find($this->egreso_id);

        return view('livewire.coordinador.producto.egreso-detalles');
    }
}
