<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }

    public function store($channelId, Thread $thread)
    {
        request()->validate([
            'body' => 'required',
        ]);

        $thread->addReply([
            'user_id' => auth()->id(),
            'body' => request('body')
        ]);

        return back()->with('flash', 'Your reply has been left.');
    }

    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->delete();

        return back();
    }
}
