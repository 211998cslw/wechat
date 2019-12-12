<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
    protected $table = 'login';
   // protected $primarykey = 'user_id';
    public $timestamps = false;
    protected $guarded = [];
}
