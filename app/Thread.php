<?php

namespace App;

use App\Traits\RecordsVisits;
use App\Filters\ThreadFilters;
use App\Traits\RecordsActivity;
use App\Events\ThreadReceivedNewReply;
use App\Notifications\ThreadWasUpdated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Thread extends Model
{
    use RecordsActivity;

    /**
     * Don't apply mass-assignment protection.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['creator', 'channel'];

    /**
     * The accessor to append to the model's array form
     *
     * @var array
     */
    protected $appends = ['isSubscribedTo'];

    /**
     * Boot the Thread instance.
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($thread) {
            $thread->replies->each->delete();
        });

        static::created(function ($thread) {
            $thread->update(['slug' => $thread->title]);
        });
    }

    /**
     * Fetch a path to the current thread.
     *
     * @return string
     */
    public function path()
    {
        return '/threads/' . $this->channel->slug . '/' . $this->slug;
    }

    /**
     * Get the route key name for Laravel.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
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

    /**
     * Add a reply to the thread.
     *
     * @param array $reply
     * @return App\Reply
     */
    public function addReply($reply)
    {
        $reply = $this->replies()->create($reply);

        event(new ThreadReceivedNewReply($reply));

        return $reply;
    }

    /**
     * Apply all relevant thread filters.
     *
     * @param Illuminate\Database\Eloquent\Builder $query
     * @param App\Filters\ThreadFilters $filters
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query, ThreadFilters $filters)
    {
        return $filters->apply($query);
    }

    /**
     * Subscribe a user to the current thread.
     *
     * @param int|null $userId
     * @return $this
     */
    public function subscribe($userId = null)
    {
        $this->subscriptions()->create([
            'user_id' => $userId ?: auth()->id()
        ]);

        return $this;
    }

    /**
     * Unsubscribe a user from the current thread.
     *
     * @param int|null $userId
     */
    public function unsubscribe($userId = null)
    {
        $this->subscriptions()
            ->where('user_id', $userId ?: auth()->id())
            ->delete();
    }

    /**
     * A thread can have a many subscriptions.
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscriptions()
    {
        return $this->hasMany(ThreadSubscription::class);
    }

    /**
     * Determing if the current user is subscribed to the thread.
     *
     * @return bool
     */
    public function getIsSubscribedToAttribute()
    {
        return $this->subscriptions()
                ->where('user_id', auth()->id())
                ->exists();
    }
    /**
     * Determine if the thread has been updated since the user last read it.
     *
     * @param App\User $user
     * @return bool
     */
    public function hasUpdatesFor($user = null)
    {
        $key = $user->visitedThreadCacheKey($this);

        return $this->updated_at > cache($key);
    }

    /**
     * Set the slug attribute.
     *
     * @param string $value
     * @return void
     */
    public function setSlugAttribute($value)
    {
        $slug = str_slug($value);
        $original = $slug;

        if (static::whereSlug($slug)->exists()) {
            $slug = "{$original}-" . $this->id;
        }

        $this->attributes['slug'] = $slug;
    }
}
