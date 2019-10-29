<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Equipment;

class EquipmentController extends Controller
{
	public function index()
    {
        $equipments = Equipment::orderBy('name')->get();
        return response()->json($equipments);
    }


    public function new(Request $request){

        $data = json_decode($request->data);

        Info('Equipment new 21');
        Info($request);

        $fileName = $request->file->getClientOriginalName();        
        $fileDir = $request->file->storeAs('files',$fileName);  

	    $equipment = new Equipment();
	    $equipment->name	    = $data->name;
	    $equipment->description	= $data->description;
        $equipment->image_name  = $fileName;
        $equipment->image       = $fileDir;
        $equipment->save();

        return response()->json($equipment);
    }	

    public function edit(Request $request){
	    $equipment = Equipment::where($request->input('id'))->get();

	    $equipment->name	    = $request->input('name');
	    $equipment->description	= $request->input('description');
        $equipment->save();

        return response()->json($equipment);
    }

    public function save_image(Request $request)
    {
    	$equipment_id = input("equipment_id");

    	$equipment = Equipment::all();
       	
        request()->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

		if($request->hasFile('avatar')){
            $file = $request->file('avatar');

            $filename = 'avatar-' . $equipment_id  . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('equipments', $filename);


            $equipment->image =  Storage::url($path);
            $user->save();

        }
        // $check = Image::insertGetId($insert);

        return response()->json($user);
 
    }
}
