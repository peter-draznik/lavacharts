<?php namespace Khill\Lavacharts\Controls;

/**
 * CategoryFilter Class
 *
 * A category filter that is rendered within dashboard. Filters bounded tables.
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

class CategoryFilter extends Control
{
    public $type = 'CategoryFilter';

    public function __construct($categoryLabel)
    {
        parent::__construct($categoryLabel);

        $this->defaults = array_merge(
            $this->defaults,
            array(
                'values',
                'useFormattedValue',
            )
        );
    }
	
    /**
     * Lists the possible catgeory values.
     *
     * @param  array               $Values
     * @throws InvalidConfigValue
     * @return CategoryFilter
     */
    public function values($values)
    {
        if (is_array($values)) {
            $this->addOption(array(__FUNCTION__ => $values));
        } else {
            throw $this->invalidConfigValue(
                __FUNCTION__,
                'array'
            );
        }

        return $this;
    }
    
    /**
     * If set to true, the Values are formatted.
     *
     * @param  bool			$formattedValue
     * @throws InvalidConfigValue
     * @return CategoryFilter
     */
    public function useFormattedValue($formattedValue)
    {
        if (is_bool($formattedValue)) {
            $this->addOption(array(__FUNCTION__ => $formattedValue));
        } else {
            throw $this->invalidConfigValue(
                __FUNCTION__,
                'bool'
            );
        }

        return $this;
    }
}
