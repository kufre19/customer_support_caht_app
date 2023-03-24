<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\SendNewsletterJob;
use App\Models\ChatSession;

class NewsLetterController extends Controller
{
    public function send_news_letter(Request $request)
    {
        $title = $request->input("title");
        $message = $request->input("content");

        $session_model = new ChatSession();
        $users = $session_model->get();

        $batchSize = 20;
        $offset = 0;
        $subscribersCount = count($users);

        while ($offset < $subscribersCount) {
            dispatch(new SendNewsletterJob(
                $batchSize, 
                $offset, 
                $title, 
               $message,
                $users->slice($offset, $batchSize)
            ));
            $offset += $batchSize;
        }

        return back()->with('success', 'Newsletter sent successfully!');

    }
}
