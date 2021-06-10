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
    public $liberados    = [];
    public $perPage      = 10;
    public $search       = '';
    public $sector       = '';
    public $sector2      = '';
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
    public $liberacioncompleta   = false;

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
        }else{
          $this->selecionados = [];  
        }

       if ($this->liberacioncompleta) {
            $this->selectionLiberar();
        }else{
          $this->liberados = [];  
        }

    }
    public function render()
    {
       

    	$requerimientos = Requerimiento::join('sectors', 'requerimientos.sector_id', '=', 'sectors.id')
    			->join('tipo_requerimientos', 'requerimientos.tipo_requerimiento_id', '=', 'tipo_requerimientos.id')
    			->where(function ($query) {
                   $query->where('nombres', 'like', '%'.$this->search.'%')
                       ->orWhere('codigo', 'like', '%'.$this->search.'%')
                       ->orWhere('cedula', 'like', '%'.$this->search.'%');
                 })
                ->where('sectors.nombre', 'like', '%'.$this->sector.'%')
                ->where('requerimientos.estado', 'pendiente')   
                ->whereBetween('requerimientos.fecha_maxima', [$this->fechaini , $this->fechafin])
                ->select('requerimientos.*', 'sectors.nombre as sector', 'tipo_requerimientos.nombre as requerimiento')
                ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
                ->paginate($this->perPage); 

        $asignados = Requerimiento::join('sectors', 'requerimientos.sector_id', '=', 'sectors.id')
    			->join('tipo_requerimientos', 'requerimientos.tipo_requerimiento_id', '=', 'tipo_requerimientos.id')
    			->join('users', 'requerimientos.operador_id', '=', 'users.id')
    			->where(function ($query) {
                   $query->where('requerimientos.nombres', 'like', '%'.$this->search2.'%')
                       ->orWhere('requerimientos.codigo', 'like', '%'.$this->search2.'%')
                       ->orWhere('requerimientos.cedula', 'like', '%'.$this->search2.'%');
                 })
                ->whereBetween('requerimientos.fecha_maxima', [$this->fechaini2 , $this->fechafin2])

                ->where('sectors.nombre', 'like', '%'.$this->sector2.'%')
                ->where('requerimientos.estado', 'asignado')   
                ->select('requerimientos.*', 'sectors.nombre as sector', 'tipo_requerimientos.nombre as requerimiento', 'users.nombres as operador')
                ->orderBy($this->orderBy2, $this->orderAsc2 ? 'asc' : 'desc')
                ->paginate($this->perPage2); 
        return view('livewire.coordinador.requerimiento.asignacion-requerimiento', compact('requerimientos', 'asignados'));
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

        ],[
			'operador_id.required'      => 'No has seleccionado un Operador',
    	]); 
    	$clave = array_search($id, $this->selecionados); // $clave = 2;
    	if ($clave !== false or $clave == 0 ) {
    		unset($this->selecionados[$clave]);
    	}
    	$requerimiento = Requerimiento::find($id);
    	$requerimiento->operador_id = $this->operador_id;
    	$requerimiento->estado = 'asignado';
    	$requerimiento->save();

    	
    	$this->disponible = (10 - Requerimiento::where('operador_id', $this->operador_id)->count());
    }
       public function liberarRequerimiento($id)
    {
    	$clave = array_search($id, $this->liberados); // $clave = 2;
    	if ($clave !== false or $clave == 0 ) {
    		unset($this->liberados[$clave]);
    	}
		$requerimiento              = Requerimiento::find($id);
		$requerimiento->operador_id = null;
		$requerimiento->estado      = 'pendiente';
		$requerimiento->save();
    	$this->disponible = (10 - Requerimiento::where('operador_id', $this->operador_id)->count());
    }
    public function asignacionMasiva()
    {
    		$this->validate([
			 "operador_id"    => "required",
			 // "selecionados"    => "exclude_if:operador_id,|required|array|min:1|max:".$this->disponible,

        ],[
        	'operador_id.required'      => 'No has seleccionado un Operador',
			'selecionados.required'      => 'No has seleccionado ningun requerimiento',
			'selecionados.array'      => 'Este operador no se le puede asignar mas de '.$this->disponible.' requerimientos',
			// 'selecionados.max'      => 'Este operador no se le puede asignar mas de '.$this->disponible.' requerimientos',
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


    }
    public function selectionAll()
    {
    	$requerimientos = Requerimiento::join('sectors', 'requerimientos.sector_id', '=', 'sectors.id')
                ->join('tipo_requerimientos', 'requerimientos.tipo_requerimiento_id', '=', 'tipo_requerimientos.id')
                ->where(function ($query) {
                   $query->where('nombres', 'like', '%'.$this->search.'%')
                       ->orWhere('codigo', 'like', '%'.$this->search.'%')
                       ->orWhere('cedula', 'like', '%'.$this->search.'%');

                 })
                ->where('sectors.nombre', 'like', '%'.$this->sector.'%')

                ->select('requerimientos.*', 'sectors.nombre as sector', 'tipo_requerimientos.nombre as requerimiento')
                ->whereBetween('requerimientos.fecha_maxima', [$this->fechaini , $this->fechafin])
                ->where('requerimientos.estado', 'pendiente')   
                ->pluck('id');
       				$this->selecionados = [];

                 foreach ($requerimientos as $re) {
       				$this->selecionados[]= "$re";
                	
                }
       // $this->selecionados = $requerimientos;
    }
        public function selectionLiberar()
    {
    	$requerimientos = Requerimiento::
        join('sectors', 'requerimientos.sector_id', '=', 'sectors.id')
                ->join('tipo_requerimientos', 'requerimientos.tipo_requerimiento_id', '=', 'tipo_requerimientos.id')
                ->where(function ($query) {
                   $query->where('nombres', 'like', '%'.$this->search2.'%')
                       ->orWhere('codigo', 'like', '%'.$this->search2.'%')
                       ->orWhere('cedula', 'like', '%'.$this->search2.'%');
                 })
                ->where('sectors.nombre', 'like', '%'.$this->sector2.'%')
                ->whereBetween('requerimientos.fecha_maxima', [$this->fechaini2 , $this->fechafin2])
                ->select('requerimientos.*', 'sectors.nombre as sector', 'tipo_requerimientos.nombre as requerimiento')
                ->where('requerimientos.estado', 'asignado')   
                ->pluck('id');

       				$this->liberados = [];

                foreach ($requerimientos as $re) {
       				$this->liberados[]= "$re";
                }
    }
        public function liberacionMasiva()
    {
            $this->validate([
             "liberados"    => "required|array|min:1",

        ],[
            'liberados.required' => 'No has seleccionado ningun requerimiento',
            // 'liberados.array'    => 'Este operador no se le puede asignar mas de '.$this->disponible.' requerimientos',
        ]);
        $this->asignando2 = true;
        foreach ($this->liberados as $id) 
        {
            $requerimiento              = Requerimiento::find($id);
            $requerimiento->operador_id = null;
            $requerimiento->estado      = 'pendiente';
            $requerimiento->save();
        }
        $this->asignando2 = false;
                    $this->liberados = [];
    $this->liberacioncompleta = false;
                    

    }
}
