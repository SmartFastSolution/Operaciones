<?php

namespace App\Http\Livewire\Admin\Sectors;

use App\Sector;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Sectores extends Component
{
	use WithPagination;
    use WithFileUploads;
	protected $paginationTheme = 'bootstrap';
	protected $listeners       = ['eliminarSector'];
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
	public $sector_id ='';
	public $editMode  = false;
	public $nombre_sector, $descripcion_sector;
    public function render()
    {
    	$sectores = Sector::where(function ($query) {
                       $query->where('nombre', 'like', '%'.$this->search.'%')
                        ->orWhere('descripcion', 'like', '%'.$this->search.'%');
                 })
                ->where(function ($query) {
                    if ($this->status !== '') {
                       $query->where('estado', $this->status);    
                    }
                 })
                ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
                ->paginate($this->perPage); 
        return view('livewire.admin.sectors.sectores', compact('sectores'));
    }
    public function crearSector()
    {
    	$this->validate([
            'nombre_sector'   => 'required',
            'descripcion_sector'    => 'required'
        ],[
			'nombre_sector.required'      => 'No has agregado el nombre del sector',
			'descripcion_sector.required' => 'No has agregado la descripcion del sector',
    ]);  
		$sector           = new Sector;
		$sector->nombre  = $this->nombre_sector;
		$sector->descripcion = $this->descripcion_sector;
		$sector->estado   = $this->estado;
		$sector->save();

        $this->resetInput();
        $this->emit('success',['mensaje' => 'Sector Registrado Correctamente', 'modal' => '#createSector']); 
   	}
   	 public function resetInput()
    {
		$this->nombre_sector      = null;
		$this->estado             = "on";
		$this->descripcion_sector = null;
    }
    public function estadochange($id)
    {
        $estado =Sector::find($id);
        if ($estado->estado == 'on') {
            $estado->estado ='off';
            $estado->save();
         	$this->emit('info',['mensaje' => 'Estado Desactivado Actualizado']);
         } else {
            $estado->estado = 'on';
         $estado->save();
        	$this->emit('info',['mensaje' => 'Estado Activado Actualizado']);
         }
    }
    public function editSector($id)
    {
		$this->sector_id          = $id;
		$sector                   = Sector::find($id);
		$this->nombre_sector      = $sector->nombre;
		$this->descripcion_sector = $sector->descripcion;
		$this->estado             = $sector->estado;
		$this->editMode           = true;
    }
        public function updateSector()
    {
		$sector              = Sector::find($this->sector_id);
		$sector->nombre      = $this->nombre_sector;
		$sector->descripcion = $this->descripcion_sector;    
		$sector->estado      = $this->estado;
        $sector->save();
        $this->resetInput();
        $this->emit('info',['mensaje' => 'Sector Actualizado Correctamente', 'modal' => '#createSector']);
    }
       public function eliminarSector($id)
    {
          $user = Sector::find($id);
            $user->delete();
            $this->emit('info',['mensaje' => 'Sector Eliminado Correctamente']);

    }
}
