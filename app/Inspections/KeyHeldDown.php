<?php

namespace App\Inspections;

use Exception;

class KeyHeldDown
{
    /**
     * Detect the key held down.
     *
     * @param string $body
     * @throws Exception
     * @return void
     */
    public function detect($body)
    {
        if(preg_match('/(.)\\1{4,}/', $body)) {
            throw new Exception("Your reply contains spam");
        }
    }
}
