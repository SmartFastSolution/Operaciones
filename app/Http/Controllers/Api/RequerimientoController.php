<?php

namespace App\Http\Controllers\Api;

use App\Atencion;
use App\Document;
use App\Http\Controllers\Controller;
use App\Requerimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class RequerimientoController extends Controller
{
    public function index()
    {
    	$fabricantes=Cache::remember('cachefabricantes',15/60,function()
		{
			
			return Requerimiento::simplePaginate(10);  // Paginamos cada 10 elementos.

		});

		return response()->json(['status'=>'ok', 'siguiente'=>$fabricantes->nextPageUrl(),'anterior'=>$fabricantes->previousPageUrl(),'data'=>$fabricantes->items()],200);
    }
    public function show($id)
    {
    	// Corresponde con la ruta /fabricantes/{fabricante}
		// Buscamos un fabricante por el ID.
		$requerimientos=Requerimiento::where('operador_id', $id)->get();

		// Chequeamos si encontró o no el requerimiento
		if (count($requerimientos) == 0) 
		{
			// Se devuelve un array errors con los errores detectados y código 404
			return response()->json(['errors'=>Array(['code'=>404,'message'=>'No se encuentra requerimientos para este operador.'])],404);
		}

		// Devolvemos la información encontrada.
		return response()->json(['status'=>'ok','data'=>$requerimientos],200);
    }
    public function store(Request $request)
    {
    	  $request->validate([
            'detalle_atencion'     => 'required',
            'observacion_atencion' => 'required',
            'fecha_atencion'       => 'required',
            'longitud'             => 'required',
            'latitud'              => 'required',
            // 'archivos.*' => 'mimes:pdf'
        ],[
            'fecha_atencion.required'       => 'No has seleccionado la fecha de atencion',
            'detalle_atencion.required'     => 'No has agregado el detalle de la atencion',
            'observacion_atencion.required' => 'No has agregado la observacion',
            'longitud.required'             => 'No has agregado la ubicacion georeferenciada',
            'latitud.required'              => 'No has agregado la ubicacion georeferenciada',
        ]); 
    
		$atencion                   =  new Atencion;
		$atencion->requerimiento_id = $request->requerimiento_id;
		$atencion->coordinador_id   = $request->coordinador_id;
		$atencion->operador_id      = $request->operador_id;
		$atencion->detalle          = $request->detalle_atencion;
		$requerimiento              = Requerimiento::find($request->requerimiento_id);

        $atencion->distancia        = $this->distanciaAtencion($request->latitud, $request->longitud, $requerimiento->latitud, $requerimiento->longitud);
        $atencion->observacion      = $request->observacion_atencion;
        $atencion->fecha_atencion   = $request->fecha_atencion;
        $atencion->latitud          = $request->latitud;
        $atencion->longitud         = $request->longitud;
        $atencion->save();

        if ($request->hasFile('archivos')) {
			   if (count($request->archivos) > 0) {
                foreach ($request->archivos as $archivo) {
                $nombre   = time().'_'.$archivo->getClientOriginalName();
                $urldocumento  = '/atenciones/'.$nombre;
                $archivo->storeAs('atenciones',  $nombre, 'public_upload');
                $documento = new Document(['nombre'=> $archivo->getClientOriginalName(), 'extension'=> pathinfo($urldocumento, PATHINFO_EXTENSION), 'archivo'=>$urldocumento]);
                $atencion->documentos()->save($documento);
               }
        }
		}

        $requerimiento->estado = 'ejecutado';
        $requerimiento->operador_id = $request->operador_id;
        $requerimiento->save();
	
		return response()->json(['status'=>'Atención Realizada Correctamente','data'=>$atencion],201);
    }

        public function distanciaAtencion($latitud, $longitud, $re_ltd, $re_lgt)
    {
		$rlat0    = deg2rad($re_ltd);
		$rlng0    = deg2rad($re_lgt);
		$rlat1    = deg2rad($latitud);
		$rlng1    = deg2rad($longitud);
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
}
