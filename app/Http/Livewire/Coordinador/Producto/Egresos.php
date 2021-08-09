<?php

namespace App\Http\Livewire\Coordinador\Producto;

use App\Egreso;
use App\Product;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Exports\EgresosExport;
use Maatwebsite\Excel\Facades\Excel;


class Egresos extends Component
{
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme              = 'bootstrap';
    protected $listeners                    = ['eliminarEgreso', 'guardarEgreso', 'actualizarEgreso'];
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
    public $codigo_ingreso, $descripcion_ingreso, $total_ingreso;
    public $producto_cantidad = 1, $producto_id = '', $producto_total, $producto_precio, $egreso_id;
    public $items             = [];
    public $productos         = [];
    public function render()
    {

        $this->productos = Product::where('estado', 'on')->with(['medida' => function ($query) {
            $query->select('id', 'simbolo');
        }])->get();

        $egresos = Egreso::withcount('productos')->where(function ($query) {
            $query->where('codigo', 'like', '%' . $this->search . '%')
                ->orWhere('descripcion', 'like', '%' . $this->search . '%')
                ->orWhere('total_egreso', 'like', '%' . $this->search . '%');
        })
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        return view('livewire.coordinador.producto.egresos', compact('egresos'));
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function guardarEgreso($datos)
    {
        $egreso = new Egreso;
        $egreso->codigo = $datos['codigo'];
        $egreso->descripcion = $datos['descripcion'];
        $egreso->total_egreso = $datos['total_egreso'];
        $egreso->save();

        $productos = $datos['items'];
        $relacion = [];
        foreach ($productos as $key => $producto) {
            $produc           = Product::find($producto['id']);
            $cantidad         = intval($produc->cantidad) - $producto['cantidad_unidad'];
            $stock            = $cantidad / $produc->presentacion;
            $produc->cantidad = $cantidad;
            $produc->stock    = $stock;
            $produc->save();

            $relacion[$producto['id']] = array(
                "cantidad"      => $producto['cantidad_unidad'],
                "cantidad_real" => $producto['cantidad_base'],
                "total"         => $producto['total'],
            );
        }
        $egreso->productos()->sync($relacion);

        $this->emit('success', ['mensaje' => 'Egreso Creado Correctamente', 'modal' => '#crearEgreso']);
    }
    public function editarEgreso($id)
    {
        $this->egreso_id = $id;
        $egreso = Egreso::with(['productos' =>  function ($query) {
            $query->select('products.id');
        }])->find($id);
        $data = array(
            "egreso" => $egreso,
            "items" => $egreso->productos,
        );

        $this->emit('editarEgreso', $data);
    }
    public function actualizarEgreso($datos)
    {
        $egreso = Egreso::with(['productos' =>  function ($query) {
            $query->select('products.id');
        }])->find($this->egreso_id);

        foreach ($egreso->productos as $key => $producto) {
            $produc           = Product::find($producto->id);
            $cantidad         = intval($produc->cantidad) + $producto->pivot->cantidad_real;
            $stock            = $cantidad / $produc->presentacion;
            $produc->cantidad = $cantidad;
            $produc->stock    = $stock;
            $produc->save();
        }

        $egreso->codigo       = $datos['codigo'];
        $egreso->descripcion  = $datos['descripcion'];
        $egreso->total_egreso = number_format($datos['total_egreso'], 2);
        $egreso->save();

        $productos = $datos['items'];
        $relacion = [];

        foreach ($productos as $key => $producto) {
            $produc           = Product::find($producto['id']);
            $cantidad         = intval($produc->cantidad) - $producto['cantidad_unidad'];
            $stock            = $cantidad / $produc->presentacion;
            $produc->cantidad = $cantidad;
            $produc->stock    = $stock;
            $produc->save();

            $relacion[$producto['id']] = array(
                "cantidad"      => $producto['cantidad_unidad'],
                "cantidad_real" => $producto['cantidad_base'],
                "total"         => number_format($producto['total'], 2),
            );
        }
        $egreso->productos()->sync($relacion);

        $this->emit('info', ['mensaje' => 'Egreso Actualizado Correctamente', 'modal' => '#crearEgreso']);
    }
    public function eliminarEgreso($id)
    {
        $egreso = Egreso::with(['productos' =>  function ($query) {
            $query->select('products.id');
        }])->find($id);

        foreach ($egreso->productos as $key => $producto) {
            $produc           = Product::find($producto->id);
            $cantidad         = intval($produc->cantidad) + $producto->pivot->cantidad_real;
            $stock            = $cantidad / $produc->presentacion;
            $produc->cantidad = $cantidad;
            $produc->stock    = $stock;
            $produc->save();
        }
        $egreso->delete();
    }
    public function generaExcel()
    {
        $egresos = Egreso::withcount('productos')->where(function ($query) {
            $query->where('codigo', 'like', '%' . $this->search . '%')
                ->orWhere('descripcion', 'like', '%' . $this->search . '%')
                ->orWhere('total_egreso', 'like', '%' . $this->search . '%');
        })
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->get();

        return Excel::download(new EgresosExport($egresos), 'egresos.xlsx');
    }
}
