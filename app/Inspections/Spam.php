<?php

namespace App\Inspections;

class Spam
{
    /**
     * An available spam inspection classes.
     *
     * @var array
     */
    protected $inspections = [
        InvalidKeywords::class,
        KeyHeldDown::class
    ];

    /**
     * Detect the spam.
     *
     * @param string $body
     * @throws Exception
     * @return mixed
     */
    public function detect($body)
    {
        foreach($this->inspections as $inspection) {
            app($inspection)->detect($body);
        }

        return false;
    }
}
