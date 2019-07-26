<?php

namespace App\Http\Controllers\Api\V1;

use App\Events\MessageSent;
use App\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class MessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return  Message::where('sender_id',1)->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message = Message::create([
            'sender_id'   => $request->input('sender_id'),
            'receiver_id' => $request->input('receiver_id'),
            'message'     => $request->input('message'),
        ]);

        
        Info($message);

        broadcast(new MessageSent($message));

        return $message->fresh();
    }
}
