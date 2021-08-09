<?php

namespace App\Http\Livewire\Coordinador\Requerimiento;

use App\Document;
use App\Exports\RequerimientoExport;
use App\Imports\RequerimientosImport;
use App\Requerimiento as Requerimient;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;


class Requerimiento extends Component
{
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    protected $listeners       = ['eliminarRequerimiento', 'cargarSector', 'cargarRequerimiento', 'cargarUbicacion', 'createRequerimiento', 'updaRequerimiento'];
    protected $queryString     =
    [
        'search' => ['except' => ''],
        'page',
        'status' => ['except' => ''],
        'sectorSearch' => ['except' => '']
    ];
    public $perPage          = 10;
    public $search           = '';
    public $orderBy          = 'requerimientos.id';
    public $orderAsc         = true;
    public $estado           = 'pendiente';
    public $status           = '';
    public $sector_id        = '';
    public $sectorSearch     = '';
    public $fechaini         = null;
    public $fechafin         = null;
    public $requerimiento_id = '';
    public $editMode         = false;
    public $createDisabled   = false;
    public $exporting        = false;
    public $archivos         = [];
    public $iteration = 0;
    public $errores = [];
    public $codigo_requerimiento, $nombre_requerimiento, $cedula_requerimiento, $telefonos_requerimiento, $correos_requerimiento, $direccion_requerimiento, $fecha_requerimiento, $detalle_requerimiento, $observacion_requerimiento, $tipo_id, $longitud, $latitud, $codigo_catastral, $cuenta_requerimiento, $excel;
    public function mount()
    {
        $this->fechaini = date('Y-m-d');
        $this->fechafin = date('Y-m-d');
    }
    public function importExcel()
    {
        $this->validate([
            'excel'      => 'required|mimes:xlsx',

        ], [
            'excel.required'      => 'No has agregado el excel',
            'excel.mimes'      => 'Solo puedes subir un archivo de tipo excel',
        ]);
        try {
            Excel::import(new RequerimientosImport, $this->excel);
            $this->emit('success', ['mensaje' => 'Importación exitosa', 'modal' => '#importarRequerimiento']);
            $this->reset('excel');
            $this->iteration++;
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $fallas = $e->failures();
            foreach ($fallas as $failure) {
                foreach ($failure->errors() as $error) {
                    $this->errores[] = $error . ' en la columna' . $failure->row();
                }
            }
        }
    }
    public function render()
    {
        $requerimientos = Requerimient::leftJoin('sectors',  'sectors.id',  '=', 'requerimientos.sector_id',)
            ->leftJoin('tipo_requerimientos', 'tipo_requerimientos.id',  '=', 'requerimientos.tipo_requerimiento_id')
            ->leftJoin('atencions', 'requerimientos.id', '=', 'atencions.requerimiento_id')
            ->where(function ($query) {
                $query->where('nombres', 'like', '%' . $this->search . '%')
                    ->orWhere('codigo_catastral', 'like', '%' . $this->search . '%')
                    ->orWhere('direccion', 'like', '%' . $this->search . '%')
                    ->orWhere('codigo', 'like', '%' . $this->search . '%')
                    ->orWhere('cuenta', 'like', '%' . $this->search . '%')
                    ->orWhere('cedula', 'like', '%' . $this->search . '%');
            })
            ->where(function ($query) {
                if ($this->sectorSearch !== '') {
                    $query->where('sectors.nombre', 'like', '%' . $this->sectorSearch . '%');
                }
            })
            ->whereBetween('requerimientos.fecha_maxima', [$this->fechaini, $this->fechafin])
            ->where(function ($query) {
                if ($this->status !== '') {
                    $query->where('requerimientos.estado', $this->status);
                }
            })
            ->select('requerimientos.*', 'sectors.nombre as sector', 'tipo_requerimientos.nombre as requerimiento', 'atencions.fecha_atencion', 'atencions.distancia')
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        return view('livewire.coordinador.requerimiento.requerimiento', compact('requerimientos'));
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

        $requerimiento                        = new Requerimient;
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
    public function resetInput()
    {
        $this->codigo_requerimiento      = null;
        $this->nombre_requerimiento      = null;
        $this->cedula_requerimiento      = null;
        $this->telefonos_requerimiento   = null;
        $this->correos_requerimiento     = null;
        $this->direccion_requerimiento   = null;
        $this->sector_id                 = null;
        $this->tipo_id                   = null;
        $this->detalle_requerimiento     = null;
        $this->observacion_requerimiento = null;
        $this->fecha_requerimiento       = null;
        $this->codigo_catastral       = null;
        $this->latitud                   = null;
        $this->longitud                  = null;
        $this->editMode                  = false;
        $this->archivos = [];
        $this->errores = [];

        $this->emit('limpiarCampo');
    }

    public function editRequerimiento($id)
    {
        $this->requerimiento_id = $id;
        $requerimiento = Requerimient::find($id);
        $this->emit('editarRequerimiento', ['observacion_requerimiento' => $requerimiento->observacion, 'sector' => $requerimiento->sector_id,  'tipo' => $requerimiento->tipo_requerimiento_id,  'latitud' => $requerimiento->latitud,  'longitud' => $requerimiento->longitud]);
        $this->codigo_requerimiento      = $requerimiento->codigo;
        $this->cuenta_requerimiento = $requerimiento->cuenta;
        $this->codigo_catastral      = $requerimiento->codigo_catastral;
        $this->nombre_requerimiento      = $requerimiento->nombres;
        $this->cedula_requerimiento      = $requerimiento->cedula;
        $this->telefonos_requerimiento   = $requerimiento->telefonos;
        $this->correos_requerimiento     = $requerimiento->correos;
        $this->direccion_requerimiento   = $requerimiento->direccion;
        $this->sector_id                 = $requerimiento->sector_id;
        $this->tipo_id                   = $requerimiento->tipo_requerimiento_id;
        $this->detalle_requerimiento     = $requerimiento->detalle;
        $this->observacion_requerimiento = $requerimiento->observacion;
        $this->fecha_requerimiento       = $requerimiento->fecha_maxima;
        $this->latitud                   = $requerimiento->latitud;
        $this->longitud                  = $requerimiento->longitud;
        $this->editMode                  = true;
    }
    public function updaRequerimiento($observacion)
    {
        $this->observacion_requerimiento = $observacion;
        $this->updateRequerimiento();
    }
    public function updateRequerimiento()
    {
        $this->validate([

            'codigo_requerimiento'      => 'required|max:100',
            'cuenta_requerimiento'      => 'required|max:100',

            'nombre_requerimiento'      => 'required',
            'codigo_catastral'          => 'required',
            'cedula_requerimiento'      => 'required|max:13',
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
        $requerimiento                        = Requerimient::find($this->requerimiento_id);
        $requerimiento->user_id               = Auth::id();
        $requerimiento->codigo                = $this->codigo_requerimiento;
        $requerimiento->cuenta                = $this->cuenta_requerimiento;
        $requerimiento->nombres               = $this->nombre_requerimiento;
        $requerimiento->cedula                = $this->cedula_requerimiento;
        $requerimiento->codigo_catastral      = $this->codigo_catastral;
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
        // $requerimiento->estado                = $this->estado;
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
        $this->emit('info', ['mensaje' => 'Requerimiento Actualizado Correctamente', 'modal' => '#createRequerimiento']);
        $this->createDisabled = false;
    }
    public function eliminarRequerimiento($id)
    {
        $requerimiento = Requerimient::find($id);
        if (count($requerimiento->documentos) > 0) {
            foreach ($requerimiento->documentos as $key => $documentos) {
                $documento = Document::find($documentos->id);
                $image_path = public_path() . $documento->archivo;
                unlink($image_path);
                $documento->delete();
            }
        }
        $requerimiento->delete();
        $this->emit('info', ['mensaje' => 'Requerimiento creado correctamente Correctamente']);
    }
    public function exportarExcel()
    {
        $this->exporting = true;
        $requerimientos = Requerimient::leftJoin('sectors',  'sectors.id',  '=', 'requerimientos.sector_id',)
            ->leftJoin('tipo_requerimientos', 'tipo_requerimientos.id',  '=', 'requerimientos.tipo_requerimiento_id')
            ->leftJoin('atencions', 'requerimientos.id', '=', 'atencions.requerimiento_id')
            ->where(function ($query) {
                $query->where('nombres', 'like', '%' . $this->search . '%')
                    ->orWhere('codigo_catastral', 'like', '%' . $this->search . '%')
                    ->orWhere('direccion', 'like', '%' . $this->search . '%')
                    ->orWhere('codigo', 'like', '%' . $this->search . '%')
                    ->orWhere('cuenta', 'like', '%' . $this->search . '%')
                    ->orWhere('cedula', 'like', '%' . $this->search . '%');
            })
            ->where(function ($query) {
                if ($this->sectorSearch !== '') {
                    $query->where('sectors.nombre', 'like', '%' . $this->sectorSearch . '%');
                }
            })
            ->whereBetween('requerimientos.fecha_maxima', [$this->fechaini, $this->fechafin])
            ->where(function ($query) {
                if ($this->status !== '') {
                    $query->where('requerimientos.estado', $this->status);
                }
            })
            ->select('requerimientos.*', 'sectors.nombre as sector', 'tipo_requerimientos.nombre as requerimiento', 'atencions.fecha_atencion', 'atencions.distancia')
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->get();

        // dd($requerimientos[6]);

        return Excel::download(new RequerimientoExport($requerimientos), date('d-m-y') . '-requerimientos.xlsx');
        $this->exporting = false;
    }
}
