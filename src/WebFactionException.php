<?php

namespace FortyTwoStudio\WebFactionPHP;

use \Exception;

class WebFactionException extends Exception
{
    public function __construct($message, $code, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}