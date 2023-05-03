<?php

namespace App\Traits;

use App\Models\ChatRequest;
use App\Models\ChatSession;
use App\Models\WaUser;
use Illuminate\Http\Request;

trait HandChatFromBot
{

    public $action;
    public $user_id;
    public $message;


    public function message_from_bot(Request $request)
    {
        $this->action = $request->action;
        $this->user_id = $request->user_id;
        $this->message = $request->message ?? "";

        $user = $this->checkExistingUser($this->user_id);


        if ($this->action == "open chat") {
            $chat_sesseion_model = new ChatSession();
            $chat_sesseion_model->where("user_id", $this->user_id)
                ->update([
                    "live_chat" => 1
                ]);

            $chat_request_model = new ChatRequest();
            $chat_request_model->customer_id = $this->user_id;
            $chat_request_model->save();

            

        }

        if ($this->action == "continue chat") 
        {

        }
    }

    public function checkExistingUser($phone){
        $waUserModel = new WaUser();
        $user = $waUserModel->where('phone',$phone)->first();

        if (!$user) {
            $waUserModel->name = $phone;
            $waUserModel->phone = $phone;
            $waUserModel->save();
            $user = $waUserModel->where('phone',$phone)->first();

        }

        return $user;
    }
}
