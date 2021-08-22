<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medida extends Model
{
    protected $appends = ['conversion'];

    public function conversiones()
    {
        return $this->hasMany('App\ConversionUnidad', 'medida_base');
    }
    public function getConversionAttribute()
    {
        return "{$this->unidad}, {$this->simbolo}";
    }
}
