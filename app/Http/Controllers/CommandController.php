<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Command;
use App\Events\MessageSent;
use App\Message;

class CommandController extends Controller
{
    public function move(request $request){

        Info($request);

	    $this->validate($request, [
	        'type' => 'required',
	        'status' => 'required',
	        'ar' => 'required',
	        'dec' => 'required',
	        'user_id' => 'required',
	        'equipment_id' => 'required',
	    ]);

	    $command = new Command();
	    $command->command		= $request->input('command');
	    $command->type			= $request->input('type');
        $command->status		= $request->input('status');
        $command->ar  			= $request->input('ar');
        $command->dec 			= $request->input('dec');	
        $command->user_id		= $request->input('user_id');
        $command->equipment_id	= $request->input('equipment_id');
        $command->save();

        return response()->json($command);
    }
    public function shoot(request $request){

    	Info("******* shot *********");
    	info($request);
    	Info("******* shot *********");


    	$this->validate($request, [
	        'type' => 'required',
	        'status' => 'required',
	        'exptime' => 'required',
	        'iso' => 'required',
	        'user_id' => 'required',
	        'equipment_id' => 'required',
	    ]);

	    $command = new Command();
	    $command->command		= $request->input('command');
	    $command->type			= $request->input('type');
        $command->status		= $request->input('status');
        $command->exptime  		= $request->input('exptime');
        $command->iso 			= $request->input('iso');	
        $command->ar_string  	= $request->input('ar');
        $command->dec_string 	= $request->input('dec');	
        $command->user_id		= $request->input('user_id');
        $command->object_name	= $request->input('object_name');
        $command->object_id		= $request->input('object_id');
        $command->iso_string	= $request->input('iso_string');
        $command->equipment_id	= $request->input('equipment_id');
        $command->save();

        return response()->json($command);
    }
    public function focus(request $request){
    	Info("*****************");
    	Info($request);



    	$this->validate($request, [
	        'type' => 'required',
	        'status' => 'required',
	        'steps' => 'required',
	        'direction' => 'required',
	        'user_id' => 'required',
	        'equipment_id' => 'required',
	    ]);

	    $command = new Command();
	    $command->command		= $request->input('command');
	    $command->type			= $request->input('type');
        $command->status		= $request->input('status');
        $command->steps  		= $request->input('steps');
        $command->direction 	= $request->input('direction');	
        $command->user_id		= $request->input('user_id');
        $command->equipment_id	= $request->input('equipment_id');
        $command->save();

        return response()->json($command);
    }

    public function pointandshot(request $request){
	    $this->validate($request, [
	        'type' => 'required',
	        'status' => 'required',
	        'ar' => 'required',
	        'dec' => 'required',
	        'iso' => 'required',
	        'exptime' => 'required',
	        'user_id' => 'required',
	        'equipment_id' => 'required',
	    ]);
	    
	    $command = new Command();
	    $command->command		= $request->input('command');
	    $command->type			= $request->input('type');
        $command->status		= $request->input('status');
        $command->exptime  		= $request->input('exptime');
        $command->iso 			= $request->input('iso');	
        $command->ar  			= $request->input('ar');
        $command->dec 			= $request->input('dec');	
        $command->user_id		= $request->input('user_id');
        $command->equipment_id	= $request->input('equipment_id');
        $command->save();

        return response()->json($command);
    }



    public function command($request){
    	if($request=='mountcamera'){
    		$type = ['mount','shoot'];
    	} else {
    		$type = ['focuser'];
    	}
    	
    	$command = Command::whereIn('type',$type)->where('status','PENDIENTE')->get()->last();    	
	    if($command){
	    	$command->status = 'ENVIADO';
	    	$command->save();


	    	//TODO: cuando se tenga mas de un telescopio, se debe 
	    	//TODO: reemplazar el receiver_id, con el id del usuario
	        $message = Message::create([
	            'sender_id'   => 1,
	            'receiver_id' => 2,
	            'message'     => 'Comando Enviado',
	        ]);

	        // broadcast(new MessageSent($message));

	    	return response()->json($command);    		
    	}else {
    		$command = ['command'=>'SIN_COMANDO'];
    		return response()->json($command);
    	}
    }

}
