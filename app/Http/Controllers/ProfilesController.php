<?php

namespace App\Http\Controllers;

use App\User;
use App\Activity;

class ProfilesController extends Controller
{
    /**
     * Show the user profile page.
     *
     * @param \App\User  $user   The user
     * @return Illumniate\Http\Response.
     */
    public function show(User $user)
    {
        $activties = Activity::feed($user);

        return view('profiles.show', [
            'profileUser' => $user,
            'activties' => $activties
        ]);
    }
}
