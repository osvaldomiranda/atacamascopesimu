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

        info($request);
       	
        request()->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

		if($request->hasFile('avatar')){
            $file = $request->file('avatar');

            $filename = 'avatar-1' . $user->id  . '.' . $file->getClientOriginalExtension();
            

            $result=Storage::disk('s3')->put($filename, file_get_contents($file), 'public');


            $user->avatar =  Storage::disk('s3')->url($filename);
            $user->save();

        }
        // $check = Image::insertGetId($insert);

        return response()->json($user);
 
    }

    public function avatar_url(Request $request)
    {
        $user = Auth::user();

    }


}
