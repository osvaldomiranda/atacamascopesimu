<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class LocaleController extends Controller
{
    public function es(Request $request)
    {
    	App::setLocale('es');
    	return view("welcome");
    }
    public function en(Request $request)
    {
    	App::setLocale('en');
    	return view("welcome");
    }
}
