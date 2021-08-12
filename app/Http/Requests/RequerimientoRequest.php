<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequerimientoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'codigo_requerimiento'      => 'required|max: 100',
            'cuenta_requerimiento'      => 'required|max: 100',
            'nombre_requerimiento'      => 'required',
            'cedula_requerimiento'      => 'required|max: 13',
            'codigo_catastral'          => 'required',
            'telefonos_requerimiento'   => 'required',
            'correos_requerimiento'     => 'required',
            'direccion_requerimiento'   => 'required',
            'fecha_requerimiento'       => 'required',
            'detalle_requerimiento'     => 'required',
            // 'observacion_requerimiento' => 'required',
            'tipo_requerimiento_id'     => 'required',
            'sector_id'                 => 'required',
            'longitud'                  => 'required',
            'latitud'                   => 'required',
            'archivos.*'                => 'max: 51200|mimes: xls,doc,docx,pdf,jpg,jpeg,png',
        ];
    }
    public function messages()
    {
        $messages = [
            'cuenta_requerimiento.required'      => 'No has agregado la cuenta',
            'codigo_requerimiento.required'      => 'No has agregado el codigo del Requerimiento',
            'codigo_requerimiento.max'           => 'El limite del codigo sobrepasa lo permitido',
            'nombre_requerimiento.required'      => 'No has agregado el nombre del Requerimiento',
            'codigo_catastral.required'          => 'No has agregado el codigo catastral',
            'cedula_requerimiento.required'      => 'No has agregado la cedula',
            'telefonos_requerimiento.required'   => 'No has agregado los telefonos',
            'correos_requerimiento.required'     => 'No has agregado la correos',
            'direccion_requerimiento.required'   => 'No has agregado la direccion',
            'fecha_requerimiento.required'       => 'No has agregado la fecha maxima',
            'detalle_requerimiento.required'     => 'No has agregado el  detalle',
            'observacion_requerimiento.required' => 'No has agregado la observacion',
            'tipo_requerimiento_id.required'     => 'No has seleccionado el tipo de requerimiento',
            'sector_id.required'                 => 'No has seleccionado el sector',
            'longitud.required'                  => 'No has seleccionado la latitud',
            'latitud.required'                   => 'No has seleccionado la longitud',
        ];
        if ($this->files->has('archivos')) {
            foreach ($this->files->get('archivos') as $key => $val) {
                $messages['archivos.' . $key . '.mimes'] = 'El Archivo  "' . ($key + 1) . '" debe ser un archivo de tipo: xls, doc, docx, pdf, jpg, jpeg, png';
            }
        }

        return $messages;
        // return [];
    }
    // public function attributes()
    // {
    //     return [
    //         'archivos.*'   => 'Archivo',
    //     ];
    // }
}
