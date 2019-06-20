<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Reservation;
use App\points;


class ReservationController extends Controller
{

    public function index(){
        $reservations = Reservation::with('equipment')->whereDate('date','>=',Carbon::now())->get();
        return response()->json($reservations);
    }

    public function myReservations(Request $request){
        $reservations = Reservation::with('equipment')->whereDate('date','>=',Carbon::now())->where('user_id', 3)-> get();
        return response()->json($reservations);
    }
    public function reservations(Request $request){

        $equipment_id = $request->input('equipment_id');
        $date = $request->input('date');

        $reservations = Reservation::whereDate('date','=',$date)->where('equipment_id',$equipment_id)-> get();
        return response()->json($reservations);
    }

    public function create(Request $request){

        $this->validate($request, [
            'user_id' => 'required',
            'equipment_id' => 'required',
            'date' => 'required',
            'hour' => 'required',
            'points_out' => 'required',
            'current_points' => 'required',
        ]);

        $reservation = new Reservation();
        $reservation->user_id       = Auth::id();
        $reservation->equipment_id  = $request->input('equipment_id');
        $reservation->date          = $request->input('date');
        $reservation->hour          = $request->input('hour');
        $reservation->points_out    = $request->input('points_out');
        $reservation->state         = 'CREADA';
        $reservation->save();

        $points = new Points();
        $points->user_id        = Auth::id();
        $points->reservation_id = $reservation->id;
        $points->in             = 0;
        $points->out            = $reservation->points_out;
        $points->current_points = $request->input('current_points');
        $points->save();

    }
}
