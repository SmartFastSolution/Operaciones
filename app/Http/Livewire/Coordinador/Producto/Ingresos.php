<?php

namespace App\Http\Livewire\Coordinador\Producto;

use App\Ingreso;
use App\Product;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Ingresos extends Component
{
	use WithPagination;
	use WithFileUploads;
	protected $paginationTheme              = 'bootstrap';
	protected $listeners                    = ['eliminarUser'];
	protected $queryString                  =['search' => ['except' => ''],
	'page'
	];
	public $perPage           = 10;
	public $search            = '';
	public $orderBy           = 'id';
	public $orderAsc          = true;
	public $status            = true;
	public $porcentual        = false;
	public $estado            ='on';
	public $unidad            ='';
	public $editMode          = false;
	public $exportando        = false;
	public $codigo_ingreso, $descripcion_ingreso, $total_ingreso;
	public $producto_cantidad = 1, $producto_id = '', $producto_total, $producto_precio;
	public $items             = [];
	public $productos         = [];
    public function render()
    {
    	$this->productos = Product::with('medida')->get();
    	$ingresos = Ingreso::where(function ($query) {
                    $query->where('codigo', 'like', '%'.$this->search.'%')
                        ->orWhere('descripcion', 'like', '%'.$this->search.'%')
                        ->orWhere('total_ingreso', 'like', '%'.$this->search.'%');
                 	})
                ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
                ->paginate($this->perPage); 

        return view('livewire.coordinador.producto.ingresos', compact('ingresos'));
    }
    public function agregarItem()
    {
		$collection = collect($this->items);
		if ($collection->firstWhere('id', $this->producto_id)){
    		$this->producto_total = ($this->producto_precio * $this->producto_cantidad);

			$this->items[$this->producto_id]['cantidad'] = $this->items[$this->producto_id]['cantidad'] + $this->producto_cantidad;
			$this->items[$this->producto_id]['total']    = $this->items[$this->producto_id]['total'] + $this->producto_total;
		}else{
			$producto = Product::find($this->producto_id);
    		$this->producto_total = ($this->producto_precio * $this->producto_cantidad);
	    	$item = array(
				"id"       => $producto->id,
				"nombre"   => $producto->nombre,
				"cantidad" => $this->producto_cantidad,
				"precio"   => $this->producto_precio,
				"total"    => $this->producto_total,
	    		);
    		$this->items[$producto->id] =$item;
		}
    }
    public function changeCantidad($index)
    {
    	$suma = $this->items[$index]['cantidad'] * $this->items[$index]['precio'];
		$this->items[$index]['total'] = $suma;


    }
        public function incrementar($index)
    {
    	$this->items[$index]['cantidad'] = $this->items[$index]['cantidad'] + 1;

    	$suma = $this->items[$index]['cantidad'] * $this->items[$index]['precio'];
		$this->items[$index]['total'] = $suma;
    }
            public function decrementar($index)
    {
    	$this->items[$index]['cantidad'] = $this->items[$index]['cantidad'] - 1;

    	$suma = $this->items[$index]['cantidad'] * $this->items[$index]['precio'];
		$this->items[$index]['total'] = $suma;
    }
    public function generarIngreso()
    {
    	$this->validate([
			'codigo_ingreso'      => 'required',
			'descripcion_ingreso' => 'required',
			'total_ingreso'       => 'required',
        ],[
			'codigo_ingreso.required'      => 'No has agregado el codigo',
			'descripcion_ingreso.required' => 'No has agregado la descripcion',
			'total_ingreso.required'       => 'No has agregado el total
			',
    	]);  
    	$this->exportando = true; 


		$ingreso                = new Ingreso;
		$ingreso->codigo        = $this->codigo_ingreso;
		$ingreso->descripcion   = $this->descripcion_ingreso;
		$ingreso->total_ingreso = $this->total_ingreso;
		$ingreso->save();

		$relacion = [];
	    	foreach ($this->items as $key => $item) {
	    		$producto = Product::find($key);
	    		$producto->stock = $producto->stock + $item['cantidad'];
	    		$producto->save();
	      		$relacion[$key] = array(
					'cantidad' => $item['cantidad'],
					'total'    => $item['total']
	      );
    	}
    	$ingreso->productos()->sync($relacion);

        $this->emit('success',['mensaje' => 'Ingreso Generado Correctamente', 'modal' => '#crearIngreso']); 
    	$this->exportando = false; 


    }
    public function resetInput()
    {
		$this->codigo_ingreso      = null;
		$this->descripcion_ingreso = null;
		$this->total_ingreso       = null;
		$this->producto_cantidad   = null;
		$this->producto_id         = '';
		$this->producto_precio     = null;
		$this->producto_total      = null;
		$this->items               = [];
    }
}
