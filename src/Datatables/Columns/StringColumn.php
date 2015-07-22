<?php

namespace Khill\Lavacharts\Datatables\Columns;

use \Khill\Lavacharts\Values\Label;
use \Khill\Lavacharts\Formats\Format;

class StringColumn extends Column
{
    const TYPE = 'string';

    public function __construct(Label $label, Label $id, Format $format = null)
    {
        parent::__construct($label, $id, $format);
    }
}
