<?php

namespace App\Listeners;

use App\Events\PostPublished;
use App\Jobs\SendPostPublishedEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class HandlePostPublished
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PostPublished $event): void
    {
        $post=$event->post;
        $post->update([
            'published_at' => now()
        ]);

        SendPostPublishedEmail::dispatch($post);
    }
}
