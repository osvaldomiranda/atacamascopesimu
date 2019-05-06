<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Points;

class PointsController extends Controller
{
    public function index()
    {
    	$points = Points::where('user_id', Auth::id());

        return response()->json($points);
    }

    public function pay(){
    	
    }
}
