<?php

namespace App\Http\Controllers\Coordinador;

use App\User;
use App\Egreso;
use App\Medida;
use App\Sector;
use App\Product;
use App\Atencion;
use App\Document;
use App\Requerimiento;
use App\ConversionUnidad;
use App\TipoRequerimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RequerimientoRequest;
use App\Traits\RequerimientoTrait;

class RequerimientoController extends Controller
{
    use RequerimientoTrait;
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {

        $sectores = Sector::where('estado', 'on')->get(['id', 'nombre']);
        $tipos    = TipoRequerimiento::where('estado', 'on')->get(['id', 'nombre']);
        return view('coordinador.requerimientos.index', compact('sectores', 'tipos'));
    }
    public function create()
    {
        $sectores = Sector::where('estado', 'on')->get(['id', 'nombre']);
        $tipos    = TipoRequerimiento::where('estado', 'on')->get(['id', 'nombre']);
        return view('coordinador.requerimientos.create', compact('sectores', 'tipos'));
    }
    public function show($id)
    {
        $requerimiento = Requerimiento::find($id, ['id', 'latitud', 'longitud', 'operador_id', 'estado']);
        $operadores    = User::select('id', 'nombres')->role('operador')->get();

        // return $operadores;
        return view('coordinador.requerimientos.show', compact('id', 'requerimiento', 'operadores'));
    }
    public function asignacion()
    {
        $operadores  = User::select('id', 'nombres')->role('operador')->withCount('requerimientos')->get();
        // return $operadores;

        return view('coordinador.requerimientos.asignacion', compact('operadores'));
    }
    public function datos($id)
    {
        $requerimiento = Requerimiento::with([
            'documentos',
            'atencion',
            'atencion.documentos',
            'coordinador' => function ($query) {
                $query->select('id', 'nombres');
            },
            'sector' => function ($query) {
                $query->select('id', 'nombre');
            },
            'tipo' => function ($query) {
                $query->select('id', 'nombre');
            }
        ])->find($id);

        $imagenes = $requerimiento->documentos->whereIn('extension',  ['png', 'jpeg', 'jpg'])->pluck('archivo');
        $atencionImg = [];
        if ($requerimiento->atencion) {
            $atencionImg = $requerimiento->atencion->documentos->whereIn('extension',  ['png', 'jpeg', 'jpg'])->pluck('archivo');
        }

        return response(array(
            'success'          => true,
            'requerimiento'    => $requerimiento,
            'img_requerimient' => $imagenes,
            'img_atencion'     => $atencionImg
        ), 200, []);
        // return $requerimiento;
    }
    public function atencion($id)
    {
        $requerimiento   = Requerimiento::find($id);
        // $this->authorize('view', $requerimiento);
        if ($requerimiento->estado == 'ejecutado') {
            return redirect()->back()->with('error', 'Este requerimiento ya fue atendido');
        }
        $productos = Product::where('estado', 'on')->with(['medida' => function ($query) {
            $query->select('id', 'simbolo');
        }])->get();
        $conversiones = ConversionUnidad::all(['id', 'medida_base', 'medida_conversion', 'factor']);
        $medidas = Medida::all(['id', 'unidad', 'simbolo']);
        // $codigo_atencion = Codigo::where('estado' , 'on')->get(['id', 'codigo']);
        // $series          = Serie::where('estado' , 'on')->get(['id', 'nombre', 'serie']);
        // foreach ($codigo_atencion as $key => $codigo) {
        //     $codigo_atencion[$key]->codigo = 'Codigo '. $codigo->codigo;
        // }
        // foreach ($series as $k => $serie) {
        //     $series[$k]->serie = '#'.$serie->serie;
        // }
        $operadores      = User::where('estado', 'on')->select('id', 'nombres')->role('operador')->get();
        return view('coordinador.requerimientos.atencion', compact('id', 'requerimiento', 'operadores', 'productos', 'conversiones', 'medidas'));
    }
    public function distanciaAtencion($latitud, $longitud, $id)
    {
        $requerimiento = Requerimiento::find($id);

        $rlat0 = deg2rad($requerimiento->latitud);
        $rlng0 = deg2rad($requerimiento->longitud);
        $rlat1 = deg2rad($latitud);
        $rlng1 = deg2rad($longitud);
        $latDelta = $rlat1 - $rlat0;
        $lonDelta = $rlng1 - $rlng0;
        $distance = (6371 *
            acos(
                cos($rlat0) * cos($rlat1) * cos($lonDelta) +
                    sin($rlat0) * sin($rlat1)
            ));


        return $distance;
    }
    public function store(Request $request, $id)
    {
        $request->validate([
            'operador_id'      => 'required',
            'detalle_atencion' => 'required',
            'observacion'      => 'required',
            'fecha_atencion'   => 'required',
            'latitud'          => 'required',
            'longitud'         => 'required',
            'codigo'           => 'required_if:egreso,true',
            'descripcion'      => 'required_if:egreso,true',
            'total_egreso'     => 'required_if:egreso,true',
            'archivos.*'       => 'max:51200|mimes:jpg,jpeg,png,csv,txt,xlx,xls,pdf',

        ], [
            'operador_id'      => 'No has seleccionado al operador',
            'detalle_atencion.required' => 'No has agregado el detalle de la atenci??n',
            'observacion.required'      => 'No has agregado la observaci??n de la atenci??n',
            'fecha_atencion.required'   => 'No has agregado la fecha de atencion',
            'codigo.required_if'  => 'No has seleccionado el codigo de egreso',
            'descripcion.required_if'  => 'No has seleccionado la descripcion del egreso',
            'total_egreso.required_if'  => 'No has seleccionado el total del egreso',

        ]);
        DB::beginTransaction();
        try {

            $atencion                   =  new Atencion;
            $atencion->requerimiento_id = $id;
            $atencion->coordinador_id   = Auth::id();
            $atencion->operador_id      = $request->operador_id;
            $atencion->detalle          = $request->detalle_atencion;
            $atencion->observacion      = $request->observacion;
            $atencion->distancia        = $this->distanciaAtencion($request->latitud, $request->longitud, $id);
            $atencion->fecha_atencion   = $request->fecha_atencion;
            $atencion->latitud          = $request->latitud;
            $atencion->longitud         = $request->longitud;
            $atencion->save();

            if ($request->has('egreso')) {
                $this->storeEgreso($request->only('codigo', 'descripcion', 'total_egreso', 'items'), $atencion);
            }
            $requerimiento              = Requerimiento::find($id);
            $requerimiento->estado      = 'ejecutado';
            $requerimiento->operador_id = $request->operador_id;
            $requerimiento->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            // $error = LogError::create(['payload' => 'Error al aprobar la solicitud de abastecimiento', 'exception' => $e->getMessage()]);
            return response()->json(['message' => 'Ocurrio un error al realizar el proceso, revisa tu registro de errores'], 501);
        }
        if ($request->numero > 0) {
            foreach ($request->archivos as $archivo) {
                $nombre       = time() . '_' . $archivo->getClientOriginalName();
                $urldocumento = '/atenciones/' . $nombre;
                $archivo->storeAs('atenciones',  $nombre, 'public_upload');
                $documento    = new Document(['nombre' => $archivo->getClientOriginalName(), 'extension' => pathinfo($urldocumento, PATHINFO_EXTENSION), 'archivo' => $urldocumento]);
                $atencion->documentos()->save($documento);
            }
        }
        return response()->json(['message' => 'Atencion Realizada Correctamente'], 201);
    }
    public function edit($id, $a)
    {
        $atencion = Atencion::with(['documentos', 'egreso', 'egreso.productos' => function ($query) {
            $query->select('products.id');
        }])->findOrFail($a);
        // return $atencion;
        if ($atencion->requerimiento_id != $id) {
            return abort(404);
        }
        $requerimiento   = Requerimiento::find($id);
        $productos = Product::where('estado', 'on')->with(['medida' => function ($query) {
            $query->select('id', 'simbolo');
        }])->get();
        $conversiones = ConversionUnidad::all(['id', 'medida_base', 'medida_conversion', 'factor']);
        $medidas = Medida::all(['id', 'unidad', 'simbolo']);

        $operadores      = User::where('estado', 'on')->select('id', 'nombres')->role('operador')->get();
        return view('coordinador.requerimientos.edit', compact('id', 'requerimiento', 'operadores', 'productos', 'conversiones', 'medidas', 'atencion'));
    }
    public function update(Request $request, $id, $atencion)
    {
        $request->validate([
            'operador_id'      => 'required',
            'detalle_atencion' => 'required',
            'observacion'      => 'required',
            'fecha_atencion'   => 'required',
            'latitud'          => 'required',
            'longitud'         => 'required',
            'codigo'           => 'required_if:egreso,true',
            'descripcion'      => 'required_if:egreso,true',
            'total_egreso'     => 'required_if:egreso,true',
            'archivos.*'       => 'max:51200|mimes:jpg,jpeg,png,csv,txt,xlx,xls,pdf',

        ], [
            'operador_id'      => 'No has seleccionado al operador',
            'detalle_atencion.required' => 'No has agregado el detalle de la atenci??n',
            'observacion.required'      => 'No has agregado la observaci??n de la atenci??n',
            'fecha_atencion.required'   => 'No has agregado la fecha de atencion',
            'codigo.required_if'  => 'No has seleccionado el codigo de egreso',
            'descripcion.required_if'  => 'No has seleccionado la descripcion del egreso',
            'total_egreso.required_if'  => 'No has seleccionado el total del egreso',

        ]);


        $atencion                   =  Atencion::find($atencion);
        $atencion->coordinador_id   = Auth::id();
        $atencion->operador_id      = $request->operador_id;
        $atencion->detalle          = $request->detalle_atencion;
        $atencion->observacion      = $request->observacion;
        $atencion->distancia        = $this->distanciaAtencion($request->latitud, $request->longitud, $id);
        $atencion->fecha_atencion   = $request->fecha_atencion;
        $atencion->latitud          = $request->latitud;
        $atencion->longitud         = $request->longitud;
        $atencion->save();

        if ($request->numero > 0) {
            foreach ($request->archivos as $archivo) {
                $nombre       = time() . '_' . $archivo->getClientOriginalName();
                $urldocumento = '/atenciones/' . $nombre;
                $archivo->storeAs('atenciones',  $nombre, 'public_upload');
                $documento    = new Document(['nombre' => $archivo->getClientOriginalName(), 'extension' => pathinfo($urldocumento, PATHINFO_EXTENSION), 'archivo' => $urldocumento]);
                $atencion->documentos()->save($documento);
            }
        }


        if (isset($request->egreso)) {
            if (!isset($atencion->egreso)) {
                $egreso = new Egreso;
            } else {
                $egreso = Egreso::find($atencion->egreso->id);

                foreach ($egreso->productos as $key => $producto) {
                    $produc           = Product::find($producto->id);
                    $cantidad         = intval($produc->cantidad) + $producto->pivot->cantidad_real;
                    $stock            = $cantidad / $produc->presentacion;
                    $produc->cantidad = $cantidad;
                    $produc->stock    = $stock;
                    $produc->save();
                }
            }
            $egreso->codigo       = $request->codigo;
            $egreso->descripcion  = $request->descripcion;
            $egreso->atencion_id  = $atencion->id;
            $egreso->total_egreso = $request->total_egreso;
            $egreso->save();


            $productos = json_decode($request->items, true);
            // $items = $request->items;
            $relacion = [];
            foreach ($productos as $key => $producto) {
                $produc           = Product::find($producto['id']);
                $cantidad         = intval($produc->cantidad) - $producto['cantidad_unidad'];
                $stock            = $cantidad / $produc->presentacion;
                $produc->cantidad = $cantidad;
                $produc->stock    = $stock;
                $produc->save();
                $relacion[$producto['id']] = array(
                    "cantidad"      => $producto['cantidad_unidad'],
                    "cantidad_real" => $producto['cantidad_base'],
                    "total"         => $producto['total'],
                );
            }
            $egreso->productos()->sync($relacion);
        }

        $requerimiento              = Requerimiento::find($id);
        $requerimiento->estado      = 'ejecutado';
        $requerimiento->operador_id = $request->operador_id;
        $requerimiento->save();
    }
    public function storeRequerimiento(RequerimientoRequest $request)
    {
        $requerimiento                        = new Requerimiento;
        $requerimiento->user_id               = Auth::id();
        $requerimiento->codigo                = $request->codigo_requerimiento;
        $requerimiento->cuenta                = $request->cuenta_requerimiento;
        $requerimiento->nombres               = $request->nombre_requerimiento;
        $requerimiento->codigo_catastral      = $request->codigo_catastral;
        $requerimiento->cedula                = $request->cedula_requerimiento;
        $requerimiento->telefonos             = $request->telefonos_requerimiento;
        $requerimiento->correos               = $request->correos_requerimiento;
        $requerimiento->direccion             = $request->direccion_requerimiento;
        $requerimiento->sector_id             = $request->sector_id;
        $requerimiento->tipo_requerimiento_id = $request->tipo_requerimiento_id;
        $requerimiento->detalle               = $request->detalle_requerimiento;
        $requerimiento->observacion           = $request->observacion_requerimiento;
        $requerimiento->fecha_maxima          = $request->fecha_requerimiento;
        $requerimiento->latitud               = $request->latitud;
        $requerimiento->longitud              = $request->longitud;
        $requerimiento->estado                = 'pendiente';
        $requerimiento->save();

        if ($request->hasFile('archivos')) {
            foreach ($request->archivos as $archivo) {
                $nombre   = time() . '_' . $archivo->getClientOriginalName();
                $urldocumento  = '/requerimientos/' . $nombre;
                $archivo->storeAs('requerimientos',  $nombre, 'public_upload');
                $documento = new Document(['nombre' => $archivo->getClientOriginalName(), 'extension' => pathinfo($urldocumento, PATHINFO_EXTENSION), 'archivo' => $urldocumento]);
                $requerimiento->documentos()->save($documento);
            }
        }
        return response()->json(['msg' => 'Requerimiento Creado Correctaemnte', 'link' => route('coordinador.requerimiento.index')], 201);
    }
    public function editRequerimiento(Requerimiento $requerimiento)
    {
        if ($requerimiento->estado == 'ejecutado') {
            abort(403, 'Este Requerimiento ya fue ejecutado');
        }
        $requerimiento->documentos;
        $sectores = Sector::where('estado', 'on')->get(['id', 'nombre']);
        $tipos    = TipoRequerimiento::where('estado', 'on')->get(['id', 'nombre']);
        return view('coordinador.requerimientos.edit_requerimiento', compact('requerimiento', 'sectores', 'tipos'));
    }
    public function updateRequerimiento(Requerimiento $requerimiento, RequerimientoRequest $request)
    {
        DB::beginTransaction();

        try {
            $requerimiento->user_id               = Auth::id();
            $requerimiento->codigo                = $request->codigo_requerimiento;
            $requerimiento->cuenta                = $request->cuenta_requerimiento;
            $requerimiento->nombres               = $request->nombre_requerimiento;
            $requerimiento->codigo_catastral      = $request->codigo_catastral;
            $requerimiento->cedula                = $request->cedula_requerimiento;
            $requerimiento->telefonos             = $request->telefonos_requerimiento;
            $requerimiento->correos               = $request->correos_requerimiento;
            $requerimiento->direccion             = $request->direccion_requerimiento;
            $requerimiento->sector_id             = $request->sector_id;
            $requerimiento->tipo_requerimiento_id = $request->tipo_requerimiento_id;
            $requerimiento->detalle               = $request->detalle_requerimiento;
            $requerimiento->observacion           = $request->observacion_requerimiento;
            $requerimiento->fecha_maxima          = $request->fecha_requerimiento;
            $requerimiento->latitud               = $request->latitud;
            $requerimiento->longitud              = $request->longitud;
            $requerimiento->save();
            $eliminados = json_decode($request->eliminados);
            if (count($eliminados) > 0) {
                foreach ($eliminados as $key => $id) {
                    $docum  = Document::find($id);
                    $image_path = public_path() . $docum->archivo;
                    unlink($image_path);
                    $docum->delete();
                }
            };
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            // $error = LogError::create(['payload' => 'Error al aprobar la solicitud de abastecimiento', 'exception' => $e->getMessage()]);
            return response()->json(['message' => 'Ocurrio un error al realizar el proceso, revisa tu registro de errores'], 501);
        }

        if ($request->hasFile('archivos')) {
            foreach ($request->archivos as $archivo) {
                $nombre   = time() . '_' . $archivo->getClientOriginalName();
                $urldocumento  = '/requerimientos/' . $nombre;
                $archivo->storeAs('requerimientos',  $nombre, 'public_upload');
                $documento = new Document(['nombre' => $archivo->getClientOriginalName(), 'extension' => pathinfo($urldocumento, PATHINFO_EXTENSION), 'archivo' => $urldocumento]);
                $requerimiento->documentos()->save($documento);
            }
        }
        return response()->json(['msg' => 'Requerimiento Actualizado Correctaemnte', 'link' => route('coordinador.requerimiento.index')], 201);
    }
}
