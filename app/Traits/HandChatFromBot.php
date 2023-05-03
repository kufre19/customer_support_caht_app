<?php

namespace App\Traits;

use App\Models\ChatRequest;
use App\Models\ChatSession;
use App\Models\User;
use App\Models\WaUser;
use Illuminate\Http\Request;

trait HandChatFromBot
{
    use MessagesType,SendMessage;

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
            

            $chat_request_model = new ChatRequest();
            $chat_request_model->customer_id = $this->user_id;
            $chat_request_model->save();

            $text = "An Agent will join you shortly";
            $message = $this->make_text_message($text,$this->user_id);
            $this->send_post_curl($message);
            

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

    public function auto_admin_greet_message($admin_id, $customer_wa_id)
    {
        $user_model = new User();
        $user = $user_model->where("id", $admin_id)->first();
        $name = $user->name;
        $greeting_text = "Hi Hello my name is {$name}, how may I help you today?";
        $message = $this->make_text_message($greeting_text, $customer_wa_id);
        $chat_sesseion_model = new ChatSession();
        $chat_sesseion_model->where("user_id", $customer_wa_id)
                ->update([
                    "live_chat" => 1
                ]);
        $this->send_post_curl($message);
    }

    public function auto_admin_end_message($admin_id, $customer_wa_id)
    {
        $user_model = new User();
        $user = $user_model->where("id", $admin_id)->first();
        $name = $user->name;
        $greeting_text = "Your chat with {$name}, was ended";
        $message = $this->make_text_message($greeting_text, $customer_wa_id);
        $this->send_post_curl($message);
    }
}
