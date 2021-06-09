<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConversionUnidad extends Model
{
         public function medida()
     {
         return $this->belongsTo('App\Medida', 'medida_conversion');
     }
}
