<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todolist extends Model
{
    protected $table = "todolist";
    public $timestamps = false;
    protected $fillable = ['id','item','status','thing_id'];
}
