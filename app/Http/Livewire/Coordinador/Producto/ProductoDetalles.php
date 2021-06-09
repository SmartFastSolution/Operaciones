<?php

namespace App\Http\Livewire\Coordinador\Producto;

use App\Product;
use Livewire\Component;

class ProductoDetalles extends Component
{
	public $producto_id;
	public $producto;
	public function mount($id)
	{
		$this->producto_id = $id;
	}
    public function render()
    {
    	$this->producto = Product::with(['ingresos', 'egresos'])->find($this->producto_id);
    	// dd($this->producto);

        return view('livewire.coordinador.producto.producto-detalles');
    }
}
