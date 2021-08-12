<?php

namespace App\Http\Livewire\Coordinador\Requerimiento;

use App\Sector;
use App\Document;
use App\Requerimiento;
use Livewire\Component;
use App\TipoRequerimiento;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class CreateRequerimiento extends Component
{
    use WithFileUploads;
    public $status           = '';
    public $sector_id        = '';
    public $codigoCatastral     = '';
    public $requerimiento_id = '';
    public $errores = [];
    protected $listeners       = ['eliminarRequerimiento', 'cargarSector', 'cargarRequerimiento', 'cargarUbicacion', 'createRequerimiento', 'updaRequerimiento'];

    public $codigo_requerimiento, $sectores = [], $tipos = [], $archivos = [], $nombre_requerimiento, $cedula_requerimiento, $telefonos_requerimiento, $correos_requerimiento, $direccion_requerimiento, $fecha_requerimiento, $detalle_requerimiento, $observacion_requerimiento, $tipo_id, $longitud, $latitud, $codigo_catastral, $cuenta_requerimiento, $excel;
    public function mount()
    {
        $this->sectores = Sector::where('estado', 'on')->get(['id', 'nombre']);
        $this->tipos    = TipoRequerimiento::where('estado', 'on')->get(['id', 'nombre']);
    }
    public function render()
    {
        return view('livewire.coordinador.requerimiento.create-requerimiento');
    }
    public function cargarSector($id)
    {
        $this->sector_id = $id;
    }
    public function cargarRequerimiento($id)
    {
        $this->tipo_id = $id;
    }
    public function cargarUbicacion($ubicacion)
    {
        $this->latitud  = $ubicacion['lat'];
        $this->longitud = $ubicacion['lng'];
    }
    public function createRequerimiento($observacion)
    {
        $this->observacion_requerimiento = $observacion;
        $this->creaRequerimiento();
    }
    public function creaRequerimiento()
    {
        $this->validate([
            'codigo_requerimiento'      => 'required|max:100',
            'cuenta_requerimiento'      => 'required|max:100',
            'nombre_requerimiento'      => 'required',
            'cedula_requerimiento'      => 'required|max:13',
            'codigo_catastral'          => 'required',
            'telefonos_requerimiento'   => 'required',
            'correos_requerimiento'     => 'required',
            'direccion_requerimiento'   => 'required',
            'fecha_requerimiento'       => 'required',
            'detalle_requerimiento'     => 'required',
            'observacion_requerimiento' => 'required',
            'tipo_id'                   => 'required',
            'sector_id'                 => 'required',
            'longitud'                  => 'required',
            'latitud'                   => 'required',
            'archivos.*'                => 'max:51200',
        ], [
            'cuenta_requerimiento.required'      => 'No has agregado la cuenta',
            'codigo_requerimiento.required'      => 'No has agregado el nombre del sector',
            'codigo_requerimiento.max'           => 'El limite del codigo sobrepasa lo permitido',
            'nombre_requerimiento.required'      => 'No has agregado el nombre del sector',
            'codigo_catastral.required'          => 'No has agregado el codigo catastral',
            'cedula_requerimiento.required'      => 'No has agregado la cedula',
            'telefonos_requerimiento.required'   => 'No has agregado los telefonos',
            'correos_requerimiento.required'     => 'No has agregado la correos',
            'direccion_requerimiento.required'   => 'No has agregado la direccion',
            'fecha_requerimiento.required'       => 'No has agregado la fecha maxima',
            'detalle_requerimiento.required'     => 'No has agregado el  detalle',
            'observacion_requerimiento.required' => 'No has agregado la observacion',
            'tipo_id.required'                   => 'No has seleccionado el tipo de requerimiento',
            'sector_id.required'                 => 'No has seleccionado el sector',
            'longitud.required'                  => 'No has seleccionado tu ubicacion',
            'latitud.required'                   => 'No has seleccionado tu ubicacion',

        ]);

        $this->createDisabled = true;
        $requerimiento                        = new Requerimiento;
        $requerimiento->user_id               = Auth::id();
        $requerimiento->codigo                = $this->codigo_requerimiento;
        $requerimiento->cuenta                = $this->cuenta_requerimiento;
        $requerimiento->nombres               = $this->nombre_requerimiento;
        $requerimiento->codigo_catastral      = $this->codigo_catastral;
        $requerimiento->cedula                = $this->cedula_requerimiento;
        $requerimiento->telefonos             = $this->telefonos_requerimiento;
        $requerimiento->correos               = $this->correos_requerimiento;
        $requerimiento->direccion             = $this->direccion_requerimiento;
        $requerimiento->sector_id             = $this->sector_id;
        $requerimiento->tipo_requerimiento_id = $this->tipo_id;
        $requerimiento->detalle               = $this->detalle_requerimiento;
        $requerimiento->observacion           = $this->observacion_requerimiento;
        $requerimiento->fecha_maxima          = $this->fecha_requerimiento;
        $requerimiento->latitud               = $this->latitud;
        $requerimiento->longitud              = $this->longitud;
        $requerimiento->estado                = $this->estado;
        $requerimiento->save();

        if (count($this->archivos) > 0) {
            foreach ($this->archivos as $archivo) {
                $nombre   = time() . '_' . $archivo->getClientOriginalName();
                $urldocumento  = '/requerimientos/' . $nombre;
                $archivo->storeAs('requerimientos',  $nombre, 'public_upload');
                $documento = new Document(['nombre' => $archivo->getClientOriginalName(), 'extension' => pathinfo($urldocumento, PATHINFO_EXTENSION), 'archivo' => $urldocumento]);
                $requerimiento->documentos()->save($documento);
            }
        }
        $this->resetInput();
        $this->emit('success', ['mensaje' => 'Requerimiento Creado Correctamente', 'modal' => '#createRequerimiento']);
        $this->createDisabled = false;
    }
}
