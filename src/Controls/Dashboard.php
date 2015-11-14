<?php namespace Khill\Lavacharts\Controls;

/**
 * Dashboard Class, Contains charts and controls.
 *
 * 
 *
 *
 * @package    Lavacharts
 * @subpackage Charts
 * @author     Peter Draznik <peter.draznik@38thStreetStudios.com>
 * @since      v3.0.0
 * @copyright  (c) 2015, 38th Street Studios
 * Uses the project below.
 * @link       http://github.com/kevinkhill/lavacharts GitHub Repository Page
 * @link       http://lavacharts.com                   Official Docs Site
 * @license    http://opensource.org/licenses/MIT MIT
 */

use Khill\Lavacharts\Utils;
use Khill\Lavacharts\JavascriptFactory;
use Khill\Lavacharts\Controls\Control;
use Khill\Lavacharts\Configs\DataTable;
use Khill\Lavacharts\Exceptions\InvalidElementId;
use Khill\Lavacharts\Exceptions\InvalidConfigProperty;
use Khill\Lavacharts\Exceptions\InvalidConfigValue;

class Dashboard
{
    public $type          	= 'Dashboard';
    public $label         	= null;
    public $datatable     	= null;
    public $deferedRender	= false;
    public $bindings		= [];

    protected $defaults  	= null;
    protected $events    	= array();
    protected $options   	= array();
    protected $elementId	= '';

    /**
     * Builds a new chart with a label.
     *
     * @param string $chartLabel Label for the chart accessed via the Volcano.
     */
    public function __construct($dashboardLabel)
    {
        $this->label = $dashboardLabel;
        $this->defaults = array(
            'datatable',
            'bindings',
            'height',
            'width',
        );
    }

	
    public function setControls($controls)
    {
    	if (is_array($controls) && count($control) > 0) {
            foreach ($controls as $control => $value) {
                 if (in_array($control, $this->defaults)) {
                    $this->$control($value);
                } else {
                    throw new InvalidConfigProperty(
                        $this->type,
                        __FUNCTION__,
                        $control,
                        $this->defaults
                    );
                }
            }
        } else {
            throw $this->invalidConfigValue(
                __FUNCTION__,
                'array'
            );
        }
    }

    /**
     * Binds a control, table pair to the dashboard
     *
     * Accepts a string $controlType and a string $controlLabel, which are added to
     * $boundControls if the pairing is unique to the array. 
     *
     * @param mixed $o
     *
     * @return this
     */
     
    protected function makeBinding($control, $chart)
    {
	    if ( Utils::nonEmptyString($control) && Utils::nonEmptyString($chart) ) {
            if(empty($this->bindings[$control])){
	            $this->bindings[$control] 		= [$chart];
            }else{
	            $this->bindings[$control][] 	= [$chart];
            }
        } else {
            throw new InvalidConfigProperty(
                $control,
                __FUNCTION__,
                $chart,
                'Control'
            );
        }
        
        return $this;
    }
    
    
    /**
     * Binds controls to the dashobard.
     *
     * Takes an array of with key value pairs of $controlType=>$controlLabels,
     * where $controlLabels is an array of the control labels for each type of control.
     *
     * ex. 
     * 		$controls = ['NumberRangeFilter|StocksOfficialFilter' => ['GoogleTable|StocksTable', 'LineChart|Stocks'] ];
     * alternatively accepted when only one control for a control type: 
     * 		$bindings = ['NumberRangeFilter|StocksOfficialFilter' => 'GoogleTable|StocksTable' ];
     *
     * @param  array                 $controls
     * @throws InvalidConfigProperty
     * @throws InvalidConfigValue
     * @return null
     */
    
    public function bindings($bindings)
    {
        if (Utils::arrayIsMulti($bindings)) {
            foreach ($bindings as $control => $charts) { //or $chart=>controls
                if (Utils::arrayIsMulti($charts)) {
		            foreach ($charts as $chartKey => $chart) {
		                $chartLabel = is_int($chartKey)?$chart:$chartKey;
		                
		                if( $this->checkBindingOrdering($control) ){
			                $this->makeBinding($control, $chartLabel);
		                }else{//Flipped ordering of [fliter=>chart(s)] to [chart=>filter(s)]
			                $this->makeBinding($chartLabel, $control);
		                }
		                
		            }
		        } else if(is_string($charts) && strlen($charts) > 0 ){
			        if( $this->checkBindingOrdering($control) ){
		                $this->makeBinding($control, $charts);
	                }else{
		                $this->makeBinding($chartLabel, $control);
	                }
			        
		        } else {
		            throw $this->invalidConfigValue(
		                __FUNCTION__,
		                'array | string'
		            );
		        }
            }
        } else {
            throw $this->invalidConfigValue(
                __FUNCTION__,
                'array'
            );
        }
    }
    
    /**
     * Gets the current chart bindings.
     *
     * @return array
     */
    private function checkBindingOrdering($firstLabel, $isControlFirst=true){
	    //$ordering=0 => [fliter=>table(s)]
	    //$ordering=1 => [chart=>filter(s)]
	    $firstLabel 	= explode('|', $firstLabel)[0];
	    $isChart  		= Utils::nonEmptyStringInArray($firstLabel, Khill\Lavacharts\Lavacharts::$chartClasses);
	    $isControl 		= Utils::nonEmptyStringInArray($firstLabel, Khill\Lavacharts\Lavacharts::$controlClasses);
	    
	    if ( $isControl ){
		    return $isControlFirst == $isControl;
	    }else if($isChart){
		    return !$isControlFirst == $isControl;
	    }
	    
	    return false;
    }
    
    /**
     * Gets the current chart bindings.
     *
     * @return array
     */
    public function getBindings(){
	    return $this->bindings;
    }
    
    /**
     * Gets the current chart options.
     *
     * @return array
     */
    public function getControls()
    {
        return $this->boundControls;
    }

    /**
     * Gets a specific option from the array.
     *
     * @param  string             $o Which option to fetch
     * @throws InvalidConfigValue
     * @return mixed
     */
    public function getControl($o)
    {
        if (is_string($o) && array_key_exists($o, $this->controls)) {
            return $this->controls[$o];
        } else {
            throw $this->invalidConfigValue(
                __FUNCTION__,
                'string',
                "must be one of ".Utils::arrayToPipedString($this->controls)//Probably don't want to error out all data
            );
        }
    }

    /**
     * Sets a configuration option
     *
     * Takes an array with option => value, or an object created by
     * one of the configOptions child objects.
     *
     * @param mixed $o
     *
     * @return this
     */
    protected function addOption($o)
    {
        if (is_array($o)) {
            $this->options = array_merge($this->options, $o);
        } else {
            throw $this->invalidConfigValue(
                __FUNCTION__,
                'array'
            );
        }

        return $this;
    }
    public function addControl(Control $control)
    {//Need to change datatype check and exception
    	if (is_array($control)) {
            $this->controls = array_merge($this->controls, $control);
        } else {
            throw $this->invalidConfigValue(
                __FUNCTION__,
                'array'
            );
        }

        return $this;
    }

    /**
     * Sets configuration options from array of values
     *
     * You can set the options all at once instead of passing them individually
     * or chaining the functions from the chart objects.
     *
     * @param  array                 $o
     * @throws InvalidConfigProperty
     * @throws InvalidConfigValue
     * @return Chart
     */
    public function setOptions($o)
    {
        if (is_array($o) && count($o) > 0) {
            foreach ($o as $option => $value) {
                if (in_array($option, $this->defaults)) {
                    $this->$option($value);
                } else {
                    throw new InvalidConfigProperty(
                        $this->type,
                        __FUNCTION__,
                        $option,
                        $this->defaults
                    );
                }
            }
        } else {
            throw $this->invalidConfigValue(
                __FUNCTION__,
                'array'
            );
        }
    }
    
    


	/**
     * Gets the current chart options.
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }
    /**
     * Gets a specific option from the array.
     *
     * @param  string             $o Which option to fetch
     * @throws InvalidConfigValue
     * @return mixed
     */
    public function getOption($o)
    {
        if (is_string($o) && array_key_exists($o, $this->options)) {
            return $this->options[$o];
        } else {
            throw $this->invalidConfigValue(
                __FUNCTION__,
                'string',
                "must be one of ".Utils::arrayToPipedString($this->defaults)
            );
        }
    }
	
    /**
     * Checks if any events have been assigned to the chart.
     *
     * @return bool
     */
    public function hasEvents()
    {
        return count($this->events) > 0 ? true : false;
    }

    /**
     * Checks if any events have been assigned to the chart.
     *
     * @return bool
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * Returns a JSON string representation of the datatable.
     *
     * @since  v2.5.0
     * @return string
     */
    public function getDataTableJson()
    {
        return $this->datatable->toJson();
    }

    
    /**
     * Assigns wich Datatable will be used for this Chart.
     *
     * If a label is provided then the defined Datatable will be used.
     * If called with no argument, or the chart is attempted to be generated
     * without calling this function, the chart will search for a Datatable with
     * the same label as the Chart.
     *
     * @uses  Datatable
     * @param Datatable
     *
     * @return Chart
     */
    public function datatable(Datatable $d)
    {
        $this->datatable = $d;

        return $this;
    }

    /**
     * Set up the chart with no datatable to defer rendering via AJAX
     *
     * @since  v2.5.0
     * @param  bool             $dr
     * @throws InvalidElementId
     *
     * @return void
     */
    public function deferedRender($dr)
    {
        if (is_bool($dr)) {
            $this->deferedRender = $dr;
        } else {
            throw $this->invalidConfigValue(
                __FUNCTION__,
                'bool'
            );
        }

        return $this;
    }

    /**
     * Register javascript callbacks for specific events.
     *
     * Valid values include:
     * [ animationfinish | error | onmouseover | onmouseout | ready | select ]
     * associated to a respective pre-defined javascript function as the callback.
     *
     * @param  array              $e Array of events associated to a callback
     * @throws InvalidConfigValue
     *
     * @return Chart
     */
    public function events($e)
    {
        $values = array(
            'error',
            'ready',
        );

        if (is_array($e)) {
            foreach ($e as $event) {
                if (is_subclass_of($event, 'Khill\Lavacharts\Events\Event')) {
                    $this->events[] = $event;
                } else {
                    throw $this->invalidConfigValue(
                        __FUNCTION__,
                        'Event'
                    );
                }
            }
        } else {
            throw $this->invalidConfigValue(
                __FUNCTION__,
                'array'
            );
        }

        return $this;
    }

    /**
     * Height of the chart, in pixels.
     *
     * @param  int                $h
     * @throws InvalidConfigValue
     *
     * @return Chart
     */
    public function height($h)
    {
        if (is_int($h)) {
            return $this->addOption(array(__FUNCTION__ => $h));
        } else {
            throw $this->invalidConfigValue(
                __FUNCTION__,
                'int'
            );
        }
    }
    
    /**
     * Returns a JSON string representation of the chart's properties.
     *
     * @return string
     */
    public function optionsToJson()
    {
        return json_encode($this->options);
    }
    
    /**
     * Outputs the chart javascript into the page
     *
     * Pass in a string of the html elementID that you want the chart to be
     * rendered into.
     *
     * @since  v2.0.0
     * @param  string           $ei The id of an HTML element to render the chart into.
     * @throws InvalidElementId
     *
     * @return string Javscript code blocks
     */
    public function render($ei)
    {
        $jsf = new JavascriptFactory;

        return $jsf->getDashboardJs($this, $ei);
    }
    
    public function setElementId($elementId)
	{
		if (Utils::nonEmptyString($elementId) === false) {
            throw new InvalidElementId($elementId);
        }
		
		$this->elementId = $elementId;
	}

    /**
     * Width of the chart, in pixels.
     *
     * @param  int                $w
     * @throws InvalidConfigValue
     *
     * @return Chart
     */
    public function width($w)
    {
        if (is_int($w)) {
            return $this->addOption(array(__FUNCTION__ => $w));
        } else {
            throw $this->invalidConfigValue(
                __FUNCTION__,
                'int'
            );
        }
    }

    /**
     * function for easy creation of exceptions
     */
    protected function invalidConfigValue($func, $type, $extra = '')
    {
        if (! empty($extra)) {
            return new InvalidConfigValue(
                $this->type . '::' . $func,
                $type,
                $extra
            );
        } else {
            return new InvalidConfigValue(
                $this->type . '::' . $func,
                $type
            );
        }
    }
}
