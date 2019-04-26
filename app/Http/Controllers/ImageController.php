<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Storage;
use App\Image;
use App\Events\MessageSent;
use App\Message;


class ImageController extends Controller
{
    public function upload(request $request)
    {
    	
    	if($request->hasFile('photo')){
    		$path = $request->photo->store('public');

            $filename = substr($path,7,100);
            $path = 'http://10.200.112.215/storage/' . $filename;

    		$image = new Image;
    		$image->name = 'Hola.jpg';
    		$image->path = $path;
    		$image->user_id = 1;
    		$image->equipment_id = 1;
    		$image->save();

            $message = Message::create([
                'sender_id'   => 1,
                'receiver_id' => 2,
                'message'     => 'Imagen Recibida',
            ]);

            broadcast(new MessageSent($message));
    	}
    }

    public function last(request $request){
        $image = Image::all()->last();
        return response()->json($image->path);
    }

    public function index(request $request){
        $images = Image::all();
        return response()->json($images);
    }
}
