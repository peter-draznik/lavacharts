<<<<<<< HEAD
/**
 * lava.js
 *
 * Author: Kevin Hill
 * Email: kevinkhill@gmail.com
 * License: MIT
 */
var lava = lava || {};
=======
window.lava = (function() {
  this.get              = null;
  this.event            = null;
  this.loadData         = null;
  this.register         = null;
  this.getLavachart     = null;
  this.charts           = {};
  this.controls         = {};
  this.dashboards       = {};
  this.registeredCharts = [];
  this.registeredControls = [];
  this.registeredDashboards = [];

  this.Chart = function() {
    this.init    		= null;
    this.redraw  		= null;
    this.setData 		= null;
    this.data    		= null;
    this.chart   		= null;
    this.options 		= null;
    this.formats 		= [];
  };
  
  this.Control 		= function() {
    this.init    		= null;
    this.redraw  		= null;
    this.setData 		= null;
    this.data    		= null;
    this.control 		= null;
    this.options 		= null;
    this.formats 		= [];
    //this.charts  		= [];
  };
  
  this.Dashboard 		= function() {
    this.init    		= null;
    this.redraw  		= null;
    this.setData 		= null;
    this.data    		= null;
    this.dashboard  	= null;
    this.options 		= null;
    this.formats 		= [];
    //this.controls 		= [];
  };

  this.get = function (chartLabel, callback) {
    if (arguments.length < 2 || typeof chartLabel !== 'string' || typeof callback !== 'function') {
      throw new Error('[Lavacharts] The syntax for lava.get must be (str ChartLabel, fn Callback)');
    }
>>>>>>> 2.6

(function() {
  "use strict";

  this.charts            = [];
  this.dashboards        = [];
  this.registeredCharts  = [];

  this.readyCallback = function(){};

  //var registeredActions = [];

  /**
   * LavaChart object.
   *
   * @constructor
   */
  this.Chart = function() {
    this.render  = function(){};
    this.setData = function(){};
    this.redraw  = function(){};
    this.data    = null;
    this.chart   = null;
    this.options = null;
    this.formats = [];
  };
  
    this.getControl = function (controlLabel, callback) {
    if (arguments.length < 2 || typeof controlLabel !== 'string' || typeof callback !== 'function') {
      throw new Error('[Lavacharts] The syntax for lava.getControl must be (str ControlLabel, fn Callback)');
    }

    lava.getLavacontrol(controlLabel, function (lavachart) {
      return callback(lavachart.control);
    });
  };
  
    this.getDashboard = function (dashboardLabel, callback) {
    if (arguments.length < 2 || typeof dashboardLabel !== 'string' || typeof callback !== 'function') {
      throw new Error('[Lavacharts] The syntax for lava.getDashboard must be (str DashboardLabel, fn Callback)');
    }

    lava.getLavadashboard(dashboardLabel, function (lavachart) {
      return callback(lavachart.dashboard);
    });
  };

<<<<<<< HEAD
  /**
   * Dashboard object.
   *
   * @constructor
   */
  this.Dashboard = function() {
    this.render    = null;
    this.data      = null;
    this.bindings  = [];
    this.dashboard = null;
    this.callbacks = [];
=======
  this.loadData = function (chartLabel, dataTableJson, callback) {
    lava.getLavachart(chartLabel, function (lavachart) {
      lavachart.setData(dataTableJson);
      lavachart.redraw();

      if (typeof callback == "function") {
        return callback(lavachart.chart);
      } else {
        return true;
      }
    });
  };
  
  
  this.loadDashboardData = function (dashboardLabel, dataTableJson, callback) {
    lava.getLavadashboard(dashboardLabel, function (lavadashboard) {
      lavadashboard.setData(dataTableJson);
      lavadashboard.redraw();

      if (typeof callback == "function") {
        return callback(lavadashboard.dashboard);
      } else {
        return true;
      }
    });
>>>>>>> 2.6
  };

  this.Callback = function (label, func) {
    this.label = label;
    this.func  = func;
  };

  this.ready = function (callback) {
    if (typeof callback !== 'function') {
      throw new Error('[Lavacharts] ' + typeof callback + ' is not a valid callback.');
    }

    lava.readyCallback = callback;
  };

/*
  action: function (label) {
    lava.registeredActions[label] =
  },
*/

  /**
   * Event wrapper for chart events.
   *
   *
   * Used internally when events are applied so the user event function has
   * access to the chart within the event callback.
   *
   * @param {object} event
   * @param {object} chart
   * @param {function} callback
   */
  this.event = function (event, chart, callback) {
    return callback(event, chart);
  };

  /**
   * Registers a chart as being on screen, accessible to redraws.
   */
  this.registerChart = function(type, label) {
    this.registeredCharts.push(type + ':' + label);
  };
  
  this.registerControl = function(type, label) {
    this.registeredControls.push(type + ':' + label);
  };
  
  this.registerDashboard = function(type, label) {
    this.registeredDashboards.push(type + ':' + label);
  };
  

  /**
   * Loads a new DataTable into the chart and redraws.
   *
   *
   * Used with an AJAX call to a PHP method returning DataTable->toJson(),
   * a chart can be dynamically update in page, without reloads.
   *
   * @param {string} chartLabel
   * @param {string} dataTableJson
   * @param {function} callback
   */
  this.loadData = function (chartLabel, dataTableJson, callback) {
    lava.getChart(chartLabel, function (chart, LavaChart) {
      LavaChart.setData(dataTableJson);
      LavaChart.redraw();

      if (typeof callback == 'function') {
        callback(LavaChart.chart);
      }
    });
  };

  this.getDashboard = function (label, callback) {
    if (typeof lava.dashboards[label] === 'undefined') {
      throw new Error('[Lavacharts] Dashboard "' + label + '" was not found.');
    }

    var lavaDashboard = lava.dashboards[label];

    if (typeof callback !== 'function') {
      throw new Error('[Lavacharts] ' + typeof callback + ' is not a valid callback.');
    }

    callback(lavaDashboard.dashboard, lavaDashboard);
  };

  /**
   * Returns the GoogleChart and the LavaChart objects
   *
   *
   * The GoogleChart object can be used to access any of the available methods such as
   * getImageURI() or getChartLayoutInterface().
   * See https://google-developers.appspot.com/chart/interactive/docs/gallery/linechart#methods
   * for some examples relative to LineCharts.
   *
   * The LavaChart object holds all the user defined properties such as data, options, formats,
   * the google chart object, and relative methods for internal use.
   *
   * Just to clarify:
   *  - The first returned callback value is a property of the LavaChart.
   *    It was add as a shortcut to avoid chart.chart to access google's methods of the chart.
   *
   *  - The second returned callback value is the LavaChart, which holds the GoogleChart and other
   *    important information. It was added to not restrict the user to only getting the GoogleChart
   *    returned, and as the second value because it is less useful / rarely accessed.
   *
   * @param  {string}   chartLabel
   * @param  {function} callback
   */
  this.getChart = function (chartLabel, callback) {
    if (typeof chartLabel != 'string') {
      throw new Error('[Lavacharts] ' + typeof chartLabel + ' is not a valid chart label.');
    }

    if (typeof callback != 'function') {
      throw new Error('[Lavacharts] ' + typeof callback + ' is not a valid callback.');
    }

    var chartTypes = Object.keys(lava.charts);
    var LavaChart;

    var search = chartTypes.some(function (type) {
      if (typeof lava.charts[type][chartLabel] !== 'undefined') {
        LavaChart = lava.charts[type][chartLabel];

        return true;
      } else {
        return false;
      }
    });

    if (search === false) {
      throw new Error('[Lavacharts] Chart "' + chartLabel + '" was not found.');
    }

    callback(LavaChart.chart, LavaChart);
  };
  
  this.getLavacontrol = function (controlLabel, callback) {
    var controlTypes = Object.keys(lava.controls);
    var control;

    var search = controlTypes.some(function (e) {
      if (typeof lava.controls[e][controlLabel] !== 'undefined') {
        control = lava.controls[e][controlLabel];

        return true;
      } else {
        return false;
      }
    });

    if (search === false) {
      throw new Error('[Lavacharts] Control "' + controlLabel + '" was not found');
    } else {
      callback(control);
    }
  };
  
  this.getLavadashboard = function (dashboardLabel, callback) {
    var dashboardTypes = Object.keys(lava.dashboards);
    var dashboard;

    var search = dashboardTypes.some(function (e) {
      if (typeof lava.dashboards[e][dashboardLabel] !== 'undefined') {
        dashboard = lava.dashboards[e][dashboardLabel];

        return true;
      } else {
        return false;
      }
    });

    if (search === false) {
      throw new Error('[Lavacharts] Dashboard "' + dashboardLabel + '" was not found');
    } else {
      callback(dashboard);
    }
  };

  /**
   * Redraws all of the registed charts on screen.
   *
   *
   * This method is attached to the window resize event with a 300ms debounce
   * to make the charts responsive to the browser resizing.
   */
  this.redrawCharts = function() {
    var timer, delay = 300;

    clearTimeout(timer);

    timer = setTimeout(function() {
      for(var c = 0; c < lava.registeredCharts.length; c++) {
        var parts = lava.registeredCharts[c].split(':');

        lava.charts[parts[0]][parts[1]].redraw();
      }
    }, delay);
  };
  
  this.redrawControls = function() {
    var timer, delay = 300;

    clearTimeout(timer);

    timer = setTimeout(function() {
      for(var c = 0; c < lava.registeredControls.length; c++) {
        var parts = lava.registeredControls[c].split(':');
		/*
        lava.controls[parts[0]][parts[1]].ontrol.draw(//Probably need to update this
          lava.controls[parts[0]][parts[1]].data,
          lava.controls[parts[0]][parts[1]].options
        );
        */
      }
    }, delay);
  };
  
  this.redrawDashboards = function() {
    var timer, delay = 300;

    clearTimeout(timer);

    timer = setTimeout(function() {
      for(var c = 0; c < lava.registeredDashboards.length; c++) {
        var parts = lava.registeredDashboards[c].split(':');

        lava.dashboards[parts[0]][parts[1]].dashboard.draw(	//Probably need to update this
          lava.dashboards[parts[0]][parts[1]].data,
          lava.dashboards[parts[0]][parts[1]].options
        );
      }
    }, delay);
  };

}).apply(lava);

/**
 * Adding the resize event listener for redrawing charts.
 */
window.addEventListener("resize", window.lava.redrawCharts);
