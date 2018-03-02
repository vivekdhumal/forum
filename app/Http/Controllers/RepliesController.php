<?php

namespace App\Http\Controllers;

use App\User;
use App\Reply;
use App\Thread;
use App\Rules\SpamFree;
use Illuminate\Http\Request;
use App\Http\Requests\CreateReplyRequest;

class RepliesController extends Controller
{
    /**
     * Create a new controller instance.
     */
    function __construct()
    {
        $this->middleware('auth', ['except' => 'index']);
    }

    /**
     * List a thread replies.
     *
     * @param int $channelId
     * @param App\Thread $thread
     * @return App\Reply JSON
     */
    public function index($channelId, Thread $thread)
    {
        return $thread->replies()->paginate(20);
    }

    /**
     * Store a new thread reply.
     *
     * @param int $channelId
     * @param App\Thread $thread
     * @param App\Requests\CreateReplyRequest $request
     * @return App\Reply JSON
     */
    public function store($channelId, Thread $thread, CreateReplyRequest $request)
    {
        return $thread->addReply([
            'user_id' => auth()->id(),
            'body' => request('body')
        ])->load('owner');
    }

    /**
     * Update the reply.
     *
     * @param App\Reply $reply
     * @return void
     */
    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);

        request()->validate(['body' => ['required', new SpamFree]]);

        $reply->update(request(['body']));
    }

    /**
     * Remove the reply.
     *
     * @param App\Reply $reply
     * @return Illuminate\Http\Response
     */
    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->delete();

        if (request()->expectsJson()) {
            return response(['status' => 'Reply deleted']);
        }

        return back();
    }
}
