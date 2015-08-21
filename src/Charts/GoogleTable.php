<?php namespace Khill\Lavacharts\Charts;

/**
 * GoogleChart Class
 *
 * A table chart is rendered within the browser.
 * Displays a data from either an array or datatable in an easily sortable form.
 * Can be searched by rendering as a wrapper and binding to a control within a
 * dashboard.
 *
 *
 * @package    Lavacharts
 * @subpackage Charts
 * @since      v2.6.0
 * @author     Peter Draznik <peter.draznik@38thStreetStudios.com>
 * @copyright  (c) 2015, 38th Street Studios
 * @link       http://github.com/kevinkhill/lavacharts GitHub Repository Page
 * @link       http://lavacharts.com                   Official Docs Site
 * @license    http://opensource.org/licenses/MIT MIT
 */

use Khill\Lavacharts\Utils;
use Khill\Lavacharts\Configs\CssClassNames;

class GoogleTable extends Chart
{
    public $type = 'GoogleTable';

    public function __construct($chartLabel)
    {
        parent::__construct($chartLabel);

        $this->defaults = array_merge(
            $this->defaults,
            array(
                'allowHtml',
                'alternatingRowStyle',
                'cssClassNames',
                'firstRowNumber',
                'frozenColumns',
                'page',
                'pageSize',
                'pagingButtons',
                'rtlTable',
                'scrollLeftStartPosition',
                'showRowNumber',
                'sortTable',
                'sortAscending',
                'sortColumn',
                'startPage',
            )
        );
    }
    
    
    /**
     * If set to true the GoogleChart will render html tags sotred as values.
     * 
     * @access public
     * @param bool $html
     * @return GoogleTable
     */
    public function allowHtml($html)
    {
        if (is_bool($html)) {
            $this->addOption(array(__FUNCTION__ => $html));
        } else {
            throw $this->invalidConfigValue(
                __FUNCTION__,
                'bool'
            );
        }

        return $this;
    }
    
    
    /**
     * If set to true the GoogleChart will alternate the role styles.
     * 
     * @access public
     * @param bool $astyle
     * @return GoogleTable
     */
    public function alternatingRowStyle($astyle)
    {
        if (is_bool($astyle)) {
            $this->addOption(array(__FUNCTION__ => $astyle));
        } else {
            throw $this->invalidConfigValue(
                __FUNCTION__,
                'bool'
            );
        }

        return $this;
    }
    
    
    /**
     * An object in which each property name describes a table element, and the property value is a string, 
     * defining a class to assign to that table element. Use this property to assign custom CSS to specific 
     * elements of your table. To use this property, assign an object, where the property name specifies the 
     * table element, and the property value is a string, specifying a class name to assign to that element. 
     * You must then define a CSS style for that class on your page. The following property names are supported:
	 * 		headerRow - Assigns a class name to the table header row (<tr> element).
	 *		tableRow - Assigns a class name to the non-header rows (<tr> elements).
	 *		oddTableRow - Assigns a class name to odd table rows (<tr> elements). Note: the alternatingRowStyle option must be set to true.
	 *		selectedTableRow - Assigns a class name to the selected table row (<tr> element).
	 *		hoverTableRow - Assigns a class name to the hovered table row (<tr> element).
	 *		headerCell - Assigns a class name to all cells in the header row (<td> element).
	 *		tableCell - Assigns a class name to all non-header table cells (<td> element).
	 *		rowNumberCell - Assigns a class name to the cells in the row number column (<td> element). 
	 *  Note: the showRowNumber option must be set to true.
	 *
	 *	Example: var cssClassNames = {headerRow: 'bigAndBoldClass', hoverTableRow: 'highlightClass'};
     * 
     * @access public
     * @param (array) $astyle
     * @return GoogleTable
     */
    
    public function cssClassNames(CssClassNames $cssClassNames)
    {
        return $this->addOption($cssClassNames->toArray(__FUNCTION__));
    }
    
    
    /**
     * The row number for the first row in the dataTable. Used only if showRowNumber is true.
     * 
     * @access public
     * @param int $firstRowNumber
     * @return GoogleTable
     */
    public function firstRowNumber($firstRowNumber)
    {
        if (is_int($firstRowNumber)) {
            $this->addOption(array(__FUNCTION__ => $firstRowNumber));
        } else {
            throw $this->invalidConfigValue(
                __FUNCTION__,
                'int'
            );
        }

        return $this;
    }
    
    
    /**
     * The number of columns from the left that will be frozen. These columns will remain in place when scrolling
     * the remaining columns horizontally. If showRowNumber is false, setting frozenColumns to 0 will appear the
     * same as if set to null, but if showRowNumber is set to true, the row number column will be frozen.
     * 
     * @access public
     * @param int $frozenColumns
     * @return GoogleTable
     */
    public function frozenColumns($frozenColumns)
    {
        if (is_int($frozenColumns)) {
            $this->addOption(array(__FUNCTION__ => $frozenColumns));
        } else {
            throw $this->invalidConfigValue(
                __FUNCTION__,
                'int'
            );
        }

        return $this;
    }
    
    
    /**
     * If and how to enable paging through the data. Choose one of the following string values:
	 *	'enable' - The table will include page-forward and page-back buttons. Clicking on these buttons will
	 *		 perform the paging operation and change the displayed page. You might want to also set the pageSize option.
	 *	'event' - The table will include page-forward and page-back buttons, but clicking them will trigger a 'page'
	 *		 event and will not change the displayed page. This option should be used when the code implements its own 
	 *		 page turning logic. See the TableQueryWrapper example for an example of how to handle paging events manually.
	 *	'disable' - [Default] Paging is not supported.
     * 
     * @access public
     * @param string $page
     * @return GoogleTable
     */
    public function page($page)
    {
        $values = array(
            'enable',
            'event',
            'disable',
        );

        if (Utils::nonEmptyStringInArray($page, $values)||is_int($page)) {
            $this->addOption(array(__FUNCTION__ => $page));
        } else {
            throw $this->invalidConfigValue(
                __FUNCTION__,
                'string',
                'must be one of '.Utils::arrayToPipedString($values)
            );
        }

        return $this;
    }
    
    
    /**
     * The number of rows in each page, when paging is enabled with the page option.
     * 
     * @access public
     * @param mixed $pageSize
     * @return void
     */
    public function pageSize($pageSize)
    {
        if (is_int($pageSize)) {
            $this->addOption(array(__FUNCTION__ => $pageSize));
        } else {
            throw $this->invalidConfigValue(
                __FUNCTION__,
                'int'
            );
        }

        return $this;
    }
    
    
    /**
     * Sets a specified option for the paging buttons. The options are as follows:
	 *	'both' - enable prev and next buttons
	 *	'prev' - only prev button is enabled
	 *	'next' - only next button is enabled
	 *	'auto' - the buttons are enabled according to the current page. On the first page only next 
	 *  			is shown. On the last page only prev is shown. Otherwise both are enabled.
	 *	number - the number of paging buttons to show. This explicit number will override computed number from pageSize.
     * 
     * @access public
     * @param mixed (string|int) $paging
     * @return GoogleTable
     */
    public function pagingButtons($paging)
    {
        $values = array(
            'both',
            'prev',
            'next',
            'auto',
        );

        if (Utils::nonEmptyStringInArray($paging, $values)||is_int($paging)) {
            $this->addOption(array(__FUNCTION__ => $paging));
        } else {
            throw $this->invalidConfigValue(
                __FUNCTION__,
                'string | int',
                'must be int or one of '.Utils::arrayToPipedString($values)
            );
        }

        return $this;
    }
    
    
    /**
     * Adds basic support for right-to-left languages (such as Arabic or Hebrew) by reversing the column 
     * order of the table, so that column zero is the rightmost column, and the last column is the leftmost 
     * column. This does not affect the column index in the underlying data, only the order of display. Full 
     * bi-directional (BiDi) language display is not supported by the table visualization even with this 
     * option. This option will be ignored if you enable paging (using the page option), or if the table has 
     * scroll bars because you have specified height and width options smaller than the required table size.
     * 
     * @access public
     * @param bool $rtl
     * @return GoogleTable
     */
    public function rtlTable($rtl)
    {
        if (is_bool($rtl)) {
            $this->addOption(array(__FUNCTION__ => $rtl));
        } else {
            throw $this->invalidConfigValue(
                __FUNCTION__,
                'bool'
            );
        }

        return $this;
    }
    
    
    /**
     * Sets the horizontal scrolling position, in pixels, if the table has horizontal scroll bars because you 
     * have set the width property. The table will open scrolled that many pixels past the leftmost column.
     * 
     * @access public
     * @param int $startPosition
     * @return GoogleTable
     */
    public function scrollLeftStartPosition($startPosition)
    {
        if (is_int($startPosition)) {
            $this->addOption(array(__FUNCTION__ => $startPosition));
        } else {
            throw $this->invalidConfigValue(
                __FUNCTION__,
                'int'
            );
        }

        return $this;
    }
    
    
    /**
     * If set to true, shows the row number as the first column of the table.
     * 
     * @access public
     * @param bool $rowNumber
     * @return GoogleTable
     */
    public function showRowNumber($rowNumber)
    {
        if (is_bool($rowNumber)) {
            $this->addOption(array(__FUNCTION__ => $rowNumber));
        } else {
            throw $this->invalidConfigValue(
                __FUNCTION__,
                'bool'
            );
        }

        return $this;
    }
    
    
	/**
	 * If and how to sort columns when the user clicks a column heading. If sorting is enabled, consider setting 
	 * the sortAscending and sortColumn properties as well. Choose one of the following string values:
	 *		'enable' - [Default] Users can click on column headers to sort by the clicked column. When users click 
	 *					on the column header, the rows will be automatically sorted, and a 'sort' event will be triggered.
	 *		'event' - When users click on the column header, a 'sort' event will be triggered, but the rows will not be 
	 *  				automatically sorted. This option should be used when the page implements its own sort. See the 
	 *					TableQueryWrapper example for an example of how to handle sorting events manually.
	 *		'disable' - Clicking a column header has no effect.
	 * 
	 * @access public
	 * @param string $sort
	 * @return GoogleTable
	 */
	public function sortTable($sort)
    {
        $values = array(
            'enable',
            'event',
            'disable',
        );

        if (Utils::nonEmptyStringInArray($sort, $values)) {
            $this->addOption(array('sort' => $sort));
        } else {
            throw $this->invalidConfigValue(
                __FUNCTION__,
                'string',
                'must be int or one of '.Utils::arrayToPipedString($values)
            );
        }

        return $this;
    }
    
    
	/**
	 * The order in which the initial sort column is sorted. True for ascending, false for 
	 * descending. Ignored if sortColumn is not specified.
	 * 
	 * @access public
	 * @param bool $sort
	 * @return GoogleTable
	 */
	public function sortAscending($sort)
    {
        if (is_bool($sort)) {
            $this->addOption(array(__FUNCTION__ => $sort));
        } else {
            throw $this->invalidConfigValue(
                __FUNCTION__,
                'bool'
            );
        }

        return $this;
    }
    
    
    /**
     * An index of a column in the data table, by which the table is initially sorted. 
     * The column will be marked with a small arrow indicating the sort order.
     * 
     * @access public
     * @param int $sort
     * @return GoogleTable
     */
    public function sortColumn($sort)
    {
        if (is_int($sort)) {
            $this->addOption(array(__FUNCTION__ => $sort));
        } else {
            throw $this->invalidConfigValue(
                __FUNCTION__,
                'int'
            );
        }

        return $this;
    }
    
    
    /**
     * The first table page to display. Used only if page is in mode enable/event.
     * 
     * @access public
     * @param int $start
     * @return GoogleTable
     */
    public function startPage($start)
    {
        if (is_int($start)) {
            $this->addOption(array(__FUNCTION__ => $start));
        } else {
            throw $this->invalidConfigValue(
                __FUNCTION__,
                'int'
            );
        }

        return $this;
    }
    
    
    
}