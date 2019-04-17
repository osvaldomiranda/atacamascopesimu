<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AstronomicObject;

class AstronomicObjectController extends Controller
{
    public function index()
    {
    	$astronomicObjects = AstronomicObject::all()->toArray();
    	return response()->json($astronomicObjects);
    }
}
