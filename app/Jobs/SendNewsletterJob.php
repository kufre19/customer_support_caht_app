<?php

namespace App\Jobs;

use App\Traits\MessagesType;
use App\Traits\SendMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendNewsletterJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels,SendMessage, MessagesType;
    protected $batchSize;
    protected $offset;
    protected $title;
    protected $message;
    protected $users;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($batchSize, $offset, $subject, $message, $subscribers)
    {
        $this->batchSize = $batchSize;
        $this->offset = $offset;
        $this->title = $subject;
        $this->message = $message;
        $this->users = $subscribers;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        foreach ($this->users as $user) {
            $data = $this->make_text_message($this->message,$user->user_id);
            $this->send_post_curl($data);
        }
    }
}
