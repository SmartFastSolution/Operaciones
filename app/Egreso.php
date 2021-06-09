<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Egreso extends Model
{
     public function productos()
    {
        return $this->belongsToMany('App\Product')->withPivot('cantidad', 'total', 'cantidad_real');
        // return $this->belongsToMany('App\Materia','distribucion_curso_materia');
    }
      public function atencion()
     {
         return $this->hasOne('App\Atencion');
     }
}
