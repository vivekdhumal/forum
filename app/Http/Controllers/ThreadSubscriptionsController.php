<?php

namespace App\Http\Controllers;

use App\Thread;

class ThreadSubscriptionsController extends Controller
{
    /**
     * Subscribed to the thread.
     *
     * @param int $channelId
     * @param App\Thread $thread
     * @return void
     */
    public function store($channelId, Thread $thread)
    {
        $thread->subscribe();
    }

    /**
     * Unsubscribe the thread.
     *
     * @param int $channelId
     * @param App\Thread $thread
     * @return void
     */
    public function destroy($channelId, Thread $thread)
    {
        $thread->unsubscribe();
    }
}
