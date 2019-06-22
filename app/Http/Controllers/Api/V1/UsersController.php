<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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

 
    public function save_avatar(Request $request)
    {
        $user = Auth::user();
       	
        request()->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

		if($request->hasFile('avatar')){
            $file = $request->file('avatar');

            $filename = 'avatar-' . $user->id  . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('users', $filename);


            $user->avatar =  Storage::url($path);
            $user->save();

        }
        // $check = Image::insertGetId($insert);

        return response()->json($user);
 
    }



}
