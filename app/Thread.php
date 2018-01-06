<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $guarded = [];
    /**
     * Fetch a path to the current thread.
     *
     * @return string
     */
    public function path()
    {
        return '/threads/'.$this->channel->slug.'/'.$this->id;
    }

    /**
     * Get the replies associated with the current thread.
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    /**
     * a Thread belongs to creator.
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * a Thread belongs to channel.
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function addReply($reply)
    {
        $this->replies()->create($reply);
    }
}
