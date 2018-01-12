<?php

namespace App;

use App\Favorite;
use App\Traits\Favoritable;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use Favoritable;

    protected $guarded = [];

    protected $with = ['owner', 'favorites'];

    /**
     * Get the owner associate with the reply.
     *
     * @return App\User
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
