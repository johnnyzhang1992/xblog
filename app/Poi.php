<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Poi extends Model
{
    protected $fillable = ['lat','lng ','poi_name', 'description', 'address'];

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function configuration()
    {
        return $this->morphOne(Configuration::class, 'configurable');
    }

}
