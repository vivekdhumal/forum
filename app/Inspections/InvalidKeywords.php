<?php

namespace App\Inspections;

use Exception;

class InvalidKeywords
{
    /**
     * Specify the invalid keywords.
     *
     * @var array
     */
    protected $keywords = [
        'Yahoo customer support',
    ];

    /**
     * Detect the invalid keywords.
     *
     * @param string $body
     * @throws Exception
     * @return void
     */
    public function detect($body)
    {
        foreach($this->keywords as $keyword) {
            if(stripos($body, $keyword) !== false) {
                throw new Exception("Your reply contains spam");
            }
        }
    }
}
