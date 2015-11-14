<?php namespace Khill\Lavacharts\Configs;

/**
 * CssClassNames Properties Object
 *
 * An object containing all the values for the cssClassNames which can be
 * passed into the control's options.
 *
 *
 * @package    Lavacharts
 * @subpackage Configs
 * @author     Peter Draznik <peter.draznik@38thStreetStudios.com>
 * @since	   v.2.6.0
 * @copyright  (c) 2015, 38th Street Studios
 * @link       http://github.com/kevinkhill/lavacharts GitHub Repository Page
 * @link       http://lavacharts.com                   Official Docs Site
 * @license    http://opensource.org/licenses/MIT MIT
 */

use Khill\Lavacharts\Utils;
use Khill\Lavacharts\Exceptions\InvalidConfigValue;

class CssClassNames extends ConfigObject
{
    public headerRow; 
	public tableRow; 
	public oddTableRow; 
	public selectedTableRow; 
	public hoverTableRow; 
	public headerCell; 
	public tableCell; 
	public rowNumberCell;


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
     * Assigns a class name to the table header row (<tr> element).
     * 
     * @access public
     * @param string $headerRow
     * @return CssClassNames
     */
    public function headerRow($headerRow)
	{
	     if (is_string($headerRow)) {
            $this->headerRow = $headerRow;
        } else {
            throw new InvalidConfigValue(
                __FUNCTION__,
                'string'
            );
        }

        return $this;
	}
	
	
	/**
	 * Assigns a class name to the non-header rows (<tr> elements).
	 * 
	 * @access public
	 * @param string $tableRow
	 * @return CssClassNames
	 */
	public function tableRow($tableRow)
	{
	     if (is_string($tableRow)) {
            $this->tableRow = $tableRow;
        } else {
            throw new InvalidConfigValue(
                __FUNCTION__,
                'string'
            );
        }

        return $this;
	}
	
	
	/**
	 * Assigns a class name to odd table rows (<tr> elements). Note: the alternatingRowStyle option must be set to true.
	 * 
	 * @access public
	 * @param string $oddTableRow
	 * @return CssClassNames
	 */
	public function oddTableRow($oddTableRow)
	{
	     if (is_string($oddTableRow)) {
            $this->oddTableRow = $oddTableRow;
        } else {
            throw new InvalidConfigValue(
                __FUNCTION__,
                'string'
            );
        }

        return $this;
	}
	
	
	/**
	 * Assigns a class name to the selected table row (<tr> element).
	 * 
	 * @access public
	 * @param string $selectedTableRow
	 * @return CssClassNames
	 */
	public function selectedTableRow($selectedTableRow)
	{
	     if (is_string($selectedTableRow)) {
            $this->selectedTableRow = $selectedTableRow;
        } else {
            throw new InvalidConfigValue(
                __FUNCTION__,
                'string'
            );
        }

        return $this;
	} 
	
	
	/**
	 * Assigns a class name to the hovered table row (<tr> element).
	 * 
	 * @access public
	 * @param string $hoverTableRow
	 * @return CssClassNames
	 */
	public function hoverTableRow($hoverTableRow)
	{
	     if (is_string($hoverTableRow)) {
            $this->hoverTableRow = $hoverTableRow;
        } else {
            throw new InvalidConfigValue(
                __FUNCTION__,
                'string'
            );
        }

        return $this;
	}
	
	
	/**
	 * Assigns a class name to all cells in the header row (<td> element).
	 * 
	 * @access public
	 * @param string $headerCell
	 * @return CssClassNames
	 */
	public function headerCell($headerCell)
	{
	     if (is_string($headerCell)) {
            $this->headerCell = $headerCell;
        } else {
            throw new InvalidConfigValue(
                __FUNCTION__,
                'string'
            );
        }

        return $this;
	}
	
	
	/**
	 * Assigns a class name to all non-header table cells (<td> element).
	 * 
	 * @access public
	 * @param string $tableCell
	 * @return CssClassNames
	 */
	public function tableCell($tableCell)
	{
	     if (is_string($tableCell)) {
            $this->tableCell = $tableCell;
        } else {
            throw new InvalidConfigValue(
                __FUNCTION__,
                'string'
            );
        }

        return $this;
	}
	
	
	/**
	 * Assigns a class name to the cells in the row number column (<td> element).
	 * 
	 * @access public
	 * @param string $rowNumberCell
	 * @return CssClassNames
	 */
	public function rowNumberCell($rowNumberCell)
	{
	     if (is_string($rowNumberCell)) {
            $this->rowNumberCell = $rowNumberCell;
        } else {
            throw new InvalidConfigValue(
                __FUNCTION__,
                'string'
            );
        }

        return $this;
	}
}
