<?php

namespace App\Http\Livewire\Coordinador\Producto;

use App\Egreso;
use App\Medida;
use App\Product;
use Livewire\Component;
use App\ConversionUnidad;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Exports\EgresosExport;
use Illuminate\Support\Facades\DB;
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
    public $conversiones         = [];
    public $medidas         = [];
    public function render()
    {

        $this->conversiones = ConversionUnidad::all(['id', 'medida_base', 'medida_conversion', 'factor']);
        $this->medidas = Medida::all(['id', 'unidad', 'simbolo']);

        $this->productos = Product::where('estado', 'on')->with(['medida' => function ($query) {
            $query->select('id', 'simbolo');
        }])->get();

        $egresos = Egreso::withcount(['productos' => function ($query) {
            $query->withTrashed();
        }])->where(function ($query) {
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
        DB::beginTransaction();
        try {
            $egreso = new Egreso;
            $egreso->codigo = $datos['codigo'];
            $egreso->descripcion = $datos['descripcion'];
            $egreso->total_egreso = $datos['total_egreso'];
            $egreso->save();
            $productos = $datos['items'];
            $relacion = [];
            foreach ($productos as $key => $producto) {
                $produc           = Product::find($producto['id']);
                $cantidad         = intval($produc->cantidad) - $producto['cantidad_base'];
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
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->emit('error', ['mensaje' => 'Esta accion no se puede realizar, ocurrio un error en el sistema']);
        }

        $this->emit('success', ['mensaje' => 'Egreso Creado Correctamente', 'modal' => '#crearEgreso']);
    }
    public function editarEgreso($id)
    {
        $this->egreso_id = $id;
        $egreso = Egreso::with(['productos' =>  function ($query) {
            $query->select('products.id', 'medida_id');
        }])->find($id);

        $data = array(
            "egreso" => $egreso,
            "items" => $egreso->productos,
        );

        $this->emit('editarEgreso', $data);
    }
    public function actualizarEgreso($datos)
    {
        DB::beginTransaction();
        try {
            $egreso = Egreso::with(['productos' =>  function ($query) {
                $query->select('products.id', 'medida_id');
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
            $egreso->total_egreso = number_format($datos['total_egreso'], 3);
            $egreso->save();

            $productos = $datos['items'];
            $relacion = [];

            foreach ($productos as $key => $producto) {
                $produc           = Product::find($producto['id']);
                $cantidad         = intval($produc->cantidad) - $producto['cantidad_base'];
                $stock            = $cantidad / $produc->presentacion;
                $produc->cantidad = $cantidad;
                $produc->stock    = $stock;
                $produc->save();

                $relacion[$producto['id']] = array(
                    "cantidad"      => $producto['cantidad_unidad'],
                    "cantidad_real" => $producto['cantidad_base'],
                    "total"         => number_format($producto['total'], 3),
                );
            }
            $egreso->productos()->sync($relacion);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->emit('error', ['mensaje' => 'Esta accion no se puede realizar, ocurrio un error en el sistema']);
        }
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
