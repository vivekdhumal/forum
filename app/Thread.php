<?php

namespace App;

use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Thread extends Model
{
    use RecordsActivity;

    protected $guarded = [];

    protected $with = ['creator', 'channel'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('replyCount', function (Builder $builder) {
            $builder->withCount('replies');
        });

        static::deleting(function ($thread) {
            $thread->replies->each->delete();
        });
    }

    /**
     * Fetch a path to the current thread.
     *
     * @return string
     */
    public function path()
    {
        return '/threads/' . $this->channel->slug . '/' . $this->id;
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
        return $this->replies()->create($reply);
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }
}
