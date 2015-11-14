<?php namespace Khill\Lavacharts\Exceptions;

class ControlNotFound extends \Exception
{
    public function __construct($type, $label, $code = 0)
    {
        $message = "Control $type('$label') was not found.";

        parent::__construct($message, $code);
    }
}
