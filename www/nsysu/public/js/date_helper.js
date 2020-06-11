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
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/admin/date_helper.js":
/*!**************************************************!*\
  !*** ./resources/assets/js/admin/date_helper.js ***!
  \**************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

/**
 * 格式化時間(yyyy-m-d)
 */
Date.prototype.yyyymmdd = function () {
  var yyyy = this.getFullYear();
  var mm = this.getMonth() < 9 ? "0" + (this.getMonth() + 1) : this.getMonth() + 1; // getMonth() is zero-based

  var dd = this.getDate() < 10 ? "0" + this.getDate() : this.getDate();
  var pattern = /(\d{4})(\d{2})(\d{2})/;
  var dateString = "".concat(yyyy).concat(mm).concat(dd);
  return dateString.replace(pattern, '$1-$2-$3');
};
/**
 * n年後(前)今天，n若未正整數則維n年後，反之則為n年前
 * @param int years
 */


Date.prototype.addYears = function (years) {
  var strYear = this.getFullYear() + years;
  var strDay = this.getDate();
  var strMonth = this.getMonth() + 1;

  if (strMonth < 10) {
    strMonth = "0" + strMonth;
  }

  if (strDay < 10) {
    strDay = "0" + strDay;
  }

  var datastr = strYear + "-" + strMonth + "-" + strDay;
  return datastr;
};
/**
 * n個月後(前)今天，n若未正整數則維n年後，反之則為n日前
 * @param int months
 */


Date.prototype.addMonths = function (months) {
  this.setMonth(this.getMonth() + months);
  var strYear = this.getFullYear();
  var strMonth = this.getMonth() + 1;
  var strDay = this.getDate();
  var datastr = strYear + '-' + (strMonth < 10 ? '0' : '') + strMonth + '-' + (strDay < 10 ? '0' : '') + strDay;
  return datastr;
};
/**
 * n日後(前)今天，n若未正整數則維n日後，反之則為n日
 * @param {*} days
 */


Date.prototype.addDays = function (days) {
  this.setDate(this.getDate() + days);
  return this;
};
/**
 * 該年分第一天時間日期
 */


Date.prototype.yearFirstDay = function () {
  var year = this.getFullYear();
  date = new Date(year, 0, 1);
  return date;
};
/**
 * 當月第一天時間日期
 */


Date.prototype.monthFirstDay = function () {
  this.setDate(1);
  return this;
};
/**
 * 當月最後一天時間日期
 */


Date.prototype.monthFinalDay = function () {
  this.setMonth(this.getMonth() + 1);
  this.setDate(-1);
  return this;
};
/**
 * 上個月第一天時間日期
 */


Date.prototype.previousMonthFirstDay = function () {
  var year = this.getFullYear();
  var month = this.getMonth();
  var date = new Date(year, month - 1, 1);
  return date;
};
/**
 * 上個月最後一天時間日期
 */


Date.prototype.previousMonthFinalDay = function () {
  var year = this.getFullYear();
  var month = this.getMonth();
  var date = new Date(year, month, 0);
  return date;
};

/***/ }),

/***/ 1:
/*!********************************************************!*\
  !*** multi ./resources/assets/js/admin/date_helper.js ***!
  \********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/nsysu/resources/assets/js/admin/date_helper.js */"./resources/assets/js/admin/date_helper.js");


/***/ })

/******/ });