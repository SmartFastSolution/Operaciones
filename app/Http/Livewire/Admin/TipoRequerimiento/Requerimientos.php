<?php

namespace App\Http\Livewire\Admin\TipoRequerimiento;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\TipoRequerimiento;

class Requerimientos extends Component
{
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    protected $listeners       = ['eliminarRequerimiento'];
    protected $queryString     = [
        'search' => ['except' => ''],
        'page', 'status' => ['except' => '']
    ];
    public $perPage   = 10;
    public $search    = '';
    public $orderBy   = 'id';
    public $orderAsc  = true;
    public $estado    = 'on';
    public $permiso   = '';
    public $status    = '';
    public $sector_id = '';
    public $editMode  = false;
    public $nombre_requerimiento, $parametrizacion_requerimiento, $descripcion_requerimiento, $tipo_id;
    public function render()
    {
        $tipos = TipoRequerimiento::where(function ($query) {
            $query->where('nombre', 'like', '%' . $this->search . '%')
                ->orWhere('parametrizacion', 'like', '%' . $this->search . '%')
                ->orWhere('descripcion', 'like', '%' . $this->search . '%');
        })
            ->where(function ($query) {
                if ($this->status !== '') {
                    $query->where('estado', $this->status);
                }
            })
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        return view('livewire.admin.tipo-requerimiento.requerimientos', compact('tipos'));
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function crearTipos()
    {
        $this->validate([
            'nombre_requerimiento'          => 'required',
            'parametrizacion_requerimiento' => 'required',
            'descripcion_requerimiento'     => 'required'
        ], [
            'nombre_requerimiento.required'          => 'No has agregado el nombre del sector',
            'parametrizacion_requerimiento.required' => 'No has agregado el nombre del sector',
            'descripcion_requerimiento.required'     => 'No has agregado la descripcion del sector',
        ]);
        $tipos                  = new TipoRequerimiento;
        $tipos->nombre          = $this->nombre_requerimiento;
        $tipos->parametrizacion = $this->parametrizacion_requerimiento;
        $tipos->descripcion     = $this->descripcion_requerimiento;
        $tipos->estado          = $this->estado;
        $tipos->save();

        $this->resetInput();
        $this->emit('success', ['mensaje' => 'Tipo de Requerimiento Registrado Correctamente', 'modal' => '#createTipos']);
    }
    public function resetInput()
    {
        $this->nombre_requerimiento          = null;
        $this->parametrizacion_requerimiento = null;
        $this->estado                        = "on";
        $this->descripcion_requerimiento     = null;
        $this->editMode                      = false;
    }
    public function estadochange($id)
    {
        $estado = TipoRequerimiento::find($id);
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
    public function editTipo($id)
    {
        $this->tipo_id                       = $id;
        $tipo                                = TipoRequerimiento::find($id);
        $this->nombre_requerimiento          = $tipo->nombre;
        $this->parametrizacion_requerimiento = $tipo->parametrizacion;
        $this->descripcion_requerimiento     = $tipo->descripcion;
        $this->estado                        = $tipo->estado;
        $this->editMode                      = true;
    }
    public function updateTipo()
    {
        $tipo                  = TipoRequerimiento::find($this->tipo_id);
        $tipo->nombre          = $this->nombre_requerimiento;
        $tipo->parametrizacion = $this->parametrizacion_requerimiento;
        $tipo->descripcion     = $this->descripcion_requerimiento;
        $tipo->estado          = $this->estado;
        $tipo->save();
        $this->resetInput();
        $this->emit('info', ['mensaje' => 'Requerimiento Actualizado Correctamente', 'modal' => '#createTipos']);
    }
    public function eliminarRequerimiento($id)
    {
        $user = TipoRequerimiento::find($id);
        $user->delete();
        $this->emit('info', ['mensaje' => 'Requerimiento Eliminado Correctamente']);
    }
}
