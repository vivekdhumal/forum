<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        $name = request('name');

        return User::where('name', 'LIKE', "$name%")
                ->take(5)
                ->pluck('name');
    }
}
