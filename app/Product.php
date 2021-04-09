<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
      public function medida()
     {
         return $this->belongsTo('App\Medida');
     }
}