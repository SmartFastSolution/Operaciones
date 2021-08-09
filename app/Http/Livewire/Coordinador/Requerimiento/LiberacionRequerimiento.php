<?php

namespace App\Http\Livewire\Coordinador\Requerimiento;

use App\Requerimiento;
use Livewire\Component;
use Livewire\WithPagination;

class LiberacionRequerimiento extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    protected $listeners       = ['actualizarComponente' => 'render'];
    protected $queryString     =
    [
        'search' => ['except' => '']
    ];
    public $perPage      = 10;
    public $search       = '';
    public $codigoCatastral       = '';
    public $fechaini        = null;
    public $fechafin        = null;
    public $orderBy      = 'requerimientos.id';
    public $orderAsc     = true;
    public $liberados    = [];
    public $liberacioncompleta   = false;

    public function mount()
    {
        $this->fechaini = date('Y-m-d');
        $this->fechafin = date('Y-m-d');
    }
    function seleccionesMultiples()
    {
        if ($this->liberacioncompleta) {
            $this->selectionLiberar();
        } else {
            $this->liberados = [];
        }
    }
    public function updatingSearch()
    {
        $this->resetPage();
        $this->liberacioncompleta = false;
        $this->seleccionesMultiples();
    }
    public function updatingCodigoCatastral()
    {
        $this->resetPage();
        $this->liberacioncompleta = false;
        $this->seleccionesMultiples();
    }
    public function render()
    {
        $asignados = Requerimiento::leftJoin('sectors',  'sectors.id',  '=', 'requerimientos.sector_id',)
            ->leftJoin('tipo_requerimientos', 'tipo_requerimientos.id',  '=', 'requerimientos.tipo_requerimiento_id')
            ->join('users', 'requerimientos.operador_id', '=', 'users.id')
            ->where(function ($query) {
                $query->where('requerimientos.nombres', 'like', '%' . $this->search . '%')
                    ->orWhere('requerimientos.codigo', 'like', '%' . $this->search . '%')
                    ->orWhere('requerimientos.cedula', 'like', '%' . $this->search . '%');
            })
            ->whereBetween('requerimientos.fecha_maxima', [$this->fechaini, $this->fechafin])
            ->where(function ($query) {
                if ($this->codigoCatastral !== '') {
                    $query->where('requerimientos.codigo_catastral', 'like', '%' . $this->codigoCatastral . '%');
                }
            })
            ->where('requerimientos.estado', 'asignado')
            ->select('requerimientos.*', 'sectors.nombre as sector', 'tipo_requerimientos.nombre as requerimiento', 'users.nombres as operador')
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        return view('livewire.coordinador.requerimiento.liberacion-requerimiento', compact('asignados'));
    }
    public function liberarRequerimiento($id)
    {
        $clave = array_search($id, $this->liberados); // $clave = ;
        if ($clave !== false or $clave == 0) {
            unset($this->liberados[$clave]);
        }
        $requerimiento              = Requerimiento::find($id);
        $requerimiento->operador_id = null;
        $requerimiento->estado      = 'pendiente';
        $requerimiento->save();
    }
    public function selectionLiberar()
    {
        $requerimientos = Requerimiento::leftJoin('sectors',  'sectors.id',  '=', 'requerimientos.sector_id',)
            ->leftJoin('tipo_requerimientos', 'tipo_requerimientos.id',  '=', 'requerimientos.tipo_requerimiento_id')
            ->where(function ($query) {
                $query->where('nombres', 'like', '%' . $this->search . '%')
                    ->orWhere('codigo', 'like', '%' . $this->search . '%')
                    ->orWhere('cedula', 'like', '%' . $this->search . '%');
            })
            ->where(function ($query) {
                if ($this->codigoCatastral !== '') {
                    $query->where('requerimientos.codigo_catastral', 'like', '%' . $this->codigoCatastral . '%');
                }
            })
            ->whereBetween('requerimientos.fecha_maxima', [$this->fechaini, $this->fechafin])
            ->select('requerimientos.*', 'sectors.nombre as sector', 'tipo_requerimientos.nombre as requerimiento')
            ->where('requerimientos.estado', 'asignado')
            ->pluck('id');

        $this->liberados = [];

        foreach ($requerimientos as $re) {
            $this->liberados[] = "$re";
        }
    }
    public function liberacionMasiva()
    {
        $this->validate([
            "liberados"    => "required|array|min:1",

        ], [
            'liberados.required' => 'No has seleccionado ningun requerimiento',
            // 'liberados.array'    => 'Este operador no se le puede asignar mas de '.$this->disponible.' requerimientos',
        ]);
        // $this->asignando = true;
        foreach ($this->liberados as $id) {
            $requerimiento              = Requerimiento::find($id);
            $requerimiento->operador_id = null;
            $requerimiento->estado      = 'pendiente';
            $requerimiento->save();
        }
        // $this->asignando = false;
        $this->liberados = [];
        $this->liberacioncompleta = false;
    }
}
