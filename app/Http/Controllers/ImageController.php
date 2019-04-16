<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Storage;
use App\Image;

class ImageController extends Controller
{
    public function upload(request $request)
    {
    	Info($request);

    	if($request->hasFile('photo')){
    		$path = $request->photo->store('public');

    		$image = new Image;
    		$image->name = 'Hola.jpg';
    		$image->path = $path;
    		$image->user_id = 1;
    		$image->equipment_id = 1;
    		$image->save();
    	}
    }
}
