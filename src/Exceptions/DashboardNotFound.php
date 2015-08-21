<?php namespace Khill\Lavacharts\Exceptions;

class DashboardNotFound extends \Exception
{
    public function __construct($type, $label, $code = 0)
    {
        $message = "Dashboard $type('$label') was not found.";

        parent::__construct($message, $code);
    }
}
