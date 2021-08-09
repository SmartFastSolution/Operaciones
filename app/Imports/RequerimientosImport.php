<?php

namespace App\Imports;

use App\Requerimiento;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class RequerimientosImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // dd($row);
        return new Requerimiento([
            'user_id'          => Auth::id(),
            'codigo'                => $row['codigo'],
            'cuenta'                => $row['cuenta'],
            'codigo_catastral'      => $row['codigo_catastral'],
            'nombres'               => $row['nombres'],
            'telefonos'             => $row['telefonos'],
            'correos'               => $row['correos'],
            'direccion'             => $row['direccion'],
            'tipo_requerimiento_id' => $row['codigo_requerimiento'],
            'detalle'               => $row['tipo_requerimiento'],
            'cedula'                => $row['cedula'],
            'observacion'           => $row['observacion'],
            'fecha_maxima'          => $row['fecha_maxima'],
            'latitud'               => $row['geolocalizacion_latitud']  = 0 ? -2.191643226627306 : $row['geolocalizacion_latitud'],
            'longitud'              => $row['geolocalizacion_longitud'] = 0 ? -79.87951092125624 : $row['geolocalizacion_longitud'],
            'estado'                => 'pendiente',
        ]);
    }

    public function rules(): array
    {
        return [
            'codigo'           => 'required',
            'cuenta'           => 'required',
            'codigo_catastral' => 'required',
            'nombres'          => 'required',
            // 'telefonos'        => 'required',
            // 'correos'          => 'required',
            'direccion'        => 'required',
            // 'detalles'          => 'required',
            'cedula'           => 'required',
            // 'observacion'      => 'required',
            // 'fecha_maxima'     => 'required',
        ];
    }
}


// codigo
// cuenta
// codigo_catastral
// nombres
// telefonos
// correos
// direccion
// detalle
// cedula
// observacion
// fecha_maxima
// latitud
// longitud
  // "codigo" => 77
  // "cuenta" => 822
  // "codigo_catastral" => 57539033
  // "nombres" => "Amparo Armijo"
  // "cedula" => 26682468
  // "telefonos" => 89936355
  // "correos" => "tsoriano@example.org"
  // "direccion" => "Ea commodi ullam quibusdam perferendis harum harum."
  // "sector" => "La Chala"
  // "fecha_maxima" => "2021-04-05"
  // "tipo_de_requerimiento" => "Consumo"
  // "detalles" => "Officiis ipsa reiciendis saepe."
  // "observacion" => "Est mollitia fuga voluptate ab et ab culpa."
  // "geolocalizacion_latitud" => -2.2407946587726
  // "geolocalizacion_longitud" => -79.903635789205
  // "estado" => "ejecutado"
  // "" => null
