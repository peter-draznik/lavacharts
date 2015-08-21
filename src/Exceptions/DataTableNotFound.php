<?php namespace Khill\Lavacharts\Exceptions;

class DataTableNotFound extends \Exception
{
    public function __construct($object, $code = 0)//Note $object could be a Chart, Control, or Dashboard
    {
        $message = "$object->type('$object->label') has no DataTable.";

        parent::__construct($message, $code);
    }
}
