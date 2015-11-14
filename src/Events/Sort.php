<?php namespace Khill\Lavacharts\Events;

/**
 * Select Event Object
 *
 * The base class for the individual event objects, providing common
 * functions to the child objects.
 *
 *
 * @package    Lavacharts
 * @subpackage Events
 * @since      v2.5.0
 * @author     Peter Draznik <kevinkhill@gmail.com>
 * @copyright  (c) 2015, 38th Street Studios
 * This is an add on to the project below.
 * @link       http://github.com/kevinkhill/lavacharts GitHub Repository Page
 * @link       http://lavacharts.com                   Official Docs Site
 * @license    http://opensource.org/licenses/MIT MIT
 */

class Sort extends Event
{
    const TYPE = 'sort';

    /**
     * Builds the Sort Event object.
     *
     * @param  string              $c Callback function name.
     * @throws InvalidConfigValue
     * @return Sotrt
     */
    public function __construct($c)
    {
        parent::__construct($c);
    }
}
