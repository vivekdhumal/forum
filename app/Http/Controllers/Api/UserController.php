<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * List the top 5 users as per their name.
     *
     * @return App\User
     */
    public function index()
    {
        $name = request('name');

        return User::where('name', 'LIKE', "$name%")
                ->take(5)
                ->pluck('name');
    }
}
