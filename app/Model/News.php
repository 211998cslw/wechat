<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'new';
    protected $primarykey = 'new_id';
    public $timestamps = false;
    protected $guarded = [];
}
