<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Requerimiento extends Model
{
    protected $fillable = [
        'user_id', 'codigo', 'codigo_catastral', 'nombres',
        'telefonos',
        'cuemta',
        'correos',
        'direccion',
        'sector_id',
        'tipo_requerimiento_id',
        'detalle',
        'cedula',
        'observacion',
        'fecha_maxima',
        'latitud',
        'longitud',
        'estado',


    ];
    public function documentos()
    {
        return $this->morphMany('App\Document', 'documentable');
    }
    public function coordinador()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    public function sector()
    {
        return $this->belongsTo('App\Sector');
    }
    public function tipo()
    {
        return $this->belongsTo('App\TipoRequerimiento', 'tipo_requerimiento_id');
    }
    public function atencion()
    {
        return $this->hasOne('App\Atencion');
    }
    public function operador()
    {
        return $this->belongsTo('App\User', 'operador_id');
    }
}
