<?php

namespace App\Http\Controllers;

use App\User;

class UserNotificationsController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * List the unread notifications.
     *
     * @return Illuminate\Notifications\Notification
     */
    public function index()
    {
        return auth()->user()->unreadNotifications;
    }

    /**
     * Mark the notification as read.
     *
     * @param App\User $user
     * @param int $notificationId
     * @return void
     */
    public function destroy(User $user, $notificationId)
    {
        auth()->user()->notifications()->findOrFail($notificationId)->markAsRead();
    }
}
