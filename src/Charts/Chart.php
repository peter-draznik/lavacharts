<?php

namespace Khill\Lavacharts\Charts;

use \Khill\Lavacharts\Utils;
use \Khill\Lavacharts\Values\Label;
use \Khill\Lavacharts\Values\ElementId;
use \Khill\Lavacharts\Javascript\JavascriptFactory;
use \Khill\Lavacharts\Configs\DataTable;
use \Khill\Lavacharts\Configs\Animation;
use \Khill\Lavacharts\Configs\Legend;
use \Khill\Lavacharts\Configs\Tooltip;
use \Khill\Lavacharts\Configs\TextStyle;
use \Khill\Lavacharts\Configs\ChartArea;
use \Khill\Lavacharts\Configs\BackgroundColor;
use \Khill\Lavacharts\Exceptions\DataTableNotFound;
use \Khill\Lavacharts\Exceptions\InvalidElementId;
use \Khill\Lavacharts\Exceptions\InvalidConfigProperty;
use \Khill\Lavacharts\Exceptions\InvalidConfigValue;

/**
 * Chart Class, Parent to all charts.
 *
 * Has common properties and methods used between all the different charts.
 *
 *
 * @package    Lavacharts
 * @subpackage Charts
 * @author     Kevin Hill <kevinkhill@gmail.com>
 * @copyright  (c) 2015, KHill Designs
 * @link       http://github.com/kevinkhill/lavacharts GitHub Repository Page
 * @link       http://lavacharts.com                   Official Docs Site
 * @license    http://opensource.org/licenses/MIT MIT
 */
class Chart
{
<<<<<<< HEAD
    /**
     * The chart's unique label.
     *
     * @var \Khill\Lavacharts\Values\Label
     */
    protected $label = null;

    /**
     * The chart's datatable.
     *
     * @var DataTable
     */
    protected $datatable = null;

    /**
     * The chart's defined events.
     *
     * @var array
     */
    protected $events = [];

    /**
     * The chart's user set options.
     *
     * @var array
     */
    protected $options = [];

    /**
     * The chart's default options.
     *
     * @var array
     */
    protected $defaults = [
        'animation',
        'backgroundColor',
        'chartArea',
        'colors',
        'datatable',
        'events',
        'fontSize',
        'fontName',
        'height',
        'legend',
        'title',
        'titlePosition',
        'titleTextStyle',
        'tooltip',
        'width'
    ];

=======
    public $type          = null;
    public $label         = null;
    public $datatable     = null;
    public $deferedRender = false;
    

    protected $defaults  = null;
    protected $events    = array();
    protected $options   = array();
    protected $elementId  = null;
>>>>>>> 2.6

    /**
     * Builds a new chart with the given label.
     *
     * @param  \Khill\Lavacharts\Values\Label $chartLabel Identifying label for the chart.
     * @param  \Khill\Lavacharts\Configs\DataTable $datatable Datatable used for the chart.
     * @param  array $options Array of options to set on the chart.
     * @return self
     */
    public function __construct(Label $chartLabel, DataTable $datatable, $options=[])
    {
        if (empty($options) === false) {
            $this->setOptions($options);
        }

        $this->label     = $chartLabel;
        $this->datatable = $datatable;
    }
/* @TODO: see if child charts can have defaults as properties and the parent constructor merge them.
    public function mergeDefaultOptions($childDefaults)
    {
        $this->defaults = array_merge($childDefaults, $this->defaults);
    }
*/
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

    /**
     * Sets configuration options from array of values
     *
     * You can set the options all at once instead of passing them individually
     * or chaining the functions from the chart objects.
     *
     * @param  array $options
     * @throws \Khill\Lavacharts\Exceptions\InvalidConfigProperty
     * @throws \Khill\Lavacharts\Exceptions\InvalidConfigValue
     * @return self
     */
    public function setOptions($options)
    {
        if (is_array($options) === false || count($options) == 0) {
            throw $this->invalidConfigValue(
                __FUNCTION__,
                'array'
            );
        }

        foreach ($options as $option => $value) {
            if (in_array($option, $this->defaults)) {
                $this->$option($value);
            } else {
                throw new InvalidConfigProperty(
                    static::TYPE,
                    __FUNCTION__,
                    $option,
                    $this->defaults
                );
            }
        }

        return $this;
    }

    /**
     * Gets a specific option from the array.
     *
     * @param  string             $option Which option to fetch
     * @throws \Khill\Lavacharts\Exceptions\InvalidConfigValue
     * @return mixed
     */
    public function getOption($option)
    {
        if (is_string($option) === false || array_key_exists($option, $this->options) === false) {
            throw $this->invalidConfigValue(
                __FUNCTION__,
                'string',
                'must be one of '.Utils::arrayToPipedString($this->defaults)
            );
        }

        return $this->options[$option];
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
     * Returns a JSON string representation of the chart's properties.
     *
     * @return string
     */
    public function optionsToJson()
    {
        return json_encode($this->options);
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
	public function getType(){
		return str_replace('Google', '', $this->type);
	}
	public function getChartWrapperJson()
	{
		$wrapper = [
			'chartType'	=> $this->getType(),
			//'dataTable'	=> json_decode($this->getDataTableJson()) ,
			'options'	=> $this->options,
			'containerId'	=> $this->elementId
			
		];
		return json_encode($wrapper);
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
     * Returns the chart label.
     *
     * @since  3.0.0
     * @return \Khill\Lavacharts\Values\Label
     */
    public function getLabel()
    {
        return (string) $this->label;
    }

    /**
     * Assigns a datatable to use for the Chart.
     *
     * @deprecated
     * @uses   Datatable
     * @param  Datatable $datatable
     * @return self
     */
    public function datatable(Datatable $datatable)
    {
        $this->datatable = $datatable;

        return $this;
    }

    /**
     * Returns the DataTable if set, false if not set.
     *
     * @since  3.0.0
     * @throws DataTableNotFound
     * @return bool|DataTable
     */
    public function getDataTable()
    {
        if (is_null($this->datatable)) {
            throw new DataTableNotFound($this);
        }

        return $this->datatable;
    }

    /**
     * Returns a JSON string representation of the datatable.
     *
     * @since  2.5.0
     * @throws DataTableNotFound
     * @return string
     */
    public function getDataTableJson()
    {
        return $this->getDataTable()->toJson();
    }

    /**
     * Set the animation options for a chart
     *
     * @param  Animation $animation Animation config object
     * @return self
     */
    public function animation(Animation $animation)
    {
        return $this->addOption($animation->toArray());
    }

    /**
     * The background color for the main area of the chart. Can be either a simple
     * HTML color string, for example: 'red' or '#00cc00', or a backgroundColor object
     *
     * @uses  BackgroundColor
     * @param BackgroundColor $backgroundColor
     *
     * @return self
     */
    public function backgroundColor(BackgroundColor $backgroundColor)
    {
        return $this->addOption($backgroundColor->toArray());
    }

    /**
     * An object with members to configure the placement and size of the chart area
     * (where the chart itself is drawn, excluding axis and legends).
     * Two formats are supported: a number, or a number followed by %.
     * A simple number is a value in pixels; a number followed by % is a percentage.
     *
     * @uses  ChartArea
     * @param ChartArea $chartArea
     *
     * @return self
     */
    public function chartArea(ChartArea $chartArea)
    {
        return $this->addOption($chartArea->toArray());
    }

    /**
     * The colors to use for the chart elements. An array of strings, where each
     * element is an HTML color string, for example: colors:['red','#004411'].
     *
     * @param  array              $cArr
     * @throws \Khill\Lavacharts\Exceptions\InvalidConfigValue
     *
     * @return self
     */
    public function colors($cArr)
    {
        if (Utils::arrayValuesCheck($cArr, 'string') === false) {
            throw $this->invalidConfigValue(
                __FUNCTION__,
                'array',
                'with valid HTML colors'
            );
        }
<<<<<<< HEAD
=======
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
>>>>>>> 2.6

        return $this->addOption([__FUNCTION__ => $cArr]);
    }

    /**
     * Register javascript callbacks for specific events.
     *
     * Valid values include:
     * [ animationfinish | error | onmouseover | onmouseout | ready | select ]
     * associated to a respective pre-defined javascript function as the callback.
     *
     * @param  array              $e Array of events associated to a callback
     * @throws \Khill\Lavacharts\Exceptions\InvalidConfigValue
     *
     * @return self
     */
    public function events($e)
    {
<<<<<<< HEAD
=======
        $values = array(
            'animationfinish',
            'error',
            'onmouseover',
            'onmouseout',
            'ready',
            'select',
            'sort'
        );

>>>>>>> 2.6
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
     * The default font size, in pixels, of all text in the chart. You can
     * override this using properties for specific chart elements.
     *
     * @param  integer                $fontSize
     * @throws \Khill\Lavacharts\Exceptions\InvalidConfigValue
     *
     * @return self
     */
    public function fontSize($fontSize)
    {
        if (is_int($fontSize) === false) {
            throw $this->invalidConfigValue(
                __FUNCTION__,
                'int'
            );
        }

        return $this->addOption([__FUNCTION__ => $fontSize]);
    }

    /**
     * The default font face for all text in the chart. You can override this
     * using properties for specific chart elements.
     *
     * @param  string             $fontName
     * @throws \Khill\Lavacharts\Exceptions\InvalidConfigValue
     *
     * @return self
     */
    public function fontName($fontName)
    {
        if (Utils::nonEmptyString($fontName) === false) {
            throw $this->invalidConfigValue(
                __FUNCTION__,
                'string'
            );
        }

        return $this->addOption([__FUNCTION__ => $fontName]);
    }

    /**
     * Height of the chart, in pixels.
     *
     * @param  integer                $h
     * @throws \Khill\Lavacharts\Exceptions\InvalidConfigValue
     *
     * @return self
     */
    public function height($h)
    {
        if (is_int($h) === false) {
            throw $this->invalidConfigValue(
                __FUNCTION__,
                'int'
            );
        }

        return $this->addOption([__FUNCTION__ => $h]);
    }

    /**
     * An object with members to configure various aspects of the legend. To
     * specify properties of this object, create a new legend() object, set the
     * values then pass it to this function or to the constructor.
     *
     * @uses   Legend
     * @param  Legend             $legend
     * @throws \Khill\Lavacharts\Exceptions\InvalidConfigValue
     *
     * @return self
     */
    public function legend(Legend $legend)
    {
        return $this->addOption($legend->toArray());
    }

    /**
     * Outputs the chart javascript into the page
     *
     * Pass in a string of the html elementID that you want the chart to be
     * rendered into.
     *
     * @since  2.0.0
     * @param  string           $elemId The id of an HTML element to render the chart into.
     * @throws InvalidElementId
     *
     * @return string Javascript code blocks
     */
    public function render($elemId)
    {
        if ($elemId instanceof ElementId === false) {
            $elemId = new ElementId($elemId);
        }

        $jsf = new JavascriptFactory;

        return $jsf->getChartJs($this, $elemId);
    }

    /**
     * Text to display above the chart.
     *
     * @param  string             $title
     * @throws \Khill\Lavacharts\Exceptions\InvalidConfigValue
     *
     * @return self
     */
    public function title($title)
    {
        if (Utils::nonEmptyString($title) === false) {
            throw $this->invalidConfigValue(
                __FUNCTION__,
                'string'
            );
        }

        return $this->addOption([__FUNCTION__ => $title]);
    }

    /**
     * Where to place the chart title, compared to the chart area. Supported values:
     * 'in' - Draw the title inside the chart area.
     * 'out' - Draw the title outside the chart area.
     * 'none' - Omit the title.
     *
     * @param  string             $titlePosition
     * @throws \Khill\Lavacharts\Exceptions\InvalidConfigValue
     *
     * @return self
     */
    public function titlePosition($titlePosition)
    {
        $values = [
            'in',
            'out',
            'none'
        ];

        if (in_array($titlePosition, $values, true) === false) {
            throw $this->invalidConfigValue(
                __FUNCTION__,
                'string',
                'with a value of '.Utils::arrayToPipedString($values)
            );
        }

        return $this->addOption([__FUNCTION__ => $titlePosition]);
    }

    /**
     * An object that specifies the title text style. create a new textStyle()
     * object, set the values then pass it to this function or to the constructor.
     *
     * @uses   TextStyle
     * @param  TextStyle          $textStyle
     * @throws \Khill\Lavacharts\Exceptions\InvalidConfigValue
     *
     * @return self
     */
    public function titleTextStyle(TextStyle $textStyle)
    {
        return $this->addOption($textStyle->toArray(__FUNCTION__));
    }

    /**
     * An object with members to configure various tooltip elements. To specify
     * properties of this object, create a new tooltip() object, set the values
     * then pass it to this function or to the constructor.
     *
     * @uses   Tooltip
     * @param  Tooltip            $tooltip
     * @throws \Khill\Lavacharts\Exceptions\InvalidConfigValue
     *
     * @return self
     */
    public function tooltip(Tooltip $tooltip)
    {
        return $this->addOption($tooltip->toArray());
    }

    /**
     * Width of the chart, in pixels.
     *
     * @param  integer                $width
     * @throws \Khill\Lavacharts\Exceptions\InvalidConfigValue
     *
     * @return self
     */
    public function width($width)
    {
        if (is_int($width) === false) {
            throw $this->invalidConfigValue(
                __FUNCTION__,
                'int'
            );
        }

        return $this->addOption([__FUNCTION__ => $width]);
    }

    /**
     * function for easy creation of exceptions
     *
     * @return InvalidConfigValue
     */
    protected function invalidConfigValue($func, $type, $extra = '')
    {
        if (! empty($extra)) {
            return new InvalidConfigValue(
                static::TYPE . '::' . $func,
                $type,
                $extra
            );
        } else {
            return new InvalidConfigValue(
                static::TYPE . '::' . $func,
                $type
            );
        }
    }
}
