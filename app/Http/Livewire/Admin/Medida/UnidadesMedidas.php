<?php

namespace App\Http\Livewire\Admin\Medida;

use App\ConversionUnidad;
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

	//CONVERSIONES
	public $medida, $conversiones = [], $medida_conversion = '', $factor, $operacion ='', $medi_id, $conversion_id ='',  $editConversion = false, $conversion;

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

		$conversion                    = new ConversionUnidad;
		$conversion->medida_base       = $medida->id;
		$conversion->medida_conversion = $medida->id;
		$conversion->factor            = 1;
		// $conversion->accion            = $this->operacion;
		$conversion->save();
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
		$this->editMode           = false;
		
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
          $medida = Medida::find($id);
            $medida->delete();
            $this->emit('info',['mensaje' => 'Unidad de Medida Eliminado Correctamente']);

    }

    //CONVERSIONES
    public function conversion($id)
    {
          $medi = Medida::with(['conversiones', 'conversiones.medida'])->find($id);
          $this->medi_id = $id;
          $ids = $medi->conversiones->pluck('medida_conversion');
          $this->medida = $medi;
          $this->conversiones = Medida::select('id', 'unidad')->whereNotIn('id',$ids)->get();

    }
    public function createCon()
    {
    	$this->validate([
			'medida_conversion'  => 'required',
			'factor'             => 'required',
			// 'operacion'          => 'required',
        ],[
			'medida_conversion.required' => 'No has seleccionado la unidad',
			'factor.required'            => 'No has agregado el factor de conversion',
			// 'operacion.required'         => 'No has seleccionado la operacion de conversion',
    ]);  
		$conversion                    = new ConversionUnidad;
		$conversion->medida_base       = $this->medi_id;
		$conversion->medida_conversion = $this->medida_conversion;
		$conversion->factor            = $this->factor;
		// $conversion->accion            = $this->operacion;
		$conversion->save();

		$this->medida_conversion = '';
        $this->emit('info',['mensaje' => 'Conversion Creada Correctamente']);
        // $this->resetConversiones();
		$this->conversion($this->medi_id);
    }
    public function resetConversiones()
    {
			$this->medida            = null;
			$this->conversiones      = [];
			$this->medida_conversion = '';
			$this->factor            = null;
			$this->operacion         = '';
			$this->conversion        = null;
			$this->conversion_id       = null;
			$this->editConversion    = false;  
		$this->editMode           = false;

    }
    public function cancelEdit()
    {
    		$this->medida_conversion = '';
			$this->factor            = null;
			$this->operacion         = '';
			$this->conversion        = null;
			$this->conversion_id       = null;
			$this->editConversion    = false;
		$this->editMode           = false;

    }
    public function editarConversion($index)
    {
		$this->editConversion    = true;
		$this->conversion        = $this->medida->conversiones[$index]->medida->unidad;
		$this->conversion_id       = $this->medida->conversiones[$index]->id;
		$this->medida_conversion =  $this->medida->conversiones[$index]->medida_conversion;
		$this->factor            =  $this->medida->conversiones[$index]->factor;
		// $this->operacion         =  $this->medida->conversiones[$index]->accion;
    }
    public function updateConversion()
    {
    	  	$this->validate([
			'factor'             => 'required',
			// 'operacion'          => 'required',
        ],[
			'factor.required'            => 'No has agregado el factor de conversion',
			// 'operacion.required'         => 'No has seleccionado la operacion de conversion',
    ]);  

    	$conversion                    = ConversionUnidad::find($this->conversion_id);
		$conversion->factor            = $this->factor;
		// $conversion->accion            = $this->operacion;
		$conversion->save();
        $this->resetConversiones();
		$this->conversion($this->medi_id);
		$this->editConversion    = false;


    }
    public function eliminarConversion($index, $id)
    {
    	$conversion  = ConversionUnidad::find($id);
    	$conversion->delete();
    	$this->conversion($index);
    }
}
