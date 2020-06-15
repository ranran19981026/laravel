<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thing extends Model
{
    protected $table = "thing";
    public $timestamps = false;
    protected $fillable = ['name','work','status','share'];
}
