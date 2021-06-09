<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoRequerimiento extends Model
{
     public function requerimientos()
     {
         return $this->hasMany('App\Requerimiento');
     }
}
