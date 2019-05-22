<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReservationController extends Controller
{

	public function index(){
    	$reservations = Reservation::whereDate('date','>=',Carbon\Carbon::now())->get();
   	 	return response()->json($reservations);
   	}
	public function myReservations(Request $request){
		$user_id = $request->header('user');
    	$reservations = Reservation::whereDate('date','>=',Carbon\Carbon::now())->where('user_id',$user_id)->get();
   	 	return response()->json($reservations);
   	}
}
