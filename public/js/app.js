/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! ./nav */ "./resources/js/nav.js");

__webpack_require__(/*! ./view */ "./resources/js/view.js");

__webpack_require__(/*! ./jquery.sortElements */ "./resources/js/jquery.sortElements.js");

__webpack_require__(/*! ./sortTable */ "./resources/js/sortTable.js");

__webpack_require__(/*! ./filterTable */ "./resources/js/filterTable.js");

__webpack_require__(/*! ./chart */ "./resources/js/chart.js");

/***/ }),

/***/ "./resources/js/chart.js":
/*!*******************************!*\
  !*** ./resources/js/chart.js ***!
  \*******************************/
/*! no static exports found */
/***/ (function(module, exports) {

var height = 600,
    width = 960;
var margin = {
  top: 10,
  right: 10,
  bottom: 150,
  left: 40
};
var svg = d3.select("#dataChart").append("svg").attr("viewBox", [0, 0, width, height]);
data = data.slice(0, 19);
var columns = [];

for (var key in data[0]) {
  if (data[0].hasOwnProperty(key) && key !== 'id' && key !== 'total' && key !== 'name') {
    columns.push(key);
  }
}

var series = d3.stack().keys(columns)(data).map(function (d) {
  return d.forEach(function (v) {
    return v.key = d.key;
  }), d;
});
var x = d3.scaleBand().domain(data.map(function (d) {
  return d.name;
})).range([margin.left, width - margin.right]).padding(0.1);
var y = d3.scaleLinear().domain([0, d3.max(series, function (d) {
  return d3.max(d, function (d) {
    return d[1];
  });
})]).rangeRound([height - margin.bottom, margin.top]);
var color = d3.scaleOrdinal().domain(series.map(function (d) {
  return d.key;
})).range(d3.schemeTableau10).unknown("#ccc");

var xAxis = function xAxis(g) {
  return g.style("font-size", "1em").attr("transform", "translate(0,".concat(height - margin.bottom, ")")).call(d3.axisBottom(x).tickSizeOuter(0)).call(function (g) {
    return g.selectAll(".domain").remove();
  });
};

var yAxis = function yAxis(g) {
  return g.style("font-size", "1em").attr("transform", "translate(".concat(margin.left, ",0)")).call(d3.axisLeft(y).ticks(null, "s")).call(function (g) {
    return g.selectAll(".domain").remove();
  });
};

svg.append("g").selectAll("g").data(series).join("g").attr("fill", function (d) {
  return color(d.key);
}).selectAll("rect").data(function (d) {
  return d;
}).join("rect").attr("x", function (d, i) {
  return x(d.data.name);
}).attr("y", function (d) {
  return y(d[1]);
}).attr("height", function (d) {
  return y(d[0]) - y(d[1]);
}).attr("width", x.bandwidth()).append("title").text(function (d) {
  return "".concat(d[1] - d[0]);
});
svg.append("g").call(xAxis).selectAll("text").style("text-anchor", "end").attr("dx", "-.8em").attr("dy", ".15em").attr("transform", "rotate(-65)");
svg.append("g").call(yAxis);

legend = function legend(svg) {
  var g = svg.attr("transform", "translate(".concat(width, ",0)")).attr("text-anchor", "end").style("font-size", "1em").selectAll("g").data(color.domain().slice().reverse()).join("g").attr("transform", function (d, i) {
    return "translate(0,".concat(i * 20, ")");
  });
  g.append("rect").attr("x", -19).attr("width", 19).attr("height", 19).attr("fill", color);
  g.append("text").attr("x", -24).attr("y", 9.5).attr("dy", "0.35em").text(function (d) {
    return d.substring(2);
  });
};

svg.append("g").call(legend);

/***/ }),

/***/ "./resources/js/filterTable.js":
/*!*************************************!*\
  !*** ./resources/js/filterTable.js ***!
  \*************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// insert searchbar
$('<input id="dataReducer" class="input mb-4" style="max-width:600px" type="text" placeholder="Suchbegriff">').insertBefore('#dataTable table');
$('#dataReducer').on('keyup', function () {
  var value = $(this).val().toLowerCase();
  $('#dataTable tr').filter(function () {
    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
  });
});

/***/ }),

/***/ "./resources/js/jquery.sortElements.js":
/*!*********************************************!*\
  !*** ./resources/js/jquery.sortElements.js ***!
  \*********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

/**
 * jQuery.fn.sortElements
 * --------------
 * @param Function comparator:
 *   Exactly the same behaviour as [1,2,3].sort(comparator)
 *
 * @param Function getSortable
 *   A function that should return the element that is
 *   to be sorted. The comparator will run on the
 *   current collection, but you may want the actual
 *   resulting sort to occur on a parent or another
 *   associated element.
 *
 *   E.g. $('td').sortElements(comparator, function(){
 *      return this.parentNode;
 *   })
 *
 *   The <td>'s parent (<tr>) will be sorted instead
 *   of the <td> itself.
 */
jQuery.fn.sortElements = function () {
  var sort = [].sort;
  return function (comparator, getSortable) {
    getSortable = getSortable || function () {
      return this;
    };

    var placements = this.map(function () {
      var sortElement = getSortable.call(this),
          parentNode = sortElement.parentNode,
          // Since the element itself will change position, we have
      // to have some way of storing its original position in
      // the DOM. The easiest way is to have a 'flag' node:
      nextSibling = parentNode.insertBefore(document.createTextNode(''), sortElement.nextSibling);
      return function () {
        if (parentNode === this) {
          throw new Error("You can't sort elements if any one is a descendant of another.");
        } // Insert before flag:


        parentNode.insertBefore(this, nextSibling); // Remove flag:

        parentNode.removeChild(nextSibling);
      };
    });
    return sort.call(this, comparator).each(function (i) {
      placements[i].call(getSortable.call(this));
    });
  };
}();

/***/ }),

/***/ "./resources/js/nav.js":
/*!*****************************!*\
  !*** ./resources/js/nav.js ***!
  \*****************************/
/*! no static exports found */
/***/ (function(module, exports) {

document.addEventListener('DOMContentLoaded', function () {
  var $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);

  if ($navbarBurgers.length > 0) {
    $navbarBurgers.forEach(function (el) {
      el.addEventListener('click', function () {
        var target = el.dataset.target;
        var $target = document.getElementById(target);
        el.classList.toggle('is-active');
        $target.classList.toggle('is-active');
      });
    });
  }
});

/***/ }),

/***/ "./resources/js/sortTable.js":
/*!***********************************!*\
  !*** ./resources/js/sortTable.js ***!
  \***********************************/
/*! no static exports found */
/***/ (function(module, exports) {

var table = $('#dataTable table');
$('#dataTable table th').append('<i class="fas fa-sort" style="display:inline;margin-left:5px"></i>').css('cursor', 'pointer').each(function () {
  var th = $(this),
      thIndex = th.index(),
      inverse = false;
  th.click(function () {
    table.find('td').filter(function () {
      return $(this).index() === thIndex;
    }).sortElements(function (a, b) {
      a = $(a).text();
      b = $(b).text();
      return (isNaN(a) || isNaN(b) ? a > b : +a > +b) ? inverse ? -1 : 1 : inverse ? 1 : -1;
    }, function () {
      // parentNode is the element we want to move
      return this.parentNode;
    });
    inverse = !inverse;
  });
});

/***/ }),

/***/ "./resources/js/view.js":
/*!******************************!*\
  !*** ./resources/js/view.js ***!
  \******************************/
/*! no static exports found */
/***/ (function(module, exports) {

// insert view switch buttons
$('<div class="buttons has-addons is-centered mt-6">\n' + '  <button id="tableButton" class="button is-info is-selected">Tabelle</button>\n' + '  <button id="diagramButton" class="button">Diagramm</button>\n' + '</div>').insertBefore('#dataTable');
$('#dataChart').hide();
$('#tableButton').click(function () {
  $('#dataChart').hide();
  $('#diagramButton').removeClass("is-info is-selected");
  $('#tableButton').addClass("is-info is-selected");
  $('#dataTable').show();
});
$('#diagramButton').click(function () {
  $('#dataTable').hide();
  $('#tableButton').removeClass("is-info is-selected");
  $('#diagramButton').addClass("is-info is-selected");
  $('#dataChart').show();
});

/***/ }),

/***/ "./resources/sass/app.scss":
/*!*********************************!*\
  !*** ./resources/sass/app.scss ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/*!*************************************************************!*\
  !*** multi ./resources/js/app.js ./resources/sass/app.scss ***!
  \*************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! /Users/vlahovits/VM/workspace/github.com/vonvlaho/bibreports/resources/js/app.js */"./resources/js/app.js");
module.exports = __webpack_require__(/*! /Users/vlahovits/VM/workspace/github.com/vonvlaho/bibreports/resources/sass/app.scss */"./resources/sass/app.scss");


/***/ })

/******/ });