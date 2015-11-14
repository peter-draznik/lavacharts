<?php namespace Khill\Lavacharts\Controls;

/**
 * Chart Control, Parent to all controls.
 *
 * Has common properties and methods used between all the different controls.
 *
 *
 * @package    Lavacharts
 * @subpackage Control
 * @author     Peter Draznik <peter.draznik@38thStreetStudios.com>
 * @since      v3.0.0
 * @copyright  (c) 2015, 38th Street Studios
 * Uses the project below
 * @link       http://github.com/kevinkhill/lavacharts GitHub Repository Page
 * @link       http://lavacharts.com                   Official Docs Site
 * @license    http://opensource.org/licenses/MIT MIT
 */

use Khill\Lavacharts\Utils;
use Khill\Lavacharts\JavascriptFactory;
use Khill\Lavacharts\Charts\Chart;
use Khill\Lavacharts\Exceptions\InvalidElementId;
use Khill\Lavacharts\Exceptions\InvalidConfigProperty;
use Khill\Lavacharts\Exceptions\InvalidConfigValue;
use Khill\Lavacharts\Configs\Ui;

class Control
{
    public $controlType		= null;
    public $containerId		= null;
    public $label         	= null;
    //public $boundCharts		= [];

    protected $defaults  	= null;
    protected $events    	= [];
    protected $options   	= [];
    protected $elementId	= '';

    /**
     * Builds a new chart with a label.
     *
     * @param string $chartLabel Label for the chart accessed via the Volcano.
     */
    public function __construct($controlLabel)
    {
        $this->label = $controlLabel;
        $this->defaults = array(
	        'boundCharts',
            'filterColumnIndex',
            'filterColumnLabel',
            'ui',
            
        );
    }
	
	
    /**
     * Adds a configuration option
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
        if (is_string($o) &&  array_key_exists($o, $this->options)) {
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
     * Gets the current chart options.
     *
     * @return array
     */
    public function getCharts()
    {
        return $this->charts;
    }

    /**
     * Gets a specific option from the array.
     *
     * @param  string             $o Which option to fetch
     * @throws InvalidConfigValue
     * @return mixed
     */
    public function getChart($o)
    {
        if (is_string($o) && array_key_exists($o, $this->charts)) {
            return $this->charts[$o];
        } else {
            throw $this->invalidConfigValue(
                __FUNCTION__,
                'string',
                "must be one of ".Utils::arrayToPipedString($this->charts)//Probably don't want to error out all data
            );
        }
    }
	
	public function setElementId($elementId)
	{
		if (Utils::nonEmptyString($elementId) === false) {
            throw new InvalidElementId($elementId);
        }
		
		$this->elementId = $elementId;
	}
	
	public function getElementId()
	{
		return $this->elementId;
	}
	
	public function getControlWrapperJson()
	{
		$wrapper = [
			'controlType'	=> $this->type,
			'options'		=> $this->options,
			'containerId'	=> $this->elementId
		];
		return json_encode($wrapper);
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
    protected function filterColumnIndex($o)
    {
        if (is_int($o)) {
            return $this->addOption(array(__FUNCTION__ => $o));
        } else {
            throw $this->invalidConfigValue(
                __FUNCTION__,
                'int'
            );
        }
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
    public function filterColumnLabel($o)
    {
        if (is_string($o)) {
            return $this->addOption(array(__FUNCTION__ => $o));
        } else {
            throw $this->invalidConfigValue(
                __FUNCTION__,
                'string'
            );
        }
    }
	
	/**
     * An object with members to configure various aspects of the control's UI. To specify 
     * properties of this object, you can use object literal notation, as shown here:
	 * {label: 'Metric', labelSeparator: ':'}

     *
     * @uses  Ui
     * @param Ui $ui
     *
     * @return Control
     */
    public function ui(Ui $ui)
    {
        return $this->addOption($ui->toArray(__FUNCTION__));
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

        return $jsf->getControlWrapperJs($this, $ei);
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
