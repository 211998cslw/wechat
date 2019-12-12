<?php

namespace App\Model\Mini;

use Illuminate\Database\Eloquent\model;

class Nav extends Model
{
    protected $table = 'nav';
    protected $primarykey = 'nav_id';
    public $timestamps = false;
    protected $guarded = [];
}
