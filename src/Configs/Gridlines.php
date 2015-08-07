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
class Animation extends JsonConfig
{
    /**
     * Type of JsonConfig object
     *
     * @var string
     */
    const TYPE = 'Animation';

    /**
     * Default options for TextStyles
     *
     * @var array
     */
    private $defaults = [
        'duration',
        'easing',
        'startup'
    ];

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
        $options = new Options($this->defaults);

        parent::__construct($options, $config);
    }

    /**
     * The duration of the animation, in milliseconds.
     *
     * For details, see the animation documentation.
     *
     * @see    https://developers.google.com/chart/interactive/docs/animation
     * @param  integer $duration
     * @return self
     */
    public function duration($duration)
    {
        return $this->setIntOption(__FUNCTION__, $duration);
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
     * @param  string $easing
     * @return self
     */
    public function easing($easing)
    {
        $values = [
            'linear',
            'in',
            'out',
            'inAndOut'
        ];

        return $this->setStringInArrayOption(__FUNCTION__, $easing, $values);
    }

    /**
     * Determines if the chart will animate on the initial draw.
     *
     * If true, the chart will start at the baseline and animate to its final state.
     *
     * @param  bool $startup
     * @return self
     */
    public function startup($startup)
    {
        return $this->setBoolOption(__FUNCTION__, $startup);
    }
}