<?php

namespace App\Http\Livewire\Coordinador\Producto;

use App\Medida;
use App\Product;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Exports\ProductosExport;
use Maatwebsite\Excel\Facades\Excel;

class Productos extends Component
{
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    protected $listeners       = ['eliminarProducto'];
    protected $queryString     =
    [
        'search' => ['except' => ''],
        'page'
    ];
    public $perPage    = 10;
    public $search     = '';
    public $orderBy    = 'products.id';
    public $orderAsc   = true;
    public $status     = true;
    public $statu    = '';
    public $porcentual = false;
    public $estado     = 'on';
    public $unidad     = '';
    public $editMode   = false;
    public $foto, $picture;
    public $medidas    = [];
    public $nombre_producto,
        $presentacion_producto,
        $medida_id = '', $producto_id,
        $compra_producto,
        $venta_producto,
        $cuenta_producto, $iva_producto;
    public function render()
    {
        $this->medidas = Medida::select('id', 'unidad')->where('estado', 'on')->get();
        $productos = Product::join('medidas', 'products.medida_id', '=', 'medidas.id')->where(function ($query) {
            $query->where('products.nombre', 'like', '%' . $this->search . '%')
                ->orWhere('products.presentacion', 'like', '%' . $this->search . '%')
                ->orWhere('products.precio_compra', 'like', '%' . $this->search . '%')
                ->orWhere('products.precio_venta', 'like', '%' . $this->search . '%')
                ->orWhere('products.iva', 'like', '%' . $this->search . '%')
                ->orWhere('products.cuenta_contable', 'like', '%' . $this->search . '%');
        })
            ->where(function ($query) {
                if ($this->unidad !== '') {
                    $query->where('medidas.id', $this->unidad);
                }
            })
            ->where(function ($query) {
                if ($this->statu !== '') {
                    $query->where('products.estado', $this->statu);
                }
            })
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->select('products.*', 'medidas.unidad as unidad')
            ->paginate($this->perPage);
        return view('livewire.coordinador.producto.productos', compact('productos'));
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function crearProducto()
    {
        $this->validate([
            'foto'                  => 'required|image|max:5120', // 1MB Max
            'nombre_producto'       => 'required',
            'presentacion_producto' => 'required',
            'medida_id'             => 'required',
            'compra_producto'       => 'required',
            'venta_producto'        => 'required',
            'cuenta_producto'       => 'required',
            'iva_producto'          => 'exclude_unless:porcentual,true|required',
        ], [
            'foto.required'                  => 'No has seleccionado una imagen',
            'foto.image'                     => 'No has seleccionado una imagen',
            'foto.max'                       => 'La imagen supera el  limite permitido',
            'nombre_producto.required'       => 'No has agregado el Nombre del Producto',
            'presentacion_producto.required' => 'No has agregado la presentacion del producto',
            'medida_id.required'             => 'No has seleccionado la unidad de medida',
            'compra_producto.required'       => 'No has agregado el precio de compra',
            'venta_producto.required'        => 'No has agregado el precio de venta',
            'cuenta_producto.required'       => 'No has agregado la cuenta contable',
            'iva_producto.required'           => 'No has seleccionado el IVA',

        ]);

        $nombre   = time() . '_' . $this->foto->getClientOriginalName();
        $urlimagen  = '/img/productos/' . $nombre;
        $this->foto->storeAs('img/productos',  $nombre, 'public_upload');

        $producto                  = new Product;
        $producto->nombre          = $this->nombre_producto;
        $producto->presentacion    = $this->presentacion_producto;
        $producto->medida_id       = $this->medida_id;
        $producto->precio_compra   = $this->compra_producto;
        $producto->precio_venta    = $this->venta_producto;
        $producto->porcentual      = $this->porcentual;
        $producto->iva             = $this->iva_producto;
        $producto->cuenta_contable = $this->cuenta_producto;
        $producto->foto            = $urlimagen;
        if ($this->status) {
            $producto->estado          = 'on';
        } else {
            $producto->estado          = 'off';
        }
        $producto->save();

        $this->resetInput();
        $this->emit('success', ['mensaje' => 'Producto Registrado Correctamente', 'modal' => '#crearProducto']);
    }
    public function resetInput()
    {
        $this->reset([
            'nombre_producto',
            'presentacion_producto',
            'medida_id',
            'compra_producto',
            'venta_producto',
            'porcentual',
            'iva_producto',
            'cuenta_producto',
            'foto',
            'porcentual',
            'editMode',
            'picture',
        ]);
    }
    public function editProducto($id)
    {
        $this->producto_id           = $id;
        $producto                    = Product::find($id);
        $this->nombre_producto       = $producto->nombre;
        $this->presentacion_producto = $producto->presentacion;
        $this->medida_id             = $producto->medida_id;
        $this->compra_producto       = $producto->precio_compra;
        $this->venta_producto        = $producto->precio_venta;
        $this->porcentual            = $producto->porcentual;
        $this->iva_producto          = $producto->iva;
        $this->cuenta_producto       = $producto->cuenta_contable;
        $this->picture               = $producto->foto;
        $this->status                = $producto->estado == 'on' ? true : false;
        $this->editMode = true;
    }
    public function updateProducto()
    {
        $this->validate([
            'foto'                  => 'exclude_unless:foto,null|image|max:1024', // 1MB Max
            'nombre_producto'       => 'required',
            'presentacion_producto' => 'required',
            'medida_id'             => 'required',
            'compra_producto'       => 'required',
            'venta_producto'        => 'required',
            'cuenta_producto'       => 'required',
            'iva_producto'          => 'exclude_unless:porcentual,1|required',
        ], [
            'foto.required'                  => 'No has seleccionado una imagen',
            'foto.image'                     => 'No has seleccionado una imagen',
            'foto.max'                       => 'La imagen supera el  limite permitido',
            'nombre_producto.required'       => 'No has agregado el Nombre del Producto',
            'presentacion_producto.required' => 'No has agregado la presentacion del producto',
            'medida_id.required'             => 'No has seleccionado la unidad de medida',
            'compra_producto.required'       => 'No has agregado el precio de compra',
            'venta_producto.required'        => 'No has agregado el precio de venta',
            'cuenta_producto.required'       => 'No has agregado la cuenta contable',
            'iva_producto.required'           => 'No has seleccionado el IVA',

        ]);

        $producto                  = Product::find($this->producto_id);
        $producto->nombre          = $this->nombre_producto;
        $producto->presentacion    = $this->presentacion_producto;
        $producto->medida_id       = $this->medida_id;
        $producto->precio_compra   = $this->compra_producto;
        $producto->precio_venta    = $this->venta_producto;
        $producto->porcentual      = $this->porcentual;
        $producto->iva = $this->porcentual ? $this->iva_producto : null;
        $producto->cuenta_contable = $this->cuenta_producto;
        if (isset($this->foto)) {
            if (isset($producto->foto)) {
                $image_path = public_path() . $producto->foto;
                unlink($image_path);
            }
            $nombre   = time() . '_' . $this->foto->getClientOriginalName();
            $urlimagen  = '/img/productos/' . $nombre;

            $this->foto->storeAs('img/productos',  $nombre, 'public_upload');
            $producto->foto            = $urlimagen;
        }
        $producto->estado = $this->status ? 'on' : 'off';
        $producto->save();
        $this->resetInput();
        $this->emit('info', ['mensaje' => 'Producto Actualizado Correctamente', 'modal' => '#crearProducto']);
    }
    public function estadochange($id)
    {
        $estado = Product::find($id);
        if ($estado->estado == 'on') {
            $estado->estado = 'off';
            $estado->save();
            $this->emit('info', ['mensaje' => 'Estado Desactivado Actualizado']);
        } else {
            $estado->estado = 'on';
            $estado->save();
            $this->emit('info', ['mensaje' => 'Estado Activado Actualizado']);
        }
    }
    public function eliminarProducto(Product $product)
    {
        $product->delete();
    }
    public function generaExcel()
    {
        $productos = Product::join('medidas', 'products.medida_id', '=', 'medidas.id')->where(function ($query) {
            $query->where('products.nombre', 'like', '%' . $this->search . '%')
                ->orWhere('products.presentacion', 'like', '%' . $this->search . '%')
                ->orWhere('products.precio_compra', 'like', '%' . $this->search . '%')
                ->orWhere('products.precio_venta', 'like', '%' . $this->search . '%')
                ->orWhere('products.iva', 'like', '%' . $this->search . '%')
                ->orWhere('products.cuenta_contable', 'like', '%' . $this->search . '%');
        })
            ->where(function ($query) {
                if ($this->unidad !== '') {
                    $query->where('medidas.id', $this->unidad);
                }
            })
            ->where(function ($query) {
                if ($this->statu !== '') {
                    $query->where('products.estado', $this->statu);
                }
            })
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->select('products.*', 'medidas.unidad as unidad')
            ->get();

        return Excel::download(new ProductosExport($productos), 'productos.xlsx');
    }
}
