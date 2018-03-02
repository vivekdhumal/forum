<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Favorite;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Favorite the reply.
     *
     * @param \App\Reply  $reply  The reply
     * @return Illuminate\Http\Response
     */
    public function store(Reply $reply)
    {
        $reply->favorite();

        if(request()->expectsJson()) {
            return response(['status' => 'Reply has been favorited.']);
        }

        return back();
    }

    /**
     * Unfavorite the reply.
     *
     * @param \App\Reply  $reply  The reply
     * @return Illumniate\Http\Response
     */
    public function destroy(Reply $reply)
    {
        $reply->unfavorite();

        if(request()->expectsJson()) {
            return response(['status' => 'Reply has been unfavorited.']);
        }
    }
}
