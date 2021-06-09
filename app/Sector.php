<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
     public function requerimientos()
     {
         return $this->hasMany('App\Requerimiento');
     }
}
