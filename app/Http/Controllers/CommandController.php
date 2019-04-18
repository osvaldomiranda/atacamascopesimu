<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Command;
use App\Events\MessageSent;
use App\Message;

class CommandController extends Controller
{
    public function move(request $request){
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
    }
    public function shoot(request $request){
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
        $command->user_id		= $request->input('user_id');
        $command->equipment_id	= $request->input('equipment_id');
        $command->save();
    }
    public function focus(request $request){
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
        $command->step  		= $request->input('step');
        $command->direction 	= $request->input('direction');	
        $command->user_id		= $request->input('user_id');
        $command->equipment_id	= $request->input('equipment_id');
        $command->save();
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

	        $message = Message::create([
	            'sender_id'   => 1,
	            'receiver_id' => 2,
	            'message'     => 'Comando Enviado',
	        ]);

	        broadcast(new MessageSent($message));

	    	return response()->json($command);    		
    	}else {
    		$command = ['command'=>'SIN_COMANDO'];
    		return response()->json($command);
    	}
    }
}
