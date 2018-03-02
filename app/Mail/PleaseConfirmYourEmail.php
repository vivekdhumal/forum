<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PleaseConfirmYourEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * App user
     *
     * @var App\User
     */
    public $user;

    /**
     * Create a new class instance.
     *
     * @param App\User $user
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the mail content.
     *
     * @return makrdown
     */
    public function build()
    {
        return $this->markdown('emails.confirm-email');
    }
}
