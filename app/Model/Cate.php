<?php

namespace App\Model;

use Illuminate\Database\Eloquent\model;

class Cate extends Model
{
    protected $table = 'cate';
    protected $primarykey = 'cate_id';
    public $timestamps = false;
    protected $guarded = [];
}
