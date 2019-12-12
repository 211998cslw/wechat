<?php

namespace App\Model\Mini;

use Illuminate\Database\Eloquent\model;

class kaoGoods extends Model
{
    protected $table = 'kao_goods';
    protected $primarykey = 'g_id';
    public $timestamps = false;
    protected $guarded = [];
}
