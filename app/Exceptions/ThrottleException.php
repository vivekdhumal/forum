<?php

namespace App\Exceptions;

use Exception;

class ThrottleException extends Exception
{
    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        return response(
            ['message' => 'You are posting to frequently. Please take a break. ;).'], 429
        );
    }
}
