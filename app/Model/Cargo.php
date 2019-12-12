<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    protected $table = 'cargo';
    protected $primarykey = 'sku_id';
    public $timestamps = false;
    protected $guarded = [];
}
