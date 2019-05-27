<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Reservation;


class ReservationController extends Controller
{

    public function index(){
        $reservations = Reservation::with('equipment')->whereDate('date','>=',Carbon::now())->get();
        return response()->json($reservations);
    }

    public function myReservations(Request $request){
        $user_id = $request->header('user');
        $reservations = Reservation::with('equipment')->whereDate('date','>=',Carbon::now())->where('user_id',$user_id)-> get();
        return response()->json($reservations);
    }
    public function reservations(Request $request){

        $equipment_id = $request->input('equipment_id');
        $date = $request->input('date');

        $reservations = Reservation::whereDate('date','=',$date)->where('equipment_id',$equipment_id)-> get();
        return response()->json($reservations);
    }
}
