<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp;
use App\Weather;

class ExternalsController extends Controller
{
    public function weather(request $request)
    {
    	$weather = Weather::all()->last();

    	$response =json_decode($weather->weather);

    	return response()->json($response);
    }

    public function weatherNew(request $request)
    {
    	$client = new GuzzleHttp\Client();

    	$res = $client->request('GET', 'http://dataservice.accuweather.com/currentconditions/v1/57225?apikey=7YlJ6XDONbNu6AKx7mVd7NAgs8AXCGcr&language=es-cl&details=false');

    	$response = $res->getBody()->getContents();

    	$weather = new Weather();
    	$weather->weather = $response;
    	$weather->save();
    }
}
