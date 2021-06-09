<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
	 public function productos()
    {
        return $this->belongsToMany('App\Product')->withPivot('cantidad', 'total', 'precio');
        // return $this->belongsToMany('App\Materia','distribucion_curso_materia');
    }
}
