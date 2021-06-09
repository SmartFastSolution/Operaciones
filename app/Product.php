<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
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
}