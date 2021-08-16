<?php

namespace App\Http\Livewire\Coordinador\Producto;

use App\Ingreso;
use App\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;

class Ingresos extends Component
{
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme              = 'bootstrap';
    protected $listeners                    = ['eliminarIngreso'];
    protected $queryString                  = [
        'search' => ['except' => ''],
        'page'
    ];
    public $perPage           = 10;
    public $search            = '';
    public $orderBy           = 'id';
    public $orderAsc          = true;
    public $status            = true;
    public $porcentual        = false;
    public $estado            = 'on';
    public $unidad            = '';
    public $editMode          = false;
    public $exportando        = false;
    public $codigo_ingreso, $descripcion_ingreso, $total_ingreso, $ingreso_id;
    public $producto_cantidad = 1, $producto_id = '', $producto_total, $producto_precio;
    public $items             = [];
    public $productos         = [];
    public function render()
    {

        $this->productos = Product::with(['medida' => function ($query) {
            $query->select('id', 'simbolo');
        }])->select('id', 'nombre', 'stock', 'cantidad', 'presentacion', 'iva', 'porcentual', 'precio_venta', 'medida_id')->where('estado', 'on')->get();

        $ingresos = Ingreso::where(function ($query) {
            $query->where('codigo', 'like', '%' . $this->search . '%')
                ->orWhere('descripcion', 'like', '%' . $this->search . '%')
                ->orWhere('total_ingreso', 'like', '%' . $this->search . '%');
        })
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);

        return view('livewire.coordinador.producto.ingresos', compact('ingresos'));
    }
    public function agregarItem()
    {
        $collection = collect($this->items);
        if ($collection->firstWhere('id', $this->producto_id)) {
            $this->producto_total = ($this->producto_precio * $this->producto_cantidad);

            $this->items[$this->producto_id]['cantidad'] = $this->items[$this->producto_id]['cantidad'] + $this->producto_cantidad;
            $this->items[$this->producto_id]['total']    = $this->items[$this->producto_id]['total'] + $this->producto_total;
        } else {
            $producto = Product::find($this->producto_id);
            $this->producto_total = ($this->producto_precio * $this->producto_cantidad);
            $item = array(
                "id"       => $producto->id,
                "nombre"   => $producto->nombre,
                "cantidad" => $this->producto_cantidad,
                "precio"   => $this->producto_precio,
                "total"    => $this->producto_total,
            );
            $this->items[$producto->id] = $item;
        }
    }
    public function updatingSearch()
    {
        $this->resetPage();
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
            'items'       => 'required|array|min:1',
            'total_ingreso'       => 'required',
        ], [
            'codigo_ingreso.required'      => 'No has agregado el codigo',
            'descripcion_ingreso.required' => 'No has agregado la descripcion',
            'total_ingreso.required'       => 'No has agregado el total',
            'items.required'       => 'No has seleccionado un producto',
            'items.min'       => 'Debes tener minimo un producto',
        ]);
        $this->exportando = true;
        $ingreso                = new Ingreso;
        $ingreso->codigo        = $this->codigo_ingreso;
        $ingreso->descripcion   = $this->descripcion_ingreso;
        $ingreso->total_ingreso = $this->total_ingreso;
        $ingreso->save();
        $relacion = [];
        foreach ($this->items as $key => $item) {
            $producto = Product::find($item['id']);
            $producto->stock = $producto->stock + $item['cantidad'];
            $producto->cantidad = $producto->cantidad + ($item['cantidad'] * $producto->presentacion);
            $producto->save();
            $relacion[$item['id']] = array(
                'cantidad' => $item['cantidad'],
                'precio' => $item['precio'],
                'total'    => $item['total']
            );
        }
        $ingreso->productos()->sync($relacion);

        $this->emit('success', ['mensaje' => 'Ingreso Generado Correctamente', 'modal' => '#crearIngreso']);
        $this->exportando = false;
        $this->resetInput();
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
        $this->exportando          = false;
        $this->editMode            = false;
        $this->items               = [];
        $this->emit('reset');
    }
    public function editIngreso($id)
    {
        $this->ingreso_id = $id;
        $ingreso = Ingreso::with(['productos' =>  function ($query) {
            $query->select('products.id', 'products.nombre');
        }])->find($id);

        $this->codigo_ingreso      = $ingreso->codigo;
        $this->descripcion_ingreso = $ingreso->descripcion;
        $this->total_ingreso       = $ingreso->total_ingreso;

        $items = [];
        foreach ($ingreso->productos as $key => $producto) {
            $item = array(
                "id"       => $producto->id,
                "nombre"   => $producto->nombre,
                "cantidad" => $producto->pivot->cantidad,
                "precio"   => $producto->pivot->precio,
                "total"    => $producto->pivot->total,
            );

            $items[] = $item;
        }
        $this->editMode = true;

        $this->emit('edit', ['codigo_ingreso' => $ingreso->codigo, 'descripcion_ingreso' => $ingreso->descripcion, 'total_ingreso' => $ingreso->total_ingreso, 'items' => $items]);
    }
    public function updateIngreso()
    {
        $this->validate([
            'codigo_ingreso'      => 'required',
            'descripcion_ingreso' => 'required',
            'total_ingreso'       => 'required',
            'items'       => 'required|array|min:1',
        ], [
            'codigo_ingreso.required'      => 'No has agregado el codigo',
            'descripcion_ingreso.required' => 'No has agregado la descripcion',
            'total_ingreso.required'       => 'No has agregado el total
			',
        ]);
        $this->exportando = true;
        DB::beginTransaction();
        try {
            $ingreso = Ingreso::with(['productos'])->find($this->ingreso_id);
            $ingreso->codigo        = $this->codigo_ingreso;
            $ingreso->descripcion   = $this->descripcion_ingreso;
            $ingreso->total_ingreso = $this->total_ingreso;
            foreach ($ingreso->productos as $key => $producto) {
                $prod = Product::find($producto->id);
                if (($prod->stock - $producto->pivot->cantidad) < 0) {
                    $this->exportando = false;
                    throw new \Exception();
                    // return   $this->emit('warning', ['mensaje' => 'Esta accion no se puede realizar, ya que tu stock quedaria menor a 0']);
                }
                $prod->stock = $prod->stock - $producto->pivot->cantidad;
                $prod->cantidad = $prod->cantidad - ($producto->pivot->cantidad * $prod->presentacion);
                $prod->save();
            }
            $relacion = [];
            foreach ($this->items as $key => $item) {
                $producto = Product::find($item['id']);
                $producto->stock = $producto->stock + $item['cantidad'];
                $producto->cantidad = $producto->cantidad + ($item['cantidad'] * $producto->presentacion);
                $producto->save();
                $relacion[$item['id']] = array(
                    'cantidad' => $item['cantidad'],
                    'precio' => $item['precio'],
                    'total'    => $item['total']
                );
            }
            $ingreso->save();
            DB::commit();
            $ingreso->productos()->sync($relacion);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->emit('error', ['mensaje' => 'Esta accion no se puede realizar, ya que tu stock quedaria menor a 0']);
        }

        $this->emit('info', ['mensaje' => 'Ingreso Actualizado Correctamente', 'modal' => '#crearIngreso']);
        $this->exportando = false;
        $this->editMode = false;
        $this->resetInput();
    }
    public function eliminarItem($index)
    {
        unset($this->items[$index]);
    }
    public function eliminarIngreso($id)
    {

        $ingreso = Ingreso::with(['productos'])->find($id);
        foreach ($ingreso->productos as $key => $producto) {
            $prod = Product::find($producto->id);
            if (($prod->stock - $producto->pivot->cantidad) < 0) {
                return   $this->emit('warning', ['mensaje' => 'Esta accion no se puede realizar, ya que tu stock quedaria menor a 0']);
            }
            $prod->stock = $prod->stock - $producto->pivot->cantidad;
            $prod->cantidad = $prod->cantidad - ($producto->pivot->cantidad * $prod->presentacion);
            $prod->save();
        }
        $ingreso->delete();
        $this->emit('info', ['mensaje' => 'Ingreso Eliminado Correctamente']);
    }
}
