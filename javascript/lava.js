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
    this.dashboardName	= null;
  };
  
  this.Control 		= function() {
    this.init    		= null;
    this.redraw  		= null;
    this.setData 		= null;
    this.data    		= null;
    this.control 		= null;
    this.options 		= null;
    this.formats 		= [];
    this.dashboardName 	= null;
  };
  
  this.Dashboard 		= function() {
    this.init    		= null;
    this.redraw  		= null;
    this.setData 		= null;
    this.data    		= null;
    this.dashboard  	= null;
    this.options 		= null;
    this.formats 		= [];
    this.bindings 		= null;
  };

  this.get = function (chartLabel, callback) {
    if (arguments.length < 2 || typeof chartLabel !== 'string' || typeof callback !== 'function') {
      throw new Error('[Lavacharts] The syntax for lava.get must be (str ChartLabel, fn Callback)');
    }

    lava.getLavachart(chartLabel, function (lavachart) {
      return callback(lavachart.chart);
    });
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
  };

  this.event = function (event, chart, callback) {
    return callback(event, chart);
  };

  this.register = function(type, label) {
    this.registeredCharts.push(type + ':' + label);
  };
  
  this.registerControl = function(type, label) {
    this.registeredControls.push(type + ':' + label);
  };
  
  this.registerDashboard = function(type, label) {
    this.registeredDashboards.push(type + ':' + label);
  };
  

  this.getLavachart = function (chartLabel, callback) {
    var chartTypes = Object.keys(lava.charts);
    var chart;

    var search = chartTypes.some(function (e) {
      if (typeof lava.charts[e][chartLabel] !== 'undefined') {
        chart = lava.charts[e][chartLabel];

        return true;
      } else {
        return false;
      }
    });

    if (search === false) {
      throw new Error('[Lavacharts] Chart "' + chartLabel + '" was not found');
    } else {
      callback(chart);
    }
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

  this.redrawCharts = function() {
    var timer, delay = 300;

    clearTimeout(timer);

    timer = setTimeout(function() {
      for(var c = 0; c < lava.registeredCharts.length; c++) {
        var parts = lava.registeredCharts[c].split(':');

        lava.charts[parts[0]][parts[1]].chart.draw(
          lava.charts[parts[0]][parts[1]].data,
          lava.charts[parts[0]][parts[1]].options
        );
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

  return this;
})();

window.addEventListener("resize", window.lava.redrawCharts);
