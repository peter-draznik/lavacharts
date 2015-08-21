<?php namespace Khill\Lavacharts;

/**
 * Volcano Storage Class
 *
 * Storage class that holds all defined charts.
 *
 * @category  Class
 * @package   Lavacharts
 * @since     v2.0.0
 * @author    Kevin Hill <kevinkhill@gmail.com>
 * @copyright (c) 2014, KHill Designs
 * @link      http://github.com/kevinkhill/Lavacharts GitHub Repository Page
 * @link      http://kevinkhill.github.io/Lavacharts  GitHub Project Page
 * @license   http://opensource.org/licenses/MIT MIT
 */

use Khill\Lavacharts\Utils;
use Khill\Lavacharts\Charts\Chart;
use Khill\Lavacharts\Controls\Control;
use Khill\Lavacharts\Controls\Dashboard;
use Khill\Lavacharts\Exceptions\InvalidLabel;
use Khill\Lavacharts\Exceptions\ChartNotFound;
use Khill\Lavacharts\Exceptions\DashboardNotFound;

class Volcano
{
    /**
     * Holds all of the defined Charts.
     *
     * @var array
     */
    private $charts = array();
	
    /**
     * Stores a chart in the volcano datastore.
     *
     * @param  Chart        $chart Chart to store in the volcano.
     * @throws InvalidLabel
     */
    public function storeChart(Chart $chart)
    {
        $this->charts[$chart->type][$chart->label] = $chart;

        return true;
    }

    /**
     * Retrieves a chart from the volcano datastore.
     *
     * @param  string $type  Type of chart to store.
     * @param  string $label Identifying label for the chart.
     * @throws ChartNotFound
     *
     * @return Chart
     */
    public function getChart($type, $label)
    {
        if ($this->checkChart($type, $label)) {
            return $this->charts[$type][$label];
        } else {
            throw new ChartNotFound($type, $label);
        }
    }

    /**
     * Simple true/false test if a chart exists.
     *
     * @param string $type  Type of chart to store.
     * @param string $label Identifying label of a chart to check.
     *
     * @return bool
     */
    public function checkChart($type, $label)
    {
        if (Utils::nonEmptyString($type) && Utils::nonEmptyString($label)) {
            if (array_key_exists($type, $this->charts)) {
                if (array_key_exists($label, $this->charts[$type])) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    
    /**
     * Holds all of the defined Controls.
     *
     * @var array
     */
    private $controls = array();
	
    /**
     * Stores a control in the volcano datastore.
     *
     * @param  Control        $control Control to store in the volcano.
     * @throws InvalidLabel
     */
    public function storeControl(Control $control)
    {
        
        $this->controls[$control->type][$control->label] = $control;
		//die( print_r($this->controls[$control->type][$control->label]) );
        return true;
    }

    /**
     * Retrieves a chart from the volcano datastore.
     *
     * @param  string $type  Type of chart to store.
     * @param  string $label Identifying label for the chart.
     * @throws ChartNotFound
     *
     * @return Chart
     */
    public function getControl($type, $label)
    {
        if ($this->checkControl($type, $label)) {
            return $this->controls[$type][$label];
        } else {
            throw new ControlNotFound($type, $label);
        }
    }

    /**
     * Simple true/false test if a chart exists.
     *
     * @param string $type  Type of chart to store.
     * @param string $label Identifying label of a chart to check.
     *
     * @return bool
     */
    public function checkControl($type, $label)
    {
        if (Utils::nonEmptyString($type) && Utils::nonEmptyString($label)) {
            if (array_key_exists($type, $this->controls)) {
                if (array_key_exists($label, $this->controls[$type])) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    
    /**
     * Holds all of the defined Charts.
     *
     * @var array
     */
    private $dashboards = array();
	
    /**
     * Stores a dashboard in the volcano datastore.
     *
     * @param  Dashboard        $dashboard Dashboard to store in the volcano.
     * @throws InvalidLabel
     */
    public function storeDashboard(Dashboard $dashboard)
    {
        $this->dashboards[$dashboard->type][$dashboard->label] = $dashboard;
        return true;
    }

    /**
     * Retrieves a dashboard from the volcano datastore.
     *
     * @param  string $type  Type of dashboard to store.
     * @param  string $label Identifying label for the dashboard.
     * @throws ChartNotFound
     *
     * @return Dashboard
     */
    public function getDashboard($type, $label)
    {
        
        if ($this->checkDashboard($type, $label)) {
            return $this->dashboards[$type][$label];
        } else {
            throw new DashboardNotFound($type, $label);
        }
    }

    /**
     * Simple true/false test if a dashboard exists.
     *
     * @param string $type  Type of dashboard to store.
     * @param string $label Identifying label of a dashboard to check.
     *
     * @return bool
     */
    public function checkDashboard($type, $label)
    {
        if (Utils::nonEmptyString($type) && Utils::nonEmptyString($label)) {
            if (array_key_exists($type, $this->dashboards)) {
                if (array_key_exists($label, $this->dashboards[$type])) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
