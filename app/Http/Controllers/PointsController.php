<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Points;


class PointsController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('auth:api');
    // }

    public function index(Request $request)
    {
        $user_id = $request->header('user');

        $points = Points::where('user_id',$user_id)->get();
        return response()->json($points);
    }




    public function pay(request $request){    	
	    $this->validate($request, [
	        'in' => 'required',
	        'out' => 'required',
	        'current_points' => 'required',
	    ]);

	    $points = new Points();
	    $points->current_points	= $request->input('current_points');
	    $points->in				= $request->input('in');
        $points->out			= $request->input('out');
        $points->transaction_id = $request->input('transaction_id');
        $points->reservation_id = $request->input('reservation_id');	
        $points->user_id		= $request->header('user');
        $points->save();
    }


}
