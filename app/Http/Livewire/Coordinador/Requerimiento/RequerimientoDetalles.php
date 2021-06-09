<?php

namespace App\Http\Livewire\Coordinador\Requerimiento;

use App\Atencion;
use App\Document;
use App\Product;
use App\Requerimiento;
use Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class RequerimientoDetalles extends Component
{
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    protected $listeners       = ['eliminarDocumento', 'eliminarAtencion','deleteDocumento', 'createRequerimiento', 'cargarUbicacion', 'createMapaAtencion', 'cargarOperador', 'updaAtencion'];
    public $editMode           = false;
    public $createDisabled     = false;
    public $operadorExist      = false;
    public $archivos           = [];
	public $requerimiento_id, $operador_id, $atencion_id, $requerimiento, $detalle_atencion, $observacion_atencion, $longitud, $latitud, $fecha_atencion, $distancia;
	public function mount($id, $operador_id)
	{
        $this->requerimiento_id = $id;
		$this->operador_id = $operador_id;
		
		// dd($this->requerimiento);
	}
    public function render()
    {
        $this->requerimiento = Requerimiento::with([
        'documentos', 
        'atencion', 
        'atencion.documentos', 
        'atencion.egreso', 
        'atencion.egreso.productos', 
        'coordinador' => function($query) {
            $query->select('id', 'nombres');
        },
          'sector' => function($query) {
            $query->select('id','nombre');
        },
         'tipo' => function($query) {
            $query->select('id','nombre');
        }
        ])->find($this->requerimiento_id);

        if ($this->requerimiento->estado == 'ejecutado') {
            $this->distancia = $this->requerimiento->atencion->distancia;
        }
        // dd($this->requerimiento);
        return view('livewire.coordinador.requerimiento.requerimiento-detalles');
    }

    public function calcularDistancia()
    {
         $rlat0 = deg2rad($this->requerimiento->latitud);
        $rlng0 = deg2rad($this->requerimiento->longitud);
        $rlat1 = deg2rad($this->requerimiento->atencion->latitud);
        $rlng1 = deg2rad($this->requerimiento->atencion->longitud);

        $latDelta = $rlat1 - $rlat0;
$lonDelta = $rlng1 - $rlng0;

$distance = (6371 *
    acos(
        cos($rlat0) * cos($rlat1) * cos($lonDelta) +
        sin($rlat0) * sin($rlat1)
    )
);
       // //calculamos la diferencia de entre la longitud de los dos puntos
       // $diferenciaX = $this->requerimiento->latitud - $this->requerimiento->atencion->latitud;

       // //ahora calculamos la diferencia entre la latitud de los dos puntos
       // $diferenciaY = $this->requerimiento->longitud - $this->requerimiento->atencion->longitud;

       // // ahora ponemos en practica el teorema de pitagora para calcular la distancia
       // $distancia = sqrt(pow($diferenciaX,2) + pow($diferenciaY,2));

       return $distance ;
    
    }
      public function distanciaAtencion($latitud, $longitud)
    {
         $rlat0 = deg2rad($this->requerimiento->latitud);
        $rlng0 = deg2rad($this->requerimiento->longitud);
        $rlat1 = deg2rad($latitud);
        $rlng1 = deg2rad($longitud);

        $latDelta = $rlat1 - $rlat0;
$lonDelta = $rlng1 - $rlng0;

$distance = (6371 *
    acos(
        cos($rlat0) * cos($rlat1) * cos($lonDelta) +
        sin($rlat0) * sin($rlat1)
    )
);


       return $distance ;
    
    }
      public function eliminarDocumento($id)
    {
        $documento  = Document::find($id);
        $image_path = public_path().$documento->archivo;
        unlink($image_path);
        $documento->delete();
        $this->emit('info',['mensaje' => 'Archivo Eliminado Correctamente']);
    }

      public function cargarUbicacion($ubicacion)
    {
        $this->latitud  = $ubicacion['lat'];
        $this->longitud = $ubicacion['lng'];
    }

          public function cargarOperador($id)
    {
        $this->operador_id  = $id;
    }
        public function createRequerimiento($observacion)
    {
        $this->observacion_atencion = $observacion;
        $this->crearAtencion();
        
    }
    public function crearAtencion()
    {
        $this->validate([
            'operador_id'          => 'required',
            'detalle_atencion'     => 'required',
            'observacion_atencion' => 'required',
            'fecha_atencion'       => 'required',
            'longitud'             => 'required',
            'latitud'              => 'required',
        ],[
            'operador_id.required'       => 'No has seleccionado el operador',
            'fecha_atencion.required'       => 'No has seleccionado la fecha de atencion',
            'detalle_atencion.required'     => 'No has agregado el detalle de la atencion',
            'observacion_atencion.required' => 'No has agregado la observacion',
            'longitud.required'             => 'No has agregado la ubicacion georeferenciada',
            'latitud.required'              => 'No has agregado la ubicacion georeferenciada',
        ]); 


        $this->createDisabled = true;

    
        $atencion                   =  new Atencion;
        $atencion->requerimiento_id = $this->requerimiento_id;
        $atencion->coordinador_id   = Auth::id();
        $atencion->operador_id      = $this->operador_id;
        $atencion->detalle          = $this->detalle_atencion;
        $atencion->distancia        = $this->distanciaAtencion($this->latitud, $this->longitud);
        $atencion->observacion      = $this->observacion_atencion;
        $atencion->fecha_atencion   = $this->fecha_atencion;
        $atencion->latitud          = $this->latitud;
        $atencion->longitud         = $this->longitud;
        $atencion->save();

            if (count($this->archivos) > 0) {
                foreach ($this->archivos as $archivo) {
                $nombre   = time().'_'.$archivo->getClientOriginalName();
                $urldocumento  = '/atenciones/'.$nombre;
                $archivo->storeAs('atenciones',  $nombre, 'public_upload');
                $documento = new Document(['nombre'=> $archivo->getClientOriginalName(), 'extension'=> pathinfo($urldocumento, PATHINFO_EXTENSION), 'archivo'=>$urldocumento]);
                $atencion->documentos()->save($documento);
               }
        }
        $requerimiento = Requerimiento::find($this->requerimiento_id);
        $requerimiento->estado = 'ejecutado';
        $requerimiento->operador_id = $this->operador_id;
        $requerimiento->save();

        $atencionGeo = array(
            'latitud' => $atencion->latitud,
            'longitud' => $atencion->longitud
        );

         $requerimientoGeo = array(
            'latitud' => $requerimiento->latitud,
            'longitud' => $requerimiento->longitud
        );
        $this->emit('success',['mensaje' => 'Atencion guardada Correctamente', 'modal' => '#atenderRequerimiento']);     
        $this->emit('mapaAtencion',['atencion' => $atencionGeo  , 'requerimiento' => $requerimientoGeo]);     
        $this->createDisabled = false;

         return redirect()->to('/coordinador/requerimiento/'.$this->requerimiento_id);
        // return redirect()->route('coordinador.requerimiento.show', $this->requerimiento_id); 

    }

        public function resetInput()
    {
        // $this->requerimiento_id     = null;
        $this->operador_id          = null;
        $this->detalle_atencion     = null;
        $this->fecha_atencion       = null;
        $this->observacion_atencion = null;
        $this->latitud              = null;
        $this->longitud             = null;
        $this->editMode             = false;
        $this->archivos             = [];
        $this->emit('limpiarCampo');

    }

    public function editAtencion($id)
    {
        $atencion = Atencion::find($id);
        $this->emit('editarAtencion',['observacion_requerimiento' => $atencion->observacion, 'operador_id' => $atencion->operador_id,  'latitud' => $atencion->latitud,  'longitud' => $atencion->longitud ]);
        $this->atencion_id     = $id;
        $this->requerimiento_id     = $atencion->requerimiento_id;
        $this->operador_id          = $atencion->operador_id;
        $this->detalle_atencion     = $atencion->detalle;
        $this->observacion_atencion = $atencion->observacion;
        $this->fecha_atencion       = $atencion->fecha_atencion;
        $this->latitud              = $atencion->latitud;
        $this->longitud             = $atencion->longitud;
        $this->editMode             = true;
        $this->emit('cargarDatos');
    }
    public function updaAtencion($observacion)
    {
        $this->observacion_atencion = $observacion;
        $this->updatedAtencion();
    }
    public function updatedAtencion()
    {
             $this->validate([
            'operador_id'          => 'required',
            'detalle_atencion'     => 'required',
            'observacion_atencion' => 'required',
            'fecha_atencion'       => 'required',
            'longitud'             => 'required',
            'latitud'              => 'required',
        ],[
            'operador_id.required'       => 'No has seleccionado el operador',
            'fecha_atencion.required'       => 'No has seleccionado la fecha de atencion',
            'detalle_atencion.required'     => 'No has agregado el detalle de la atencion',
            'observacion_atencion.required' => 'No has agregado la observacion',
            'longitud.required'             => 'No has agregado la ubicacion georeferenciada',
            'latitud.required'              => 'No has agregado la ubicacion georeferenciada',
        ]); 

        $this->createDisabled = true;

        $atencion                   = Atencion::find($this->atencion_id);
        $atencion->requerimiento_id = $this->requerimiento_id;
        $atencion->coordinador_id   = Auth::id();
        $atencion->operador_id      = $this->operador_id;
        $atencion->detalle          = $this->detalle_atencion;
        $atencion->distancia        = $this->distanciaAtencion($this->latitud, $this->longitud);
        $atencion->observacion      = $this->observacion_atencion;
        $atencion->fecha_atencion   = $this->fecha_atencion;
        $atencion->latitud          = $this->latitud;
        $atencion->longitud         = $this->longitud;
        $atencion->save();

               if (count($this->archivos) > 0) {
                foreach ($this->archivos as $archivo) {
                $nombre   = time().'_'.$archivo->getClientOriginalName();
                $urldocumento  = '/atenciones/'.$nombre;
                $archivo->storeAs('atenciones',  $nombre, 'public_upload');
                $documento = new Document(['nombre'=> $archivo->getClientOriginalName(), 'extension'=> pathinfo($urldocumento, PATHINFO_EXTENSION), 'archivo'=>$urldocumento]);
                $atencion->documentos()->save($documento);
               }
        }

        $this->emit('info',['mensaje' => 'Atencion Actualizada Correctamente', 'modal' => '#atenderRequerimiento']); 
        $this->createMapaAtencion();
        $this->distancia = $this->calcularDistancia();

        // $this->emit('mapaAtencion',['latitud' => $atencion->latitud  , 'longitud' => $atencion->longitud]);     

        $this->createDisabled = false;

    }
          public function deleteDocumento($id)
    {
        $documento  = Document::find($id);
        $image_path = public_path().$documento->archivo;
        unlink($image_path);
        $documento->delete();
        $this->emit('info',['mensaje' => 'Archivo Eliminado Correctamente']);
    }
    public function eliminarAtencion($id)
    {
        $atencion = Atencion::find($id);
        if (count($atencion->documentos) > 0) {
        foreach ($atencion->documentos as $key => $documentos) {
            $documento = Document::find($documentos->id);
            $image_path = public_path().$documento->archivo;
            unlink($image_path);
            $documento->delete();
            }
        }
        if (isset($atencion->egreso)) {
          $egreso =  $atencion->egreso;
        foreach ($egreso->productos as $key => $producto) {
            $produc           = Product::find($producto->id);
            $cantidad         = intval($produc->cantidad) + $producto->pivot->cantidad_real;
            $stock            = $cantidad / $produc->presentacion;
            $produc->cantidad = $cantidad;
            $produc->stock    = $stock;
            $produc->save();
        }
            $egreso->delete();
        }
        $requerimiento = Requerimiento::find($atencion->requerimiento_id, ['id', 'estado']);
        $requerimiento->estado = 'asignado';
        $requerimiento->save();
        $atencion->delete();
        $this->emit('info',['mensaje' => 'Atencion eliminada correctamente Correctamente']);
    }
    public function createMapaAtencion()
    {
        if ($this->requerimiento->estado == 'ejecutado') {
              $requerimiento = Requerimiento::find($this->requerimiento->id);
         $atencion = Atencion::find($this->requerimiento->atencion->id);
        $atencionGeo = array(
            'latitud' => $atencion->latitud,
            'longitud' => $atencion->longitud
        );

         $requerimientoGeo = array(
            'latitud' => $requerimiento->latitud,
            'longitud' => $requerimiento->longitud
        );
        // $this->emit('success',['mensaje' => 'Atencion guardada Correctamente', 'modal' => '#atenderRequerimiento']);     
        $this->emit('mapaAtencion',['atencion' => $atencionGeo  , 'requerimiento' => $requerimientoGeo]);  
        }
       
    }
}
