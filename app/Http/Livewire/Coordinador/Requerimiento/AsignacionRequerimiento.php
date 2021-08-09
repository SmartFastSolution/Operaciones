<?php

namespace App\Http\Livewire\Coordinador\Requerimiento;

use App\Requerimiento;
use Livewire\Component;
use Livewire\WithPagination;

class AsignacionRequerimiento extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners       = ['cargarOperador'];
    protected $queryString     =
    [
        'search' => ['except' => '']
    ];
    public $operador_id  = '';
    public $disponible   = '';
    public $selecionados = [];
    public $perPage      = 10;
    public $search       = '';
    public $codigoCatastral       = '';
    public $codigoCatastral2      = '';
    public $fechaini        = null;
    public $fechafin        = null;
    public $fechaini2        = null;
    public $fechafin2       = null;
    public $orderBy      = 'requerimientos.id';
    public $orderAsc     = true;
    public $asignando    = false;
    public $perPage2     = 10;
    public $search2      = '';
    public $orderBy2     = 'requerimientos.id';
    public $orderAsc2    = true;
    public $asignando2   = false;
    public $selectioncompleta   = false;

    public function mount()
    {
        $this->fechaini = date('Y-m-d');
        $this->fechafin = date('Y-m-d');
        $this->fechaini2 = date('Y-m-d');
        $this->fechafin2 = date('Y-m-d');
    }
    function seleccionesMultiples()
    {
        if ($this->selectioncompleta) {
            $this->selectionAll();
        } else {
            $this->selecionados = [];
        }

        // if ($this->liberacioncompleta) {
        //     $this->selectionLiberar();
        // } else {
        //     $this->liberados = [];
        // }
    }
    public function updatingSearch()
    {
        $this->resetPage();
        $this->selectioncompleta = false;
        $this->seleccionesMultiples();
    }
    public function updatingCodigoCatastral()
    {
        $this->resetPage();
        $this->selectioncompleta = false;
        $this->seleccionesMultiples();
    }
    public function getQueryString()
    {
        return [];
    }
    public function render()
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

            ->where('requerimientos.estado', 'pendiente')
            ->whereBetween('requerimientos.fecha_maxima', [$this->fechaini, $this->fechafin])
            ->select('requerimientos.*', 'sectors.nombre as sector', 'tipo_requerimientos.nombre as requerimiento')
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);


        return view('livewire.coordinador.requerimiento.asignacion-requerimiento', compact('requerimientos'));
    }
    public function cargarOperador($operador)
    {
        $this->operador_id = $operador;
        // $this->disponible = (10 - Requerimiento::where('operador_id', $operador)->count());
    }
    public function asignarRequerimiento($id)
    {
        $this->validate([
            'operador_id'      => 'required',
        ], [
            'operador_id.required'      => 'No has seleccionado un Operador',
        ]);
        $clave = array_search($id, $this->selecionados); // $clave = 2;
        if ($clave !== false or $clave == 0) {
            unset($this->selecionados[$clave]);
        }
        $requerimiento = Requerimiento::find($id);
        $requerimiento->operador_id = $this->operador_id;
        $requerimiento->estado = 'asignado';
        $requerimiento->save();

        $this->emitTo('coordinador.requerimiento.liberacion-requerimiento', 'actualizarComponente');


        $this->disponible = (10 - Requerimiento::where('operador_id', $this->operador_id)->count());
    }

    public function asignacionMasiva()
    {
        $this->validate([
            "operador_id"    => "required",
            "selecionados"    => "required|array|min:1",
            // "selecionados"    => "exclude_if:operador_id,|required|array|min:1|max:".$this->disponible,

        ], [
            'operador_id.required'      => 'No has seleccionado un Operador',
            'selecionados.required'      => 'No has seleccionado ningun requerimiento',
            'selecionados.array'      => 'Este operador no se le puede asignar mas de ' . $this->disponible . ' requerimientos',
            // 'selecionados.max'      => 'Este operador no se le puede asignar mas de '.$this->disponible.' requerimientos',
            'selecionados.required' => 'No has seleccionado ningun requerimiento',
        ]);

        $this->asignando = true;
        foreach ($this->selecionados as $id) {
            $requerimiento = Requerimiento::find($id);
            $requerimiento->operador_id = $this->operador_id;
            $requerimiento->estado = 'asignado';
            $requerimiento->save();
            $this->disponible = (10 - Requerimiento::where('operador_id', $this->operador_id)->count());
        }
        $this->asignando = false;
        $this->selecionados = [];
        $this->selectioncompleta = false;
        $this->emitTo('coordinador.requerimiento.liberacion-requerimiento', 'actualizarComponente');
    }
    public function selectionAll()
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
            ->select('requerimientos.*', 'sectors.nombre as sector', 'tipo_requerimientos.nombre as requerimiento')
            ->whereBetween('requerimientos.fecha_maxima', [$this->fechaini, $this->fechafin])
            ->where('requerimientos.estado', 'pendiente')
            ->pluck('id');
        $this->selecionados = [];

        foreach ($requerimientos as $re) {
            $this->selecionados[] = "$re";
        }
        // $this->selecionados = $requerimientos;
    }
}
