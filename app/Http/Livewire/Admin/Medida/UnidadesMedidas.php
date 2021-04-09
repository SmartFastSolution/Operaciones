<?php

namespace App\Http\Livewire\Admin\Medida;

use App\Medida;
use Livewire\Component;
use Livewire\WithPagination;

class UnidadesMedidas extends Component
{
	use WithPagination;
	protected $paginationTheme = 'bootstrap';
	protected $listeners       = ['eliminarMedida'];
	protected $queryString     =['search' => ['except' => ''],
    'page', 'status' => ['except' => '']
	];
	public $perPage   = 10;
	public $search    = '';
	public $orderBy   = 'id';
	public $orderAsc  = true;
	public $estado    ='on';
	public $permiso   = '';
	public $status    = '';
	public $medida_id ='';
	public $editMode  = false;
	public $magnitud_medida, $unidad_medida, $icono_medida, $descripcion_medida;
    public function render()
    {
    	$medidas = Medida::where(function ($query) {
                       $query->where('magnitud', 'like', '%'.$this->search.'%')
                        ->orWhere('unidad', 'like', '%'.$this->search.'%')
                        ->orWhere('simbolo', 'like', '%'.$this->search.'%')
                        ->orWhere('descripcion', 'like', '%'.$this->search.'%');
                 })
        ->where(function ($query) {
                    if ($this->status !== '') {
                       $query->where('estado', $this->status);    
                    }
                 })
                ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
                ->paginate($this->perPage); 
        return view('livewire.admin.medida.unidades-medidas', compact('medidas'));
    }
        public function crearMedida()
    {
    	$this->validate([
			'magnitud_medida'    => 'required',
			'unidad_medida'      => 'required|unique:medidas,unidad',
			'icono_medida'       => 'required|unique:medidas,simbolo|max:4',
			'descripcion_medida' => 'required'
        ],[
			'magnitud_medida.required'    => 'No has agregado la Magnitud de Medida',
			'unidad_medida.required'      => 'No has agregado la Unidad de Medida',
			'unidad_medida.unique'        => 'Esta Unidad De Medida Ya Se Encuentra Registrada',
			'icono_medida.required'       => 'No has agregado la Abreviatura de la Medida',
			'descripcion_medida.required' => 'No has agregado la descripcion de la medida',
			'icono_medida.unique'         => 'Esta Abreviatura Ya Se Encuentra Registrada',
			'icono_medida.max'         => 'Esta Abreviatura no puede tener mas de 4 caracteres',

    ]);  
		$medida              = new Medida;
		$medida->magnitud    = $this->magnitud_medida;
		$medida->unidad      = $this->unidad_medida;
		$medida->simbolo     = $this->icono_medida;
		$medida->descripcion = $this->descripcion_medida;
		$medida->estado      = $this->estado;
		$medida->save();
        $this->resetInput();
        $this->emit('success',['mensaje' => 'Sector Registrado Correctamente', 'modal' => '#createMedida']); 
   	}
   	 public function resetInput()
    {
		$this->magnitud_medida    = null;
		$this->unidad_medida      = null;
		$this->icono_medida       = null;
		$this->descripcion_medida = null;
		$this->estado             = "on";
    }
    public function estadochange($id)
    {
        $estado =Medida::find($id);
        if ($estado->estado == 'on') {
            $estado->estado ='off';
            $estado->save();
         	$this->emit('info',['mensaje' => 'Estado Desactivado Actualizado']);
         }else {
            $estado->estado = 'on';
         	$estado->save();
        	$this->emit('info',['mensaje' => 'Estado Activado Actualizado']);
         }
    }
    public function editMedida($id)
    {
		$this->medida_id          = $id;
		$medida                   = Medida::find($id);
		$this->magnitud_medida    = $medida->magnitud;
		$this->unidad_medida      = $medida->unidad;
		$this->icono_medida       = $medida->simbolo;
		$this->descripcion_medida = $medida->descripcion;
		$this->estado             = $medida->estado;
		$this->editMode           = true;
    }
        public function updateMedida()
    {
    	$this->validate([
			'magnitud_medida'    => 'required',
			'unidad_medida'      => 'required|unique:medidas,unidad,'.$this->medida_id,
			'icono_medida'       => 'required|max:4|unique:medidas,simbolo,'.$this->medida_id,
			'descripcion_medida' => 'required'
        ],[
			'magnitud_medida.required'    => 'No has agregado la Magnitud de Medida',
			'unidad_medida.required'      => 'No has agregado la Unidad de Medida',
			'unidad_medida.unique'        => 'Esta Unidad De Medida Ya Se Encuentra Registrada',
			'icono_medida.required'       => 'No has agregado la Abreviatura de la Medida',
			'descripcion_medida.required' => 'No has agregado la descripcion de la medida',
			'icono_medida.unique'         => 'Esta Abreviatura Ya Se Encuentra Registrada',
			'icono_medida.max'         => 'Esta Abreviatura no puede tener mas de 4 caracteres',

    ]);  
		$medida              = Medida::find($this->medida_id);
		$medida->magnitud    = $this->magnitud_medida;
		$medida->unidad      = $this->unidad_medida;
		$medida->simbolo     = $this->icono_medida;
		$medida->descripcion = $this->descripcion_medida;
		$medida->estado      = $this->estado;
		$medida->save();
        $this->resetInput();
        $this->emit('info',['mensaje' => 'Unidad De Medida Actualizada Correctamente', 'modal' => '#createMedida']);
    }
       public function eliminarMedida($id)
    {
          $user = Medida::find($id);
            $user->delete();
            $this->emit('info',['mensaje' => 'Unidad de Medida Eliminado Correctamente']);

    }
}
