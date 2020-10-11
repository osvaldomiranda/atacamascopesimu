<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Storage;
use App\Image;
use App\Events\MessageSent;
use App\Message;
use App\Command;
use App\AstronomicObject;
use App\AstronomicObjectImages;


class ImageController extends Controller
{
    public function upload($command_id, request $request)
    {

        Info("****** upload *******");
        Info($request);
        Info($command_id);
        


        $command = Command::where('id', $command_id)->get()->first();
    	
        Info($command);
        Info("****** upload *******");
        

    	if($request->hasFile('photo')){

            $file = $request->file('photo');
            $name=time().$file->getClientOriginalName();

            Info($name);


    		$image = new Image;
    		$image->name = $name;
    		$image->path = $command->path;

            $image->ar      = $command->ar;
            $image->dec     = $command->dec;
            $image->exptime = $command->exptime;
            $image->iso     = $command->iso;

            $image->ar_string   = $command->ar_string;
            $image->dec_string  = $command->dec_string;
            $image->object_name = $command->object_name;
            $image->iso_string  = $command->iso_string;


    		$image->user_id = $command->user_id;
    		$image->equipment_id = 1;
    		$image->save();

            //TODO: cuando se tenga mas de un telescopio, se debe 
            //TODO: reemplazar el receiver_id, con el id del usuario
            $message = Message::create([
                'sender_id'   => 1,
                'receiver_id' => 2,
                'message'     => 'Imagen Recibida',
            ]);

            broadcast(new MessageSent($message));
    	}
    }

    public function last(request $request){
        $image = Image::where('user_id', 1)->get();

        if($image->count()>0){
             $path =  $image->last()->path;
            // $path = url('images/vialactea1.jpg');
        } else {
            $path = url('images/sanpeter2.jpg');
        }

        return response()->json($path);
    }

    public function index(request $request){
        $images = Image::where('user_id', 1)->orderBy('created_at', 'desc')->get();
        return response()->json($images);
    }

    public function myImages(request $request){
        
        $images = Image::where('user_id', 1)->orderBy('created_at', 'desc')->get();
        return response()->json($images);
    }

    public function updatePaths(){
        $objects = AstronomicObject::all();

        foreach ($objects as $object) {
            $path = AstronomicObjectImages::where('name', $object->name)->get()->first();

            $object->path = $path->path;
            $object->save();

            Info('Update');
        }
        return response()->json($objects);
    }

 

}
