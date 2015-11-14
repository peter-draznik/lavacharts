<?php

namespace Khill\Lavacharts;

use \Khill\Lavacharts\Values\Label;
use \Khill\Lavacharts\Charts\Chart;
use \Khill\Lavacharts\Dashboards\Dashboard;
use \Khill\Lavacharts\Exceptions\ChartNotFound;
use \Khill\Lavacharts\Exceptions\DashboardNotFound;

/**
 * Volcano Storage Class
 *
 * Storage class that holds all defined charts and dashboards.
 *
 * @category  Class
 * @package   Lavacharts
 * @since     2.0.0
 * @author    Kevin Hill <kevinkhill@gmail.com>
 * @copyright (c) 2015, KHill Designs
 * @link      http://github.com/kevinkhill/lavacharts GitHub Repository Page
 * @link      http://lavacharts.com                   Official Docs Site
 * @license   http://opensource.org/licenses/MIT MIT
 */
<<<<<<< HEAD
=======

use Khill\Lavacharts\Utils;
use Khill\Lavacharts\Charts\Chart;
use Khill\Lavacharts\Controls\Control;
use Khill\Lavacharts\Controls\Dashboard;
use Khill\Lavacharts\Exceptions\InvalidLabel;
use Khill\Lavacharts\Exceptions\ChartNotFound;
use Khill\Lavacharts\Exceptions\DashboardNotFound;

>>>>>>> 2.6
class Volcano
{
    /**
     * Holds all of the defined Charts.
     *
     * @var array
     */
<<<<<<< HEAD
    private $charts = [];

    /**
     * Holds all of the defined Dashboards.
     *
     * @var array
     */
    private $dashboards = [];

=======
    private $charts = array();
	
>>>>>>> 2.6
    /**
     * Stores a chart in the volcano datastore.
     *
     * @param  \Khill\Lavacharts\Charts\Chart $chart Chart to store in the volcano.
     * @return boolean
     */
    public function storeChart(Chart $chart)
    {
        $this->charts[$chart::TYPE][(string) $chart->getLabel()] = $chart;

        return true;
    }

    /**
     * Stores a dashboard in the volcano datastore.
     *
     * @param  \Khill\Lavacharts\Dashboards\Dashboard $dashboard Dashboard to store in the volcano.
     * @return boolean
     */
    public function storeDashboard(Dashboard $dashboard)
    {
        $this->dashboards[(string) $dashboard->getLabel()] = $dashboard;

        return true;
    }

    /**
     * Retrieves a chart from the volcano datastore.
     *
     * @param  string $type  Type of chart to store.
     * @param  \Khill\Lavacharts\Values\Label $label Identifying label for the chart.
     * @throws \Khill\Lavacharts\Exceptions\ChartNotFound
     * @return \Khill\Lavacharts\Charts\Chart
     */
    public function getChart($type, Label $label)
    {
        if ($this->checkChart($type, $label) === false) {
            throw new ChartNotFound($type, $label);
        }

        return $this->charts[$type][(string) $label];
    }

    /**
     * Retrieves a dashboard from the volcano datastore.
     *
     * @param  \Khill\Lavacharts\Values\Label $label Identifying label for the dashboard.
     * @throws \Khill\Lavacharts\Exceptions\DashboardNotFound
     * @return \Khill\Lavacharts\Dashboards\Dashboard
     */
    public function getDashboard(Label $label)
    {
        if ($this->checkDashboard($label) === false) {
            throw new DashboardNotFound($label);
        }

        return $this->dashboards[(string) $label];
    }

    /**
     * Simple true/false test if a chart exists.
     *
     * @param  string $type  Type of chart to check.
     * @param  \Khill\Lavacharts\Values\Label $label Identifying label of a chart to check.
     * @return boolean
     */
    public function checkChart($type, Label $label)
    {
        if (Utils::nonEmptyString($type) === false) {
            return false;
        }

        if (array_key_exists($type, $this->charts) === false) {
            return false;
        }

        return array_key_exists((string) $label, $this->charts[$type]);
    }

    /**
     * Simple true/false test if a dashboard exists.
     *
     * @param  \Khill\Lavacharts\Values\Label $label Identifying label of a chart to check.
     * @return boolean
     */
    public function checkDashboard(Label $label)
    {
        return array_key_exists((string) $label, $this->dashboards);
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
