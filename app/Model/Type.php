<?php

namespace App\model;

use Illuminate\Database\Eloquent\model;

class Type extends Model
{
    protected $table = 'type';
    protected $primarykey = 'type_id';
    public $timestamps = false;
    protected $guarded = [];
}
