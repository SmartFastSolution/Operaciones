<?php

namespace App\Http\Livewire\Operador\Requerimientos;

use App\Requerimiento;
use Livewire\Component;
use Livewire\WithPagination;

class ListaRequerimientos extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners       = ['obtenerMapas'];
    protected $queryString     =
    [
        'search' => ['except' => ''],
        'page',
        'status' => ['except' => '']
    ];

    public $perPage          = 100;
    public $search           = '';
    public $orderBy          = 'requerimientos.id';
    public $orderAsc         = true;
    public $estado           = 'pendiente';
    public $status           = '';
    public $sector_id        = '';
    public $sectorSearch     = '';
    public $fechaini         = null;
    public $fechafin         = null;
    public $conteo           = 0;
    public $rango            = 100;
    public $requerimiento_id = '';
    public $editMode         = false;
    public $createDisabled   = false;
    public $magnitud_medida, $unidad_medida, $icono_medida, $descripcion_medida;
    public function mount()
    {
        $this->fechaini = date('Y-m-d');
        $this->fechafin = date('Y-m-d');
    }
    public function render()
    {
        // $requerimientos = Requerimiento::join('sectors', 'requerimientos.sector_id', '=', 'sectors.id')
        // 	->join('tipo_requerimientos', 'requerimientos.tipo_requerimiento_id', '=', 'tipo_requerimientos.id')
        // 	->where(function ($query) {
        //              $query->where('nombres', 'like', '%'.$this->search.'%')
        //                  ->orWhere('codigo_catastral', 'like', '%'.$this->search.'%')
        //                  ->orWhere('direccion', 'like', '%'.$this->search.'%')
        //                  ->orWhere('codigo', 'like', '%'.$this->search.'%')
        //                  ->orWhere('cedula', 'like', '%'.$this->search.'%');
        //            })
        //           ->where('sectors.nombre', 'like', '%'.$this->sectorSearch.'%')
        //           ->where(function ($query) {
        //               if ($this->status !== '') {
        //                  $query->where('requerimientos.estado', $this->status);
        //               }
        //            })
        //           ->whereBetween('requerimientos.fecha_maxima', [$this->fechaini , $this->fechafin])
        //           ->select('requerimientos.*', 'sectors.nombre as sector', 'tipo_requerimientos.nombre as requerimiento')
        //           ->latest()
        //            ->take($this->rango)
        //            ->get();

        //           $this->conteo = $requerimientos->count();
        $this->obtenerMapas();
        // dd($conteo);
        return view('livewire.operador.requerimientos.lista-requerimientos');
    }
    public function obtenerMapas()
    {
        $requerimientos = Requerimiento::leftJoin('sectors',  'sectors.id',  '=', 'requerimientos.sector_id',)
            ->leftJoin('tipo_requerimientos', 'tipo_requerimientos.id',  '=', 'requerimientos.tipo_requerimiento_id')
            ->where(function ($query) {
                $query->where('nombres', 'like', '%' . $this->search . '%')
                    // ->orWhere('codigo_catastral', 'like', '%'.$this->search.'%')
                    ->orWhere('direccion', 'like', '%' . $this->search . '%')
                    ->orWhere('codigo', 'like', '%' . $this->search . '%')
                    ->orWhere('cedula', 'like', '%' . $this->search . '%');
            })
            ->where(function ($query) {
                if ($this->sectorSearch !== '') {
                    $query->where('sectors.nombre', 'like', '%' . $this->sectorSearch . '%');
                }
            })
            // ->where('sectors.nombre', 'like', '%'.$this->sectorSearch.'%')
            ->where(function ($query) {
                if ($this->status !== '') {
                    $query->where('requerimientos.estado', $this->status);
                }
            })
            ->whereBetween('requerimientos.fecha_maxima', [$this->fechaini, $this->fechafin])
            ->select('requerimientos.*', 'sectors.nombre as sector', 'tipo_requerimientos.nombre as requerimiento')
            // ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->latest('requerimientos.fecha_maxima')
            ->take($this->rango)
            ->get();

        $this->conteo = $requerimientos->count();

        // $this->emit('success',['mensaje' => 'Requerimiento Creado Correctamente', 'modal' => '#createRequerimiento']);


        $this->emit('mapas', ['mapas' => $requerimientos]);
    }
}
