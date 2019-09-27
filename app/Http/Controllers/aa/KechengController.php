<?php

namespace App\Http\Controllers\aa;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KechengController extends Controller
{
    //课程列表
    public function k_list()
    {
        return view('aa.kecheng.k_list');
    }
}
