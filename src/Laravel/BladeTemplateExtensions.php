<?php

namespace Khill\Lavacharts\Laravel;

use Illuminate\Support\Facades\App;

$app   = App::getFacadeApplication();
$blade = $app['view']->getEngineResolver()->resolve('blade')->getCompiler();

$charts = [
    'AreaChart',
    'BarChart',
    'CalendarChart',
    'ColumnChart',
    'ComboChart',
    'DonutChart',
    'GaugeChart',
    'GeoChart',
    'LineChart',
    'PieChart',
    'GoogleTable',
];

$dashboards = [
	'Dashboard',	
];

$controls = [
	'Control',
	'CategoryFilter',
	'ChartRangeFilter',
	'DateRangeFilter',
	'NumberRangeFilter',
	'StringFilter'	
];

/**
 * If the directive method exists, we're using Laravel 5
 */
if (method_exists($blade, 'directive')) {
    foreach ($charts as $chart) {
        $blade->directive(strtolower($chart), function($expression) use ($chart) {
            return '<?php echo Lava::renderChart'. $chart . $expression . '; ?>';
        });
    }
    
    foreach ($charts as $chart) {
        $blade->directive(strtolower($chart).'Wrapper', function($expression) use ($chart) {
            return '<?php echo Lava::renderChartWrapper'. $chart . $expression . '; ?>';
        });
    }
    
    foreach ($controls as $control) {
        $blade->directive(strtolower($control), function($expression) use ($control) {
            return '<?php echo Lava::renderControl'. $control . $expression . '; ?>';
        });
    }
    
    foreach ($dashboards as $dashboard) {
	    $blade->directive(strtolower($dashboard), function($expression) use ($dashboard) {
            return '<?php echo Lava::renderDashboard'. $dashboard . $expression . '; ?>';
        });
    }
    
} else {
    foreach ($charts as $chart) {
        $blade->extend(function ($view, $compiler) use ($chart) {
            $pattern = $compiler->createMatcher(strtolower($chart));
            $output  = '$1<?php echo Lava::renderChart'.$chart.'$2; ?>';
            return preg_replace($pattern, $output, $view);
        });
    }
    
    foreach ($controls as $control) {
        $blade->extend(function ($view, $compiler) use ($control) {
            $pattern = $compiler->createMatcher(strtolower($control));
            $output  = '$1<?php echo Lava::renderControl'.$control.'$2; ?>';
            return preg_replace($pattern, $output, $view);
        });
    }
    
    foreach ($dashboards as $dashboard) {
        $blade->extend(function ($view, $compiler) use ($dashboard) {
            $pattern = $compiler->createMatcher(strtolower($dashboard));
            $output  = '$1<?php echo Lava::renderDashboard'.$dashboard.'$2; ?>';
            return preg_replace($pattern, $output, $view);
        });
    }
}
