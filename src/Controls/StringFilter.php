<?php namespace Khill\Lavacharts\Controls;

/**
 * StringFilter Class
 *
 * A string filter that is rendered within dashboard. Filters bouned tables.
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

class StringFilter extends Control
{
    public $type = 'StringFilter';

    public function __construct($categoryLabel)
    {
        parent::__construct($categoryLabel);

        $this->defaults = array_merge(
            $this->defaults,
            array(
                'matchType',
                'caseSensitive',
                'useFormattedValue',
                'ui.realtimeTrigger',
                'ui.label',
                'ui.labelSeparator',
                'ui.labelStacking',
                'ui.cssClass',
            )
        );
    }

    /**
     * The method of filtering the string:
     *
     * exact - The pattern matches the string exactly.
     * prefix - The pattern is found at the beginning of the string.
     * any - The pattern is found anywhere in the string.
     *
     * @param  string             $position
     * @throws InvalidConfigValue
     * @return StringFilter
     */
    public function matchType($type)
    {
        $values = array(
            'exact',
            'prefix',
            'any'
        );

        if (is_string($type) && in_array($type, $values)) {
            $this->addOption(array(__FUNCTION__ => $type));
        } else {
            throw $this->invalidConfigValue(
                __FUNCTION__,
                'string',
                'with a value of '.Utils::arrayToPipedString($values)
            );
        }

        return $this;
    }
    
    /**
     * If set to true, the filter is case sensitive.
     *
     * @param  bool               $isStacked
     * @throws InvalidConfigValue
     * @return StringFilter
     */
    public function caseSensitive($caseSensitive)
    {
        if (is_bool($caseSensitive)) {
            $this->addOption(array(__FUNCTION__ => $caseSensitive));
        } else {
            throw $this->invalidConfigValue(
                __FUNCTION__,
                'bool'
            );
        }

        return $this;
    }
    
    /**
     * If set to true, the values are formatted.
     *
     * @param  bool               $isStacked
     * @throws InvalidConfigValue
     * @return StringFilter
     */
    public function useFormattedValue($formatedValue)
    {
        if (is_bool($formatedValue)) {
            $this->addOption(array(__FUNCTION__ => $formatedValue));
        } else {
            throw $this->invalidConfigValue(
                __FUNCTION__,
                'bool'
            );
        }

        return $this;
    }
}
