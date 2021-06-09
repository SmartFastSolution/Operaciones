<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medida extends Model
{
     public function conversiones()
     {
         return $this->hasMany('App\ConversionUnidad', 'medida_base');
     }
}
