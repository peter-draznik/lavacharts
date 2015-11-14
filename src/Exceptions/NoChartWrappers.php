<?php namespace Khill\Lavacharts\Exceptions;

class NoChartWrappers extends \Exception
{
    public function __construct()
    {
        $message = 'No charts have been registered with dashboard.';

        parent::__construct($message, 0);
    }
}
