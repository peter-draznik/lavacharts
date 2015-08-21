<?php namespace Khill\Lavacharts\Controls;

/**
 * numberRangeFilter Class
 *
 * A number filter that is rendered within dashboard. Filters bouned tables.
 *
 *
 * @package    Lavacharts
 * @subpackage Control
 * @since      v3.0.0
 * @author     Peter Draznik <peter.draznik@38thStreetStudios.com>
 * @copyright  (c) 2015, 38th Street Studios
 * Using the project below:
 * @link       http://github.com/kevinkhill/lavacharts GitHub Repository Page
 * @link       http://lavacharts.com                   Official Docs Site
 * @license    http://opensource.org/licenses/MIT MIT
 */

use Khill\Lavacharts\Utils;

class NumberRangeFilter extends Control
{
    public $type = 'NumberRangeFilter';

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
     * Minimum allowed value for the range lower extent. If undefined, the value will
     * be inferred from the contents of the DataTable managed by the control.
     *
     * @param  int                $value
     * @throws InvalidConfigValue
     * @return NumberRangeFilter
     */
    public function minValue($value)
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
	
	/**
     * Maximum allowed value for the range higher extent. If undefined, the value will 
     * be inferred from the contents of the DataTable managed by the control.
     *
     * @param  int                $value
     * @throws InvalidConfigValue
     * @return NumberRangeFilter
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
