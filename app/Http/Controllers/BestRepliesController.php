<?php

namespace App\Http\Controllers;

use App\Reply;
use Illuminate\Http\Request;

class BestRepliesController extends Controller
{
    /**
     * Save the best reply.
     *
     * @param App\Reply $reply
     * @return void
     */
    public function store(Reply $reply)
    {
        $this->authorize('update', $reply->thread);

        $reply->thread->markAsBestReply($reply);
    }
}
