<?php

namespace App\Traits;

use App\Models\ChatSession;
use Illuminate\Http\Request;

trait HandChatFromBot {

    public $action;
    public $user_id;
    public $message;


    public function message_from_bot(Request $request)
    {
        $this->action = $request->action;
        $this->user_id = $request->user_id;
        $this->message = $request->message;


        if(  $this->action == "open chat")
        {
           $chat_sesseion_model = new ChatSession();
           $chat_sesseion_model->where("user_id",$this->user_id)
           ->update([
                "live_chat"=>1
           ]);
        }

    }
}