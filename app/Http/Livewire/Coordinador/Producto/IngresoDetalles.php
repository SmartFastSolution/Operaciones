<?php

namespace App\Http\Livewire\Coordinador\Producto;

use App\Ingreso;
use Livewire\Component;

class IngresoDetalles extends Component
{
    public $ingreso_id;
    public $ingreso;
    public function mount($id)
    {
        $this->ingreso_id = $id;
    }
    public function render()
    {
        $this->ingreso = Ingreso::with(['productos' => function ($query) {
            $query->withTrashed();
        }])->find($this->ingreso_id);
        return view('livewire.coordinador.producto.ingreso-detalles');
    }
}
