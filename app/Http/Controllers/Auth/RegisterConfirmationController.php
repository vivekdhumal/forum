<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;

class RegisterConfirmationController extends Controller
{
    /**
     * Confirm user email address
     *
     * @return Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::where('confirmation_token', request('token'))->first();

        if (!$user) {
            return redirect(route('threads'))->with('flash', 'Unknown token.');
        }

        $user->confirm();

        return redirect(route('threads'))
            ->with('flash', 'Your account has been confirmed, You may now post the threads.');
    }
}
