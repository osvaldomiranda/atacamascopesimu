<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;

class UsersController extends Controller
{
    public function index()
    {
        return User::orderBy('name')->get();
    }

    public function currentUser(Request $request){
        $user = Auth::user();
        return response()->json($user);
    }
}
