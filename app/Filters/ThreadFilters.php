<?php

namespace App\Filters;

use App\User;

class ThreadFilters extends Filters
{
    /**
     * Specify the predefined thread filters.
     *
     * @var array
     */
    protected $filters = ['by', 'popular', 'unanswered'];

    /**
     * Filter a thread by usersname.
     *
     * @param string $username
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function by($username)
    {
        $user = User::where('name', $username)->firstOrFail();

        return $this->builder->where('user_id', $user->id);
    }

    /**
     * Get the popular threads.
     *
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function popular()
    {
        $this->builder->getQuery()->orders = [];

        return $this->builder->orderBy('replies_count', 'desc');
    }

    /**
     * Get the unanswered threads.
     *
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function unanswered()
    {
        return $this->builder->where('replies_count', 0);
    }
}
