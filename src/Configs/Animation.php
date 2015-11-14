<?php

namespace Khill\Lavacharts\Configs;

use \Khill\Lavacharts\Utils;
use \Khill\Lavacharts\Exceptions\InvalidConfigValue;

/**
 * Animation ConfigObject
 *
 * An object containing all the values for the Animation which can
 * be passed into the chart's options.
 *
 *
 * @package    Lavacharts
 * @subpackage Configs
 * @since      2.2.0
 * @author     Kevin Hill <kevinkhill@gmail.com>
 * @copyright  (c) 2015, KHill Designs
 * @link       http://github.com/kevinkhill/lavacharts GitHub Repository Page
 * @link       http://lavacharts.com                   Official Docs Site
 * @license    http://opensource.org/licenses/MIT MIT
 */
class Animation extends ConfigObject
{
    /**
     * The duration of the animation, in milliseconds.
     *
     * @var int
     */
    public $duration;

    /**
     * The easing function applied to the animation.
     *
     * @var string
     */
    public $easing;

    /**
     * Determines if the chart will animate on the initial draw.
     *
     * @var bool
     */
    public $startup;

    /**
     * Builds the Animation object.
     *
     * @param  array $config Associative array containing key => value pairs for the various configuration options.
     * @throws \Khill\Lavacharts\Exceptions\InvalidConfigValue
     * @throws \Khill\Lavacharts\Exceptions\InvalidConfigProperty
     * @return self
     */
    public function __construct($config = [])
    {
        parent::__construct($this, $config);
    }

    /**
     * The duration of the animation, in milliseconds.
     *
     * For details, see the animation documentation.
     *
     * @see    https://developers.google.com/chart/interactive/docs/animation
     * @param  integer       $d
     * @return self
     */
    public function duration($d)
    {
        if (is_int($d)) {
            $this->duration = $d;
        } else {
            throw new InvalidConfigValue(
                __FUNCTION__,
                'int'
            );
        }

        return $this;
    }

    /**
     * The easing function applied to the animation.
     *
     * The following options are available:
     * 'linear' - Constant speed.
     * 'in' - Ease in - Start slow and speed up.
     * 'out' - Ease out - Start fast and slow down.
     * 'inAndOut' - Ease in and out - Start slow, speed up, then slow down.
     *
     * @param  string    $e
     * @return self
     */
    public function easing($e)
    {
        $values = [
            'linear',
            'in',
            'out',
            'inAndOut'
        ];

        if (in_array($e, $values, true)) {
            $this->easing = $e;
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
     * Determines if the chart will animate on the initial draw.
     *
     * If true, the chart will start at the baseline and animate to its final state.
     *
     * @param  bool       $s
     * @return self
     */
    public function startup($s)
    {
        if (is_bool($s)) {
            $this->startup = $s;
        } else {
            throw new InvalidConfigValue(
                __FUNCTION__,
                'bool'
            );
        }

        return $this;
    }
}
