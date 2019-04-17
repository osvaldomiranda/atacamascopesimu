<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommandController extends Controller
{
    public function move(request $request){
    	Info($request);

    }
    public function shoot(request $request){
    	Info($request);
    }
    public function focus(request $request){
    	Info($request);
    }
}
