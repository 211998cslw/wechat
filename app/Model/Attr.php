<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Attr extends Model
{
    protected $table = 'attribute';
    protected $primarykey = 'attr_id';
    public $timestamps = false;
    protected $guarded = [];
}
