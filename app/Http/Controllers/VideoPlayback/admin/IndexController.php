<?php

namespace App\Http\Controllers\VideoPlayback\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
    	return view('videoplayback.layouts.index');
    }
}
