<?php namespace Khill\Lavacharts\Controls;

/**
 * ChartRangeFilter Class
 *
 * A chartRange filter that is rendered within dashboard. Filters the tables bound to it via the dashboard.
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

class ChartRangeFilter extends Control
{
    public $type = 'ChartRangeFilter';

    public function __construct($categoryLabel)
    {
        parent::__construct($categoryLabel);

        $this->defaults = array_merge(
            $this->defaults,
            array(
                'ui.chartType',
                'ui.chartOptions',
                'ui.chartView',
                'ui.minRangeSize',
                'ui.snapToData',
            )
        );
    }
}
