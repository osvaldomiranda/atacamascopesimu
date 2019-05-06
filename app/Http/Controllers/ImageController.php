<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Storage;
use App\Image;
use App\Events\MessageSent;
use App\Message;
use App\Command;


class ImageController extends Controller
{
    public function upload($command_id, request $request)
    {
        $command = Command::where('id', $command_id)->get()->first();
    	
    	if($request->hasFile('photo')){
    		$path = $request->photo->store('public');

            $filename = substr($path,7,100);
            $path = 'http://18.236.139.196/storage/' . $filename;

    		$image = new Image;
    		$image->name = 'Hola.jpg';
    		$image->path = $path;

            $image->ar      = $command->ar;
            $image->dec     = $command->dec;
            $image->exptime = $command->exptime;
            $image->iso     = $command->iso;

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
