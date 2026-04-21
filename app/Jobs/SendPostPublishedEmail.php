<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use App\Mail\PostPublishedMail;

class SendPostPublishedEmail implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
   protected $post;

    public function __construct($post)
    {
        $this->post = $post;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
         $post = $this->post->load('user');
        $user = $post->user;

        Mail::to($user->email)
            ->send(new PostPublishedMail($post));
    }
}
