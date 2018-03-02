<?php

namespace App\Policies;

use App\User;
use App\Reply;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReplyPolicy
{
    use HandlesAuthorization;

    /**
     * Determin if the given user can create a new reply.
     *
     * @param App\User $user
     * @return bool
     */
    public function create(User $user)
    {
        if(!$lastReply = $user->fresh()->lastReply) {
            return true;
        }

        return ! $lastReply->wasJustPublished();
    }

    /**
     * Determin if the given user can update the reply.
     *
     * @param App\User $user
     * @param App\Reply $reply
     * @return bool
     */
    public function update(User $user, Reply $reply)
    {
        return $reply->user_id == $user->id;
    }
}
