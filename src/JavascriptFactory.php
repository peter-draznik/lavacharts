<?php namespace Khill\Lavacharts;

/**
 * JavascriptFactory Object
 *
 * This class takes charts and uses all the info to build the complete
 * javascript blocks for outputing into the page.
 *
 * @category  Class
 * @package   Lavacharts
 * @since     v2.0.0
 * @author    Kevin Hill <kevinkhill@gmail.com>
 * @copyright (c) 2014, KHill Designs
 * @link      http://github.com/kevinkhill/Lavacharts GitHub Repository Page
 * @link      http://kevinkhill.github.io/Lavacharts  GitHub Project Page
 * @license   http://opensource.org/licenses/MIT MIT
 *
 *Modified to include Dashboards & controls
 *@since 		v3.0.0
 *@author 		Peter Draznik <peter.draznik@38thStreetStudios.com>
 *@copyright 	(c) 2015, 38th Street Studios
 *
 */

use Khill\Lavacharts\Utils;
use Khill\Lavacharts\Charts\Chart;
use Khill\Lavacharts\Controls\Control;
use Khill\Lavacharts\Controls\Dashboard;
use Khill\Lavacharts\Events\Event;
use Khill\Lavacharts\Exceptions\DataTableNotFound;
use Khill\Lavacharts\Exceptions\InvalidElementId;
use Khill\Lavacharts\Exceptions\NoChartWrappers;

class JavascriptFactory
{
    const DEBUG = false;
    
    /**
     * Chart used to generate output.
     *
     * @var Chart
     */
    private $chart;
	
	/**
     * Chart used to generate output.
     *
     * @var Chart
     */
    private $control;
	
	/**
     * Dashboard used to generate output.
     *
     * @var Dashboard
     */
    private $dashboard;
    
    /**
     * HTML element id to output the chart into.
     *
     * @var string
     */
    private $elementId;

    /**
     * Event used to generate output.
     *
     * @var Event
     */
    private $event;

    /**
     * Tracks if the lava js core and jsapi have been rendered.
     *
     * @var bool
     */
    private $coreJsRendered = false;

    /**
     * Opening javascript tag.
     *
     * @var string
     */
    private $jsO = '<script type="text/javascript">';

    /**
     * Closing javascript tag.
     *
     * @var string
     */
    private $jsC = '</script>';

    /**
     * Javscript block with a link to Google's Chart API.
     *
     * @var string
     */
    private $jsAPI = '<script type="text/javascript" src="//www.google.com/jsapi"></script>';

    /**
     * Google's DataTable Version
     *
     * @var string
     */
    private $googleDataTableVer = '0.6';


    /**
     * Checks the Chart for DataTable and builds the Javascript code block
     *
     * Build the script block for the actual chart and passes it back to
     * output function of the calling chart object. If there are any
     * events defined, they will be automatically be attached to the chart and
     * pulled from the callbacks folder.
     *
     * @access public
     *
     * @uses   Chart
     * @param  Chart             $chart     Chart object to render.
     * @param  string            $elementId HTML element id to output the chart into.
     * @throws DataTableNotFound
     * @throws InvalidElementId
     *
     * @return string Javascript code block.
     */
    public function getChartJs(Chart $chart, $elementId = null)
    {
        if (isset($chart->datatable) === false) {
            throw new DataTableNotFound($chart);
        }

        if (Utils::nonEmptyString($elementId) === false) {
            throw new InvalidElementId($elementId);
        }

        $this->chart     = $chart;
        $this->elementId = $elementId;
		$this->chart->setElementId($elementId);
        return $this->buildChartJs();
    }
    
    /**
     * Checks the Chart for DataTable and builds the Javascript code block
     *
     * Build the script block for the actual chart and passes it back to
     * output function of the calling chart object. If there are any
     * events defined, they will be automatically be attached to the chart and
     * pulled from the callbacks folder.
     *
     * @access public
     *
     * @uses   Chart
     * @param  Chart             $chart     Chart object to render.
     * @param  string            $elementId HTML element id to output the chart into.
     * @throws DataTableNotFound
     * @throws InvalidElementId
     *
     * @return string Javascript code block.
     */
    public function getChartWrapperJs(Chart $chart, $elementId = null)
    {
        
        if (Utils::nonEmptyString($elementId) === false) {
            throw new InvalidElementId($elementId);
        }
		$this->chart     = $chart;
        $this->chart->setElementId( $elementId );

        return $this->buildChartWrapperJs();
    }
    
    /**
     * Checks the Chart for DataTable and builds the Javascript code block
     *
     * Build the script block for the actual chart and passes it back to
     * output function of the calling chart object. If there are any
     * events defined, they will be automatically be attached to the chart and
     * pulled from the callbacks folder.
     *
     * @access public
     *
     * @uses   Chart
     * @param  Chart             $chart     Chart object to render.
     * @param  string            $elementId HTML element id to output the chart into.
     * @throws DataTableNotFound
     * @throws InvalidElementId
     *
     * @return string Javascript code block.
     */
    public function getControlWrapperJs(Control $control, $elementId = null)
    {
        
        if (Utils::nonEmptyString($elementId) === false) {
            throw new InvalidElementId($elementId);
        }

        $this->control     = $control;
        $this->control->setElementId( $elementId );

        return $this->buildControlWrapperJs();
    }
    
    /**
     * Checks the Dashboard for DataTable and builds the Javascript code block
     *
     * Build the script block for the actual dashboard and passes it back to
     * output function of the calling chart object. If there are any
     * events defined, they will be automatically be attached to the chart and
     * pulled from the callbacks folder.
     *
     * @access public
     *
     * @uses   Dashboard
     * @param  Bashboard             $dashboard     Dashboard object to render.
     * @param  string            $elementId HTML element id to output the chart into.
     * @throws DataTableNotFound
     * @throws InvalidElementId
     *
     * @return string Javascript code block.
     */
    public function getDashboardJs(Dashboard $dashboard, $elementId = null)
    {
        if (isset($dashboard->datatable) === false) {
            throw new DataTableNotFound($dashboard);
        }

        if (Utils::nonEmptyString($elementId) === false) {
            throw new InvalidElementId($elementId);
        }

        $this->dashboard    = $dashboard;
        $this->elementId 	= $elementId;

        return $this->buildDashboardJs();
    }

	/**
     * Builds the Javascript code block
     *
     * Build the script block for the chart. If there are any events defined,
     * they will be automatically be attached to the chart and
     * pulled from the callbacks folder.
     *
     * @access private
     *
     * @return string Javascript code block.
     */
    private function buildChartJs()
    {
        $out = $this->jsO.PHP_EOL;

        /*
         *  If the object does not exist for a given chart type, initialise it.
         *  This will prevent overriding keys when multiple charts of the same
         *  type are being rendered on the same page.
         */
        $out .= sprintf(
            'if ( typeof lava.charts.%1$s == "undefined" ) { lava.charts.%1$s = {}; }',
            $this->chart->getType() 
        ).PHP_EOL.PHP_EOL;
		
		$out .= sprintf(
            "google.load('visualization', '%s', {'packages':['%s']});",
            $this->getChartPackageData('version'),
            $this->getChartPackageData('type')
        ).PHP_EOL;
		
        //Creating new chart js object
        $out .= sprintf(
            'lava.charts.%s["%s"] = new lava.Chart;',
            $this->chart->getType() ,
            $this->chart->label
        ).PHP_EOL.PHP_EOL;

        //Checking if output div exists
        $out .= sprintf(
            'if (!document.getElementById("%1$s"))' .
            '{console.error("[Lavacharts] No matching element was found with ID \"%1$s\"");}',
            $this->elementId
        ).PHP_EOL.PHP_EOL;
        
        $out .= sprintf(
            'lava.charts.%s["%s"].init = function() {',
            $this->chart->getType() ,
            $this->chart->label
        ).PHP_EOL;
		
        $out .= sprintf(
            'var $this = lava.charts.%s["%s"];',
            $this->chart->getType() ,
            $this->chart->label
        ).PHP_EOL.PHP_EOL;
		
        $out .= sprintf(
            '$this.data = new google.visualization.DataTable(%s, %s);',
            $this->chart->datatable->toJson(),
            $this->googleDataTableVer
        ).PHP_EOL;
        
        $out .= sprintf(
            '$this.options = %s;',
            $this->chart->optionsToJson()
        ).PHP_EOL.PHP_EOL;
		
		$out .= sprintf(
            '$this.chart = new google.visualization.%s(document.getElementById("%s"));',
            $this->chart->getType() ,
            $this->chart->getElementId()
        ).PHP_EOL.PHP_EOL;
		
        if ($this->chart->datatable->hasFormats()) {
            $out .= $this->buildFormatters();
        }

        if ($this->chart->hasEvents()) {
            $out .= $this->buildEventCallbacks();
        }

        $out .= '$this.chart.draw($this.data, $this.options);'.PHP_EOL;

        $out .= "};".PHP_EOL.PHP_EOL;


        $out .= sprintf(
            'lava.charts.%1$s["%2$s"].setData = function (data) {' .
            '    var $this = lava.charts.%1$s["%2$s"];',
            $this->chart->getType() ,
            $this->chart->label
        ).PHP_EOL;

        $out .= sprintf(
            '$this.data = new google.visualization.DataTable(data, %s);',
            $this->googleDataTableVer
        ).PHP_EOL;

        $out .= "};".PHP_EOL.PHP_EOL;
		
        $out .= sprintf(
            'lava.charts.%1$s["%2$s"].redraw = function () {' .
            '    var $this = lava.charts.%1$s["%2$s"];' .
            '    $this.chart.draw($this.data, $this.options);' .
            '};',
            $this->chart->getType() ,
            $this->chart->label
        ).PHP_EOL;

        

        $out .= sprintf(
            'google.setOnLoadCallback(lava.charts.%s["%s"].init );',
            $this->chart->getType() ,
            $this->chart->label
        ).PHP_EOL;

        $out .= sprintf(
            'lava.register("%s", "%s");',
            $this->chart->getType() ,
            $this->chart->label
        ).PHP_EOL.PHP_EOL;

        $out .= $this->jsC.PHP_EOL;

        return $out;
    }

    /**
     * Builds the Javascript code block
     *
     * Build the script block for the chart. If there are any events defined,
     * they will be automatically be attached to the chart and
     * pulled from the callbacks folder.
     *
     * @access private
     *
     * @return string Javascript code block.
     */
    private function buildChartWrapperJs()
    {
        $out = $this->jsO.PHP_EOL;
        /*
         *  If the object does not exist for a given chart type, initialise it.
         *  This will prevent overriding keys when multiple charts of the same
         *  type are being rendered on the same page.
         */
        $out .= sprintf(
            'if ( typeof lava.charts.%1$s == "undefined" ) { lava.charts.%1$s = {}; }',
            $this->chart->getType() 
        ).PHP_EOL.PHP_EOL;
		$out .= sprintf(
            "google.load('visualization', '%s', {'packages':['%s']});",
            $this->getChartPackageData('version'),
            $this->getChartPackageData('type')
        ).PHP_EOL;
        //Creating new chart js object
        $out .= sprintf(
            'lava.charts.%s["%s"] = new lava.Chart;',
            $this->chart->getType() ,
            $this->chart->label
        ).PHP_EOL.PHP_EOL;

        //Checking if output div exists
        $out .= sprintf(
            'if (!document.getElementById("%1$s"))' .
            '{console.error("[Lavacharts] No matching element was found with ID \"%1$s\"");}',
            $this->chart->getElementId()
        ).PHP_EOL.PHP_EOL;
        
        $out .= sprintf(
            'lava.charts.%s["%s"].init = function() {',
            $this->chart->getType() ,
            $this->chart->label
        ).PHP_EOL;
        
        $out .= sprintf(
            'var $this = lava.charts.%s["%s"];',
            $this->chart->getType() ,
            $this->chart->label
        ).PHP_EOL.PHP_EOL;
        
        $out .= sprintf(
            '$this.options = %s;',
            $this->chart->optionsToJson()
        ).PHP_EOL.PHP_EOL;
        
        $out .= sprintf(
            '$this.chartType = "%s";',
            $this->chart->getType() 
        ).PHP_EOL.PHP_EOL;
		
		$out .= sprintf(
            '$this.chart = new google.visualization.ChartWrapper( %s );',
            $this->chart->getChartWrapperJson()
        ).PHP_EOL.PHP_EOL;
		//Not sure how to add this stuff yet.
		/*
        if ($this->chart->datatable->hasFormats()) {
            $out .= $this->buildFormatters();
        }

        if ($this->chart->hasEvents()) {
            $out .= $this->buildEventCallbacks();
        }
		*/
        $out .= "};".PHP_EOL.PHP_EOL;


		$out .= sprintf(
            'google.setOnLoadCallback(lava.charts.%s["%s"].init );',
            $this->chart->getType() ,
            $this->chart->label
        ).PHP_EOL;

        $out .= sprintf(
            'lava.register("%s", "%s");',
            $this->chart->getType() ,
            $this->chart->label
        ).PHP_EOL.PHP_EOL;

		$out .= $this->jsC.PHP_EOL;
		return $out;
    }
    
    /**
     * Builds the Javascript code block
     *
     * Build the script block for the chart. If there are any events defined,
     * they will be automatically be attached to the chart and
     * pulled from the callbacks folder.
     *
     * @access private
     *
     * @return string Javascript code block.
     */
    private function buildControlWrapperJs()
    {
        $out = $this->jsO.PHP_EOL;
        /*
         *  If the object does not exist for a given chart type, initialise it.
         *  This will prevent overriding keys when multiple charts of the same
         *  type are being rendered on the same page.
         */
        $out .= sprintf(
            'if ( typeof lava.controls.%1$s == "undefined" ) { lava.controls.%1$s = {}; }',
            $this->control->type
        ).PHP_EOL.PHP_EOL;
		$out .= sprintf(
            "google.load('visualization', '%s', {'packages':['%s']});",
            $this->getChartPackageData('version'),
            $this->getChartPackageData('type')
        ).PHP_EOL;
		//Creating new chart js object
        $out .= sprintf(
            'lava.controls.%s["%s"] = new lava.Control;',
            $this->control->type,
            $this->control->label
        ).PHP_EOL.PHP_EOL;

        //Checking if output div exists
        $out .= sprintf(
            'if (!document.getElementById("%1$s"))' .
            '{console.error("[Lavacharts] No matching element was found with ID \"%1$s\"");}',
            $this->control->getElementId()
        ).PHP_EOL.PHP_EOL;
        
        $out .= sprintf(
            'lava.controls.%s["%s"].init = function() {',
            $this->control->type,
            $this->control->label
        ).PHP_EOL;
        
        $out .= sprintf(
            'var $this = lava.controls.%s["%s"];',
            $this->control->type,
            $this->control->label
        ).PHP_EOL.PHP_EOL;
        
        $out .= sprintf(
            '$this.options = %s;',
            $this->control->optionsToJson()
        ).PHP_EOL.PHP_EOL;
        
        $out .= sprintf(
            '$this.controlType = "%s";',
            $this->control->type
        ).PHP_EOL.PHP_EOL;
		
		$out .= sprintf(
            '$this.control = new google.visualization.ControlWrapper( %s );',
            $this->control->getControlWrapperJson()
        ).PHP_EOL.PHP_EOL;
        
		$out .= "};".PHP_EOL.PHP_EOL;
		
        $out .= sprintf(
            'google.setOnLoadCallback(lava.controls.%s["%s"].init );',
            $this->control->type,
            $this->control->label
        ).PHP_EOL;
		
        $out .= sprintf(
            'lava.registerControl("%s", "%s");',
            $this->control->type,
            $this->control->label
        ).PHP_EOL.PHP_EOL;

		$out .= $this->jsC.PHP_EOL;

        return $out;
    }
    
    /**
     * Builds the Javascript code block
     *
     * Build the script block for the chart. If there are any events defined,
     * they will be automatically be attached to the chart and
     * pulled from the callbacks folder.
     *
     * @access private
     *
     * @return string Javascript code block.
     */
    private function buildBindingsJs()
    {
        $out = '$this.dashboard';
        $bindings = $this->dashboard->getBindings();
        if( is_array($bindings) && count($bindings) > 0 ){
	       foreach( $bindings as $controls => $charts ){
		        $controls	 	= explode('|', $controls);
		        $controlType 	= $controls[0];
		        $controlLabel	= $controls[1];
		        
		        $controlJSB = sprintf( 'lava.controls.%s["%s"].control', $controlType,  $controlLabel ).PHP_EOL.PHP_EOL; 
		        
		        if (is_array($charts) && count($charts) > 0) {
		            $out .= sprintf(
				            '.bind( %s , [', $controlJSB ).PHP_EOL.PHP_EOL;
		            $i=0;
		            foreach ($charts as $chartKey => $chart) {
		               
		                $chart		= is_int($chartKey)?($chart):$chartKey;
		                if( is_array($chart) ){ $chart = $chart[0];}
		                
		                $chart 		= explode('|', $chart);
		                 
				        $chartType 	= $chart[0];
						$chartLabel	= $chart[1];
						
				        $chartJSB = sprintf( 'lava.charts.%s["%s"].chart',  $chartType, $chartLabel ).PHP_EOL.PHP_EOL;
				        
				        $out .= $chartJSB.', ';
		            }
		            $out .= '] )';
		        } else if(is_string($charts) && strlen($charts) > 0 ){
			        $charts 	= explode('|', $charts);
			        $chartType 	= $charts[0];
					$chartLabel	= $charts[1];
					
			        $chartJSB = sprintf( 'lava.charts.%s["%s"].chart',  $chartType, $chartLabel ).PHP_EOL.PHP_EOL;
			        
			        $out .= sprintf( '.bind( %s , %s )', $controlJSB, $chartJSB ).PHP_EOL.PHP_EOL;
		        } else {
		            throw $this->invalidConfigValue(
		                __FUNCTION__,
		                'array | string'
		            );
		        }
	        }
	        $out .= ';'; 
        } else {
            throw $this->invalidConfigValue(
                __FUNCTION__,
                'array'
            );
        }

        return $out;
    }
    
    
    
    /**
     * Builds the Javascript code block
     *
     * Build the script block for the dashboard. If there are any events defined,
     * they will be automatically be attached to the dashboard and
     * pulled from the callbacks folder.
     *
     * @access private
     *
     * @return string Javascript code block.
     */
    private function buildDashboardJs()
    {
        $out = $this->jsO.PHP_EOL;

        /*
         *  If the object does not exist for a given dashboard type, initialise it.
         *  This will prevent overriding keys when multiple dashboards of the same
         *  type are being rendered on the same page.
         */
        $out .= sprintf(
            'if ( typeof lava.dashboards.%1$s == "undefined" ) { lava.dashboards.%1$s = {}; }',
            $this->dashboard->type
        ).PHP_EOL.PHP_EOL;
		
		$out .= sprintf(
            "google.load('visualization', '%s', {'packages':['%s']});",
            $this->getDashboardPackageData('version'),
            $this->getDashboardPackageData('type')
        ).PHP_EOL;
		//Creating new chart js object
        $out .= sprintf(
            'lava.dashboards.%s["%s"] = new lava.Dashboard;',
            $this->dashboard->type,
            $this->dashboard->label
        ).PHP_EOL.PHP_EOL;

        //Checking if output div exists
        $out .= sprintf(
            'if (!document.getElementById("%1$s"))' .
            '{console.error("[Lavacharts] No matching element was found with ID \"%1$s\"");}',
            $this->elementId
        ).PHP_EOL.PHP_EOL;
        
        $out .= sprintf(
            'lava.dashboards.%s["%s"].init = function() {',
            $this->dashboard->type,
            $this->dashboard->label
        ).PHP_EOL;

        $out .= sprintf(
            'var $this = lava.dashboards.%s["%s"];',
            $this->dashboard->type,
            $this->dashboard->label
        ).PHP_EOL.PHP_EOL;
		
		
        $out .= sprintf(
            '$this.data = new google.visualization.DataTable(%s, %s);',
            $this->dashboard->datatable->toJson(),
            $this->googleDataTableVer
        ).PHP_EOL;
        
        $out .= sprintf(
            '$this.options = %s;',
            $this->dashboard->optionsToJson()
        ).PHP_EOL.PHP_EOL;
        
		$out .= sprintf(
            '$this.dashboard = new google.visualization.Dashboard(document.getElementById("%s"));',
            $this->elementId
        ).PHP_EOL.PHP_EOL;
		
		$out .= $this->buildBindingsJS();
		
        $out .= '$this.dashboard.draw($this.data);'.PHP_EOL;

        $out .= "};".PHP_EOL.PHP_EOL;

        $out .= sprintf(
            'lava.dashboards.%1$s["%2$s"].setDashboardData = function (data) {' .
            '    var $this = lava.dashboards.%1$s["%2$s"];',
            $this->dashboard->type,
            $this->dashboard->label
        ).PHP_EOL;

        $out .= sprintf(
            '$this.data = new google.visualization.DataTable(data, %s);',
            $this->googleDataTableVer
        ).PHP_EOL;

        $out .= "};".PHP_EOL.PHP_EOL;
		
        $out .= sprintf(
            'lava.dashboards.%1$s["%2$s"].redraw = function () {' .
            '    var $this = lava.dashboards.%1$s["%2$s"];' .
            '    $this.dashboards.draw($this.data);' .
            '};',
            $this->dashboard->type,
            $this->dashboard->label
        ).PHP_EOL;
		
        $out .= sprintf(
            'google.setOnLoadCallback(lava.dashboards.%s["%s"].init );',
            $this->dashboard->type,
            $this->dashboard->label
        ).PHP_EOL;
        
        $out .= sprintf(
            'lava.registerDashboard("%s", "%s");',
            $this->dashboard->type,
            $this->dashboard->label
        ).PHP_EOL.PHP_EOL;

        $out .= $this->jsC.PHP_EOL;

        return $out;
    }
	
	private function getControlTables($control, $chartsList){
		foreach($control->getCharts() as $typeKey => $type){
			foreach($type as $chartKey => $chart){
				if( !empty($chartsList[$typeKey]) ){
					if(!in_array($chart->label, $chartsList[$typeKey])){
						$chartsList[$typeKey] = array_merge($chartsList[$typeKey], [$chartKey => $chart]);
					}
				}else{
					$chartsList[$typeKey] = [$chartKey => $chart];
				}
			}
		}
		return $chartsList;
	}
	
	
    /**
     * Returns the chart package data.
     *
     * @access private
     * @param  string $which
     *
     * @return stdClass chart package, version, and type
     */
    private function getChartPackageData($which)
    {
        $package = array();

        switch ($this->chart->getType() ) {
            case 'AnnotatedTimeLine':
                $package['type']    = 'annotatedtimeline';
                $package['jsObj']   = $this->chart->getType();
                $package['version'] = '1';
                break;

            case 'GeoChart':
                $package['type']    = 'geochart';
                $package['jsObj']   = $this->chart->getType();
                $package['version'] = '1';
                break;

            case 'DonutChart':
                $package['type']    = 'corechart';
                $package['jsObj']   = 'PieChart';
                $package['version'] = '1';
                break;

            case 'CalendarChart':
                $package['type']    = 'calendar';
                $package['jsObj']   = 'Calendar';
                $package['version'] = '1.1';
                break;

            case 'GaugeChart':
                $package['type']    = 'gauge';
                $package['jsObj']   = 'Gauge';
                $package['version'] = '1';
                break;
			case 'Table':
				$package['type']    = 'table';
                $package['jsObj']   = 'Table';
                $package['version'] = '1';
				break;
            default:
                $package['type']    = 'corechart';
                $package['jsObj']   = $this->chart->getType();
                $package['version'] = '1';
                break;
        }
		//$package['type']    = 'controls, table, corechart';
        return $package[$which];
    }
    /**
     * Returns the dashboard package data.
     *
     * @access private
     * @param  string $which
     *
     * @return stdClass chart package, version, and type
     */
    private function getDashboardPackageData($which)
    {
        $package = [
	        'type'		=> 'controls',
	        'jsObj'		=> $this->chart->getType(),
	        'version'	=> '1'
        ];

        return $package[$which];
    }

    /**
     * Builds the javascript object of event callbacks.
     *
     * @access private
     *
     * @return string Javascript code block.
     */
    private function buildEventCallbacks()
    {
        $out = '';

        foreach ($this->chart->getEvents() as $event) {
            $callback = sprintf(
                'function (event) {return lava.event(event, $this.chart, %s);}',
                $event->callback
            );

            $out .= sprintf(
                'google.visualization.events.addListener($this.chart, "%s", %s);',
                $event::TYPE,
                $callback
            ).PHP_EOL.PHP_EOL;

        }

        return $out;
    }


    /**
     * Builds the javascript for the datatable column formatters.
     *
     * @access private
     *
     * @return string Javascript code block.
     */
    private function buildFormatters()
    {
        $out = '';

        foreach ($this->chart->datatable->getFormats() as $index => $format) {
            $out .= sprintf(
                '$this.formats["col%s"] = new google.visualization.%s(%s);',
                $index,
                $format::TYPE,
                $format->toJson()
            ).PHP_EOL;

            $out .= sprintf(
                '$this.formats["col%1$s"].format($this.data, %1$s);',
                $index
            ).PHP_EOL.PHP_EOL;
        }

        return $out;
    }

    /**
     * True if the lava object and jsapi have been added to the page.
     *
     * @access private
     *
     * @return bool
     */
    public function coreJsRendered($stat = false)
    {
        if ($stat !== false) {
            $this->coreJsRendered = $stat;
        }

        return $this->coreJsRendered;
    }

    /**
     * Builds the javascript lava object for chart interation.
     *
     * @access public
     *
     * @return string Javascript code blocks.
     */
    public function getCoreJs()
    {
        $out  = $this->jsAPI;
        $out .= $this->jsO;
        $out .= file_get_contents(__DIR__.'/../javascript/lava.js');
        $out .= $this->jsC;

        return $out;
    }
}
