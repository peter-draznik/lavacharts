<?php namespace Khill\Lavacharts\Configs;

/**
 * Ui Properties Object
 *
 * An object containing all the values for the ui which can be
 * passed into the control's options.
 *
 *
 * @package    Lavacharts
 * @subpackage Configs
 * @author     Peter Draznik <peter.draznik@38thStreetStudios.com>
 * @since	   v.3.0.0
 * @copyright  (c) 2015, 38th Street Studios
 * @link       http://github.com/kevinkhill/lavacharts GitHub Repository Page
 * @link       http://lavacharts.com                   Official Docs Site
 * @license    http://opensource.org/licenses/MIT MIT
 */

use Khill\Lavacharts\Utils;
use Khill\Lavacharts\Exceptions\InvalidConfigValue;

class Ui extends ConfigObject
{
    /**
     * Position of the legend.
     *
     * @var string
     */
    public $caption;

    /**
     * Alignment of the legend.
     *
     * @var string
     */
    public $sortValues;

    /**
     * Text style of the legend.
     *
     * @var TextStyle
     */
    public $selectedValuesLayout;
    
    /**
     * Position of the legend.
     *
     * @var string
     */
    public $chartType;

    /**
     * Alignment of the legend.
     *
     * @var string
     */
    public $chartOptions;

    /**
     * Text style of the legend.
     *
     * @var TextStyle
     */
    public $chartView;
    
    /**
     * Position of the legend.
     *
     * @var string
     */
    public $allowNone;

    /**
     * Alignment of the legend.
     *
     * @var string
     */
    public $allowMultiple;

    /**
     * Text style of the legend.
     *
     * @var TextStyle
     */
    public $allowTyping;
    
    /**
     * Position of the legend.
     *
     * @var string
     */
    public $label;

    /**
     * Alignment of the legend.
     *
     * @var string
     */
    public $labelSeparator;

    /**
     * Text style of the legend.
     *
     * @var TextStyle
     */
    public $labelStacking;
    
    /**
     * Text style of the legend.
     *
     * @var TextStyle
     */
    public $cssClass;
    
     /**
     * Position of the legend.
     *
     * @var string
     */
    public $minRangeSize;

    /**
     * Alignment of the legend.
     *
     * @var string
     */
    public $snapToData;

    /**
     * Text style of the legend.
     *
     * @var TextStyle
     */
    public $format;
    
    /**
     * Text style of the legend.
     *
     * @var TextStyle
     */
    public $step;
    
    /**
     * Position of the legend.
     *
     * @var string
     */
    public $ticks;

    /**
     * Alignment of the legend.
     *
     * @var string
     */
    public $unitIncrement;

    /**
     * Text style of the legend.
     *
     * @var TextStyle
     */
    public $blockIncrement;
    
    /**
     * Text style of the legend.
     *
     * @var TextStyle
     */
    public $showRangeValues;
    
     /**
     * Position of the legend.
     *
     * @var string
     */
    public $orientation;


    /**
     * Builds the legend object when passed an array of configuration options.
     *
     * @param  array                 $config Options for the legend
     * @throws InvalidConfigValue
     * @throws InvalidConfigProperty
     * @return Legend
     */
    public function __construct($config = array())
    {
        parent::__construct($this, $config);
    }
	
	
    /**
     * The caption to display inside the value picker widget when no item is selected.
     * 
     * @access public
     * @param string $caption
     * @return Ui
     */
    public function caption($caption)
	{
	     if (is_string(caption)) {
            $this->caption = $caption;
        } else {
            throw new InvalidConfigValue(
                __FUNCTION__,
                'string'
            );
        }

        return $this;
	}
	
	
	/**
	 * Whether the values to choose from should be sorted.
	 * 
	 * @access public
	 * @param bool $sortValues
	 * @return Ui
	 */
	public function sortValues($sortValues)
	{
	     if (is_bool($sortValues)) {
            $this->sortValues = $sortValues;
        } else {
            throw new InvalidConfigValue(
                __FUNCTION__,
                'bool'
            );
        }

        return $this;
	}
	
	
	/**
	 * How to display selected values, when multiple selection is allowed. Possible values are:
	 *		'aside': selected values will display in a single text line next to the value picker widget,
	 *		'below': selected values will display in a single text line below the widget,
	 *		'belowWrapping': similar to below, but entries that cannot fit in the picker will wrap to a new line,
	 *		'belowStacked': selected values will be displayed in a column below the widget.
	 * 
	 * @access public
	 * @param string $selectedValuesLayout
	 * @return Ui
	 */
	public function selectedValuesLayout($selectedValuesLayout)
	{
	     $values = array(
            'aside',
            'below',
            'belowWrapping',
            'belowStacked'
        );

        if (is_string($selectedValuesLayout) && in_array($selectedValuesLayout, $values)) {
            $this->selectedValuesLayout = $selectedValuesLayout;
        } else {
            throw new InvalidConfigValue(
                __FUNCTION__,
                'string',
                'with a value of '.Utils::arrayToPipedString($values)
            );
        }

        return $this;
	}
	
	
	/**
	 * The type of the chart drawn inside the control. Can be one of: 
	 * 		'AreaChart', 
	 *		'LineChart', 
	 *		'ComboChart',
	 *		'ScatterChart'
	 * 
	 * @access public
	 * @param string $chartType
	 * @return Ui
	 */
	public function chartType($chartType)
	{
	     $values = array(
            'AreaChart',
            'LineChart',
            'ComboChart',
            'ScatterChart',
        );

        if (is_string($chartType) && in_array($chartType, $values)) {
            $this->chartType = $chartType;
        } else {
            throw new InvalidConfigValue(
                __FUNCTION__,
                'string',
                'with a value of '.Utils::arrayToPipedString($values)
            );
        }

        return $this;
	}
	
	
	/**
	 * The configuration options of the chart drawn inside the control. Allows the same level of configuration as 
	 * any chart in the dashboard, and complies with the same format as accepted by ChartWrapper.setOptions().
	 *
	 * You can specify additional options or override the default ones (note that the defaults have been 
	 * carefully chosen for optimal appearance, though).
	 * 
	 * @access public
	 * @param mixed $chartOptions
	 * @return Ui
	 */
	public function chartOptions($chartOptions)
	{
	     return $this;
	}
	
	
	/**
	 * Specification of the view to apply to the data table used to draw the chart inside the control. 
	 * Allows the same level of configuration as any chart in the dashboard, and complies with the same 
	 * format as accepted by ChartWrapper.setView(). If not specified, the data table itself is used to 
	 * draw the chart.
	 *
	 * Please note that the horizontal axis of the drawn chart must be continuous, so be careful to 
	 * specify ui.chartView accordingly.
	 * 
	 * @access public
	 * @param mixed $chartView
	 * @return Ui
	 */
	public function chartView($chartView)
	{
	     return $this;
	}
	
	
	/**
	 * Whether the user is allowed not to choose any value. If false the user must choose at 
	 * least one value from the available ones. During control initialization, if the option 
	 * is set to false and no selectedValues state is given, the first value from the avaiable 
	 * ones is automatically seleted.
	 * 
	 * @access public
	 * @param bool $allowNone
	 * @return Ui
	 */
	public function allowNone($allowNone)
	{
	     if (is_bool($allowNone)) {
            $this->allowNone = $$allowNone;
        } else {
            throw new InvalidConfigValue(
                __FUNCTION__,
                'bool'
            );
        }

        return $this;
	}
	
	
	/**
	 * Whether multiple values can be selected, rather than just one.
	 * 
	 * @access public
	 * @param bool $allowMultiple
	 * @return Ui
	 */
	public function allowMultiple($allowMultiple)
	{
	     if (is_bool($allowMultiple)) {
            $this->allowMultiple = $allowMultiple;
        } else {
            throw new InvalidConfigValue(
                __FUNCTION__,
                'bool'
            );
        }

        return $this;
	}
	
	
	/**
	 * Whether the user is allowed to type in a text field to narrow down the list of possible choices 
	 * (via an autocompleter), or not.
	 * 
	 * @access public
	 * @param bool $allowTyping
	 * @return Ui
	 */
	public function allowTyping($allowTyping)
	{
	     if (is_bool($$allowTyping)) {
            $this->allowTyping = $allowTyping;
        } else {
            throw new InvalidConfigValue(
                __FUNCTION__,
                'bool'
            );
        }

        return $this;
	}
	
	
	/**
	 * The label to display next to the category picker. If unspecified, the label of the column the 
	 * control operates on will be used.
	 * 
	 * @access public
	 * @param string $label
	 * @return Ui
	 */
	public function label($label)
	{
	     if (is_string($label)) {
            $this->label = $label;
        } else {
            throw new InvalidConfigValue(
                __FUNCTION__,
                'string'
            );
        }

        return $this;
	}
	
	
	/**
	 * A separator string appended to the label, to visually separate the label from the category picker.
	 * 
	 * @access public
	 * @param string $labelSeparator
	 * @return Ui
	 */
	public function labelSeparator($labelSeparator)
	{
	     if (is_string($labelSeparator)) {
            $this->labelSeparator = $labelSeparator;
        } else {
            throw new InvalidConfigValue(
                __FUNCTION__,
                'string'
            );
        }

        return $this;
	}
	
	
	/**
	 * Whether the label should display above (vertical stacking) or beside (horizontal stacking) the 
	 * category picker. Use either 'vertical' or 'horizontal'.
	 * 
	 * @access public
	 * @param string $labelStacking
	 * @return Ui
	 */
	public function labelStacking($labelStacking)
	{
	     $values = array(
            'horizontal',
            'vertical',
        );

        if (is_string($labelStacking) && in_array($labelStacking, $values)) {
            $this->labelStacking = $labelStacking;
        } else {
            throw new InvalidConfigValue(
                __FUNCTION__,
                'string',
                'with a value of '.Utils::arrayToPipedString($values)
            );
        }

        return $this;
	}
	
	
	/**
	 * The CSS class to assign to the control, for custom styling.
	 * 
	 * @access public
	 * @param string $cssClass
	 * @return Ui
	 */
	public function cssClass($cssClass)
	{
	     if (is_string($cssClass)) {
            $this->cssClass = $cssClass;
        } else {
            throw new InvalidConfigValue(
                __FUNCTION__,
                'string'
            );
        }

        return $this;
	}
	
	 
	/**
	 * The minimum selectable range size (range.end - range.start), specified in data value units. 
	 * For a numeric axis, it is a number (not necessarily an integer). For a date, datetime or 
	 * timeofday axis, it is an integer that specifies the difference in milliseconds.
	 * 
	 * @access public
	 * @param string|float $minRangeSize
	 * @return Ui
	 */
	public function minRangeSize($minRangeSize)
	{
	     if (is_string($minRangeSize)||is_float($minRangeSize)) {
            $this->minRangeSize = $minRangeSize;
        } else {
            throw new InvalidConfigValue(
                __FUNCTION__,
                'string'
            );
        }

        return $this;
	}
	
	
	/**
	 * If true, range thumbs are snapped to the nearest data points. In this case, the end points 
	 * of the range returned by getState() are necessarily values in the data table.
	 * 
	 * @access public
	 * @param bool $snapToData
	 * @return Ui
	 */
	public function snapToData($snapToData)
	{
	     if (is_bool($snapToData)) {
            $this->snapToData = $snapToData;
        } else {
            throw new InvalidConfigValue(
                __FUNCTION__,
                'bool'
            );
        }

        return $this;
	}
	
	
	/**
	 * How to represent the date as a string. 
	 * Accepts any valid date format.
	 * 
	 * @access public
	 * @param string $format
	 * @return Ui
	 */
	public function format($format)
	{
	    if (is_string($format)) {
            $this->format = $format;
        } else {
            throw new InvalidConfigValue(
                __FUNCTION__,
                'string'
            );
        }

        return $this;
	}
	
	
	/**
	 * The minimum possible change when dragging the slider thumbs: can be any time 
	 * unit up to "day". ("month" and "year" aren't yet supported.)
	 * 
	 * @access public
	 * @param string|float $step
	 * @return Ui
	 */
	public function step($step)
	{
	     if (is_string($step)||is_float($step)) {
            $this->step = $step;
        } else {
            throw new InvalidConfigValue(
                __FUNCTION__,
                'string'
            );
        }

        return $this;
	}
	
	
	/**
	 * The number of ticks (fixed positions in the range bar) the slider thumbs can occupy.
	 * 
	 * @access public
	 * @param int $ticks
	 * @return Ui
	 */
	public function ticks($ticks)
	{
	     if (is_int($ticks)) {
            $this->ticks = $ticks;
        } else {
            throw new InvalidConfigValue(
                __FUNCTION__,
                'int'
            );
        }

        return $this;
	}
	
	
	/**
	 * The amount to increment for unit increments of the range extents. A unit increment is 
	 * equivalent to using the arrow keys to move a slider thumb.
	 *
	 * @access public
	 * @param string $unitIncrement
	 * @return Ui
	 */
	public function unitIncrement($unitIncrement)
	{
	    if (is_string($unitIncrement)||is_float($unitIncrement)) {
            $this->unitIncrement = $unitIncrement;
        } else {
            throw new InvalidConfigValue(
                __FUNCTION__,
                'string'
            );
        }

        return $this;
	}
	
	
	/**
	 * The amount to increment for block increments of the range extents. A block increment is 
	 * equivalent to using the pgUp and pgDown keys to move the slider thumbs.
	 * 
	 * @access public
	 * @param string|float $blockIncrement
	 * @return Ui
	 */
	public function blockIncrement($blockIncrement)
	{
	     if (is_string($blockIncrement)||is_float($blockIncrement)) {
            $this->blockIncrement = $blockIncrement;
        } else {
            throw new InvalidConfigValue(
                __FUNCTION__,
                'string'
            );
        }

        return $this;
	}
	
	
	/**
	 * Whether to have labels next to the slider displaying extents of the selected range.
	 * 
	 * @access public
	 * @param bool $showRangeValues
	 * @return Ui
	 */
	public function showRangeValues($showRangeValues)
	{
	     if (is_bool($showRangeValues)) {
            $this->showRangeValues = $$showRangeValues;
        } else {
            throw new InvalidConfigValue(
                __FUNCTION__,
                'bool'
            );
        }

        return $this;
	}
	
	 
	/**
	 * The slider orientation. Either 'horizontal' or 'vertical'.
	 * 
	 * @access public
	 * @param string $orientation
	 * @return Ui
	 */
	public function orientation($orientation)
	{
	     $values = array(
            'horizontal',
            'vertical',
        );

        if (is_string($orientation) && in_array($orientation, $values)) {
            $this->orientation = $orientation;
        } else {
            throw new InvalidConfigValue(
                __FUNCTION__,
                'string',
                'with a value of '.Utils::arrayToPipedString($values)
            );
        }

        return $this;
	}
}
