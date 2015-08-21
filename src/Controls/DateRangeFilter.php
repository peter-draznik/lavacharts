<?php namespace Khill\Lavacharts\Controls;

/**
 * DateRangeFilter Class
 *
 * A dateRange filter that is rendered within dashboard. Filters bouned tables.
 *
 *
 * @package    Lavacharts
 * @subpackage Control
 * @since      v3.0.0
 * @author     Peter Draznik <peter.draznik@38thStreetStudios.com>
 * @copyright  (c) 2015, 38th Street Studios
 *Using the project below:
 * @link       http://github.com/kevinkhill/lavacharts GitHub Repository Page
 * @link       http://lavacharts.com                   Official Docs Site
 * @license    http://opensource.org/licenses/MIT MIT
 */

use Khill\Lavacharts\Utils;

class DateRangeFilter extends Control
{
    public $type = 'DateRangeFilter';

    public function __construct($categoryLabel)
    {
        parent::__construct($categoryLabel);

        $this->defaults = array_merge(
            $this->defaults,
            array(
                'minValue',
                'maxValue',
                'ui.format',
                'ui.step',
                'ui.ticks',
                'ui.unitIncrement',
                'ui.blockIncrement',
                'ui.showRangeValues',
                'ui.orientation',
                'ui.label',
                'ui.labelSeparator',
                'ui.labelStacking',
                'ui.cssClass',
            )
        );
    }

    /**
     * Sets the minimum value of the filter.
     *
     * @param  int                $value
     * @throws InvalidConfigValue
     * @return DateRangeFilter
     */
    public function minValue($value)
    {
        if (is_string($width)) {//Should check for date at somepoint.
            $this->addOption(array(__FUNCTION__ => $value));
        } else {
            throw $this->invalidConfigValue(
                __FUNCTION__,
                'string'
            );
        }

        return $this;
    }
	
	/**
     * Sets the maximum value of the filter
     *
     * @param  int                $value
     * @throws InvalidConfigValue
     * @return DateRangeFilter
     */
    public function maxValue($value)
    {
        if (is_int($width)) {
            $this->addOption(array(__FUNCTION__ => $value));
        } else {
            throw $this->invalidConfigValue(
                __FUNCTION__,
                'int'
            );
        }

        return $this;
    }
}
