<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Atencion extends Model
{
       public function requerimiento()
     {
         return $this->belongsTo('App\Requerimiento');
     }
       public function documentos(){
        return $this->morphMany('App\Document', 'documentable');
    }
       public function egreso()
     {
         return $this->hasOne('App\Egreso');
     }
}
