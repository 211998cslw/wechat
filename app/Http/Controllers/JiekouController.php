<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JiekouController extends Controller
{
    public function jiekou(request $request)
    {
    	  $info = $request->all();
           dd($info);
    }
}
