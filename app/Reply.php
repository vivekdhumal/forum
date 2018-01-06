<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $guarded = [];
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
