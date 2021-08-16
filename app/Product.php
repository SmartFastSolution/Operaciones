<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $appends = ['producto', 'precio_iva'];

    public function medida()
    {
        return $this->belongsTo('App\Medida');
    }
    public function ingresos()
    {
        return $this->belongsToMany('App\Ingreso')->withPivot('cantidad', 'total');
        // return $this->belongsToMany('App\Materia','distribucion_curso_materia');
    }
    public function egresos()
    {
        return $this->belongsToMany('App\Egreso')->withPivot('cantidad', 'cantidad_real', 'total');
        // return $this->belongsToMany('App\Materia','distribucion_curso_materia');
    }
    public function getProductoAttribute()
    {
        return "{$this->nombre}, {$this->presentacion} {$this->medida->simbolo} ";
    }
    public function getPrecioIvaAttribute()
    {
        $iva = $this->porcentual ? $this->iva : 0;
        $inpuesto = ($this->precio_venta * $iva) / 100;
        return $this->precio_venta + $inpuesto;
    }
}
