<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    protected $fillable = ['config'];
    public $timestamps = false;
    public function configurable()
    {
        return $this->morphTo();
    }

    public function getConfigAttribute($meta)
    {
        $a = json_decode($meta, true);
        return $a ? $a : array();
    }

    public function setConfigAttribute($meta)
    {
        $this->attributes['config'] = json_encode($meta);
    }
}
