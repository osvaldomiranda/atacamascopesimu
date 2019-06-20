<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Equipment;

class EquipmentController extends Controller
{
	public function index()
    {
        $equipments = Equipment::orderBy('name')->get();
        return response()->json($equipments);
    }
}
