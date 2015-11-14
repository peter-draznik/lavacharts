<<<<<<< HEAD
<?php

namespace Khill\Lavacharts\Exceptions;

class DashboardNotFound extends \Exception
{
    public function __construct($label)
    {
        $message = "Dashboard('$label') was not found.";

        parent::__construct($message);
=======
<?php namespace Khill\Lavacharts\Exceptions;

class DashboardNotFound extends \Exception
{
    public function __construct($type, $label, $code = 0)
    {
        $message = "Dashboard $type('$label') was not found.";

        parent::__construct($message, $code);
>>>>>>> 2.6
    }
}
