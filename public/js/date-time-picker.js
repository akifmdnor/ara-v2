/******/ (() => { // webpackBootstrap
/*!******************************************!*\
  !*** ./resources/js/date-time-picker.js ***!
  \******************************************/
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _regenerator() { /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/babel/babel/blob/main/packages/babel-helpers/LICENSE */ var e, t, r = "function" == typeof Symbol ? Symbol : {}, n = r.iterator || "@@iterator", o = r.toStringTag || "@@toStringTag"; function i(r, n, o, i) { var c = n && n.prototype instanceof Generator ? n : Generator, u = Object.create(c.prototype); return _regeneratorDefine2(u, "_invoke", function (r, n, o) { var i, c, u, f = 0, p = o || [], y = !1, G = { p: 0, n: 0, v: e, a: d, f: d.bind(e, 4), d: function d(t, r) { return i = t, c = 0, u = e, G.n = r, a; } }; function d(r, n) { for (c = r, u = n, t = 0; !y && f && !o && t < p.length; t++) { var o, i = p[t], d = G.p, l = i[2]; r > 3 ? (o = l === n) && (u = i[(c = i[4]) ? 5 : (c = 3, 3)], i[4] = i[5] = e) : i[0] <= d && ((o = r < 2 && d < i[1]) ? (c = 0, G.v = n, G.n = i[1]) : d < l && (o = r < 3 || i[0] > n || n > l) && (i[4] = r, i[5] = n, G.n = l, c = 0)); } if (o || r > 1) return a; throw y = !0, n; } return function (o, p, l) { if (f > 1) throw TypeError("Generator is already running"); for (y && 1 === p && d(p, l), c = p, u = l; (t = c < 2 ? e : u) || !y;) { i || (c ? c < 3 ? (c > 1 && (G.n = -1), d(c, u)) : G.n = u : G.v = u); try { if (f = 2, i) { if (c || (o = "next"), t = i[o]) { if (!(t = t.call(i, u))) throw TypeError("iterator result is not an object"); if (!t.done) return t; u = t.value, c < 2 && (c = 0); } else 1 === c && (t = i["return"]) && t.call(i), c < 2 && (u = TypeError("The iterator does not provide a '" + o + "' method"), c = 1); i = e; } else if ((t = (y = G.n < 0) ? u : r.call(n, G)) !== a) break; } catch (t) { i = e, c = 1, u = t; } finally { f = 1; } } return { value: t, done: y }; }; }(r, o, i), !0), u; } var a = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} t = Object.getPrototypeOf; var c = [][n] ? t(t([][n]())) : (_regeneratorDefine2(t = {}, n, function () { return this; }), t), u = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(c); function f(e) { return Object.setPrototypeOf ? Object.setPrototypeOf(e, GeneratorFunctionPrototype) : (e.__proto__ = GeneratorFunctionPrototype, _regeneratorDefine2(e, o, "GeneratorFunction")), e.prototype = Object.create(u), e; } return GeneratorFunction.prototype = GeneratorFunctionPrototype, _regeneratorDefine2(u, "constructor", GeneratorFunctionPrototype), _regeneratorDefine2(GeneratorFunctionPrototype, "constructor", GeneratorFunction), GeneratorFunction.displayName = "GeneratorFunction", _regeneratorDefine2(GeneratorFunctionPrototype, o, "GeneratorFunction"), _regeneratorDefine2(u), _regeneratorDefine2(u, o, "Generator"), _regeneratorDefine2(u, n, function () { return this; }), _regeneratorDefine2(u, "toString", function () { return "[object Generator]"; }), (_regenerator = function _regenerator() { return { w: i, m: f }; })(); }
function _regeneratorDefine2(e, r, n, t) { var i = Object.defineProperty; try { i({}, "", {}); } catch (e) { i = 0; } _regeneratorDefine2 = function _regeneratorDefine(e, r, n, t) { function o(r, n) { _regeneratorDefine2(e, r, function (e) { return this._invoke(r, n, e); }); } r ? i ? i(e, r, { value: n, enumerable: !t, configurable: !t, writable: !t }) : e[r] = n : (o("next", 0), o("throw", 1), o("return", 2)); }, _regeneratorDefine2(e, r, n, t); }
function asyncGeneratorStep(n, t, e, r, o, a, c) { try { var i = n[a](c), u = i.value; } catch (n) { return void e(n); } i.done ? t(u) : Promise.resolve(u).then(r, o); }
function _asyncToGenerator(n) { return function () { var t = this, e = arguments; return new Promise(function (r, o) { var a = n.apply(t, e); function _next(n) { asyncGeneratorStep(a, r, o, _next, _throw, "next", n); } function _throw(n) { asyncGeneratorStep(a, r, o, _next, _throw, "throw", n); } _next(void 0); }); }; }
function _classCallCheck(a, n) { if (!(a instanceof n)) throw new TypeError("Cannot call a class as a function"); }
function _defineProperties(e, r) { for (var t = 0; t < r.length; t++) { var o = r[t]; o.enumerable = o.enumerable || !1, o.configurable = !0, "value" in o && (o.writable = !0), Object.defineProperty(e, _toPropertyKey(o.key), o); } }
function _createClass(e, r, t) { return r && _defineProperties(e.prototype, r), t && _defineProperties(e, t), Object.defineProperty(e, "prototype", { writable: !1 }), e; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
/**
 * Date and Time Picker with Availability Restrictions
 * Handles date selection, time restrictions, and availability logic
 */
var DateTimePicker = /*#__PURE__*/function () {
  function DateTimePicker() {
    _classCallCheck(this, DateTimePicker);
    this.restrictedDates = [];
    this.now = new Date();
    this.needToUpdateTime = false;
    this.initializeDateTimePicker();
  }

  /**
   * Initialize the date and time picker functionality
   */
  return _createClass(DateTimePicker, [{
    key: "initializeDateTimePicker",
    value: function initializeDateTimePicker() {
      this.setupInitialDates();
      this.fetchRestrictedDates();
      this.setupDatePickers();
      this.setupTimeRestrictions();
    }

    /**
     * Setup initial dates based on current time
     */
  }, {
    key: "setupInitialDates",
    value: function setupInitialDates() {
      // If current time is after 7 PM, set start date to day after tomorrow
      if (this.now.getHours() >= 19) {
        this.now.setDate(this.now.getDate() + 2);
        this.now.setHours(9, 0, 0, 0);
        this.needToUpdateTime = true;
      } else {
        // If before 7 PM, set start date to tomorrow
        this.now.setDate(this.now.getDate() + 1);
        this.now.setHours(9, 0, 0, 0);
      }

      // Check if URL has time parameters
      var urlParams = new URLSearchParams(window.location.search);
      var hasPickupTime = urlParams.has("pickup_time");
      var hasReturnTime = urlParams.has("return_time");
      if (!hasPickupTime && !hasReturnTime) {
        this.needToUpdateTime = true;
      }

      // Set initial dates
      this.setDateInput(this.getDateString(this.now, 0), this.getDateString(this.now, 1));
    }

    /**
     * Fetch restricted dates from server
     */
  }, {
    key: "fetchRestrictedDates",
    value: (function () {
      var _fetchRestrictedDates = _asyncToGenerator(/*#__PURE__*/_regenerator().m(function _callee() {
        var response, data, _t;
        return _regenerator().w(function (_context) {
          while (1) switch (_context.p = _context.n) {
            case 0:
              _context.p = 0;
              _context.n = 1;
              return fetch("/restricted-date");
            case 1:
              response = _context.v;
              _context.n = 2;
              return response.json();
            case 2:
              data = _context.v;
              this.restrictedDates = this.restrictedDates.concat(data);

              // Sort restricted dates
              this.restrictedDates.sort(function (a, b) {
                var aa = a.split("-").reverse().join();
                var bb = b.split("-").reverse().join();
                return aa < bb ? -1 : aa > bb ? 1 : 0;
              });
              this.processRestrictedDates();
              _context.n = 4;
              break;
            case 3:
              _context.p = 3;
              _t = _context.v;
              console.error("Error fetching restricted dates:", _t);
            case 4:
              return _context.a(2);
          }
        }, _callee, this, [[0, 3]]);
      }));
      function fetchRestrictedDates() {
        return _fetchRestrictedDates.apply(this, arguments);
      }
      return fetchRestrictedDates;
    }()
    /**
     * Process restricted dates and update pickers
     */
    )
  }, {
    key: "processRestrictedDates",
    value: function processRestrictedDates() {
      var _this = this;
      var nextAvailableDate = this.getDateString(this.now, 0);

      // Check if next available date is restricted
      this.restrictedDates.forEach(function (date) {
        if (nextAvailableDate === date) {
          _this.now.setDate(_this.now.getDate() + 1);
          _this.now.setHours(1, 0, 0, 0);
          nextAvailableDate = _this.getDateString(_this.now, 0);
          _this.needToUpdateTime = true;
        }
      });

      // Update date pickers with restricted dates
      this.updateDatePickers();

      // Update time restrictions if needed
      if (this.needToUpdateTime) {
        this.updateAvailableTimes(this.now, this.now);
        this.needToUpdateTime = false;
      }
    }

    /**
     * Setup date pickers with restrictions
     */
  }, {
    key: "setupDatePickers",
    value: function setupDatePickers() {
      var _this2 = this;
      console.log("Setting up date pickers...");

      // Start Date Picker
      if ($("#InputStartDate").length) {
        $("#InputStartDate").datepicker({
          format: "dd-mm-yyyy",
          autoclose: true,
          startDate: "+1d",
          endDate: "+1y",
          datesDisabled: this.restrictedDates,
          todayHighlight: false,
          clearBtn: true,
          orientation: "bottom auto",
          beforeShowDay: function beforeShowDay(date) {
            // Disable today and past dates
            var today = new Date();
            today.setHours(0, 0, 0, 0);
            return [date >= today, ""];
          }
        }).on("changeDate", function (selected) {
          console.log("Start date changed:", selected.date);
          _this2.onStartDateChange(selected);
        });
        console.log("Start date picker initialized");
      } else {
        console.error("InputStartDate element not found");
      }

      // Return Date Picker
      if ($("#InputReturnDate").length) {
        $("#InputReturnDate").datepicker({
          format: "dd-mm-yyyy",
          autoclose: true,
          startDate: "+0d",
          todayHighlight: true,
          clearBtn: true,
          orientation: "bottom auto"
        });
        console.log("Return date picker initialized");
      } else {
        console.error("InputReturnDate element not found");
      }
    }

    /**
     * Handle start date change
     */
  }, {
    key: "onStartDateChange",
    value: function onStartDateChange(selected) {
      var minDate = new Date(selected.date.valueOf());
      minDate.setDate(minDate.getDate() + 1);

      // Update return date picker
      $("#InputReturnDate").datepicker("setStartDate", minDate);

      // Set return date to one day after start date
      var year = minDate.getFullYear();
      var month = String(minDate.getMonth() + 1).padStart(2, "0");
      var day = String(minDate.getDate()).padStart(2, "0");
      $("#InputReturnDate").val("".concat(day, "-").concat(month, "-").concat(year));

      // Update available times
      selected.date.setHours(this.now.getHours(), this.now.getMinutes(), this.now.getSeconds(), this.now.getMilliseconds());
      this.updateAvailableTimes(selected.date, this.now);
    }

    /**
     * Update date pickers with restricted dates
     */
  }, {
    key: "updateDatePickers",
    value: function updateDatePickers() {
      // Ensure start date is always at least tomorrow
      var tomorrow = new Date();
      tomorrow.setDate(tomorrow.getDate() + 1);
      tomorrow.setHours(0, 0, 0, 0);
      var startDate = this.now > tomorrow ? this.now : tomorrow;
      $("#InputStartDate").datepicker("setDatesDisabled", this.restrictedDates);
      $("#InputReturnDate").datepicker("setDatesDisabled", this.restrictedDates.concat(this.getDateString(this.now, 0)));
      $("#InputStartDate").datepicker("setStartDate", startDate);
      $("#InputReturnDate").datepicker("setStartDate", this.getDateString(startDate, 1));
      this.setDateInput(this.getDateString(startDate, 0), this.getDateString(startDate, 1));
    }

    /**
     * Update available times based on selected date
     */
  }, {
    key: "updateAvailableTimes",
    value: function updateAvailableTimes(date, today) {
      var currentDateTime = new Date(date);
      var currentHours = currentDateTime.getHours();
      var currentMinutes = currentDateTime.getMinutes();
      var currentDay = currentDateTime.getDate();
      var todayDay = today.getDate();

      // Only apply time restrictions if the selected date is today
      if (currentDay === todayDay) {
        console.log("currentDay: ".concat(currentDay, ", today: ").concat(todayDay));
        var firstAvailableOption = null;
        $("#InputStartTime option").each(function () {
          var optionTime = $(this).val().toUpperCase();
          var optionDateTime = new Date("01/01/2007 " + optionTime);

          // Check if current time is before 9 AM
          if (currentHours < 9) {
            if (optionDateTime.getHours() < 10 || optionDateTime.getHours() === 10 && optionDateTime.getMinutes() < 30) {
              $(this).prop("disabled", true);
            }
          } else {
            // Disable time options less than one hour from now
            var currentTimeInMinutes = currentHours * 60 + currentMinutes;
            var optionTimeInMinutes = optionDateTime.getHours() * 60 + optionDateTime.getMinutes();
            if (optionTimeInMinutes <= currentTimeInMinutes + 60) {
              $(this).prop("disabled", true);
            } else if (!firstAvailableOption) {
              firstAvailableOption = this;
            }
          }

          // If currently selected option is disabled, select next available
          if ($(this).is(":selected") && $(this).is(":disabled")) {
            $(this).prop("selected", false);
            if (firstAvailableOption) {
              $(firstAvailableOption).prop("selected", true);
            }
          }
        });
      } else {
        // Enable all time options for future dates
        $("#InputStartTime option").each(function () {
          $(this).prop("disabled", false);
        });
      }
    }

    /**
     * Setup time restrictions
     */
  }, {
    key: "setupTimeRestrictions",
    value: function setupTimeRestrictions() {
      if (this.needToUpdateTime) {
        this.updateAvailableTimes(this.now, this.now);
        this.needToUpdateTime = false;
      }
    }

    /**
     * Get date string in dd-mm-yyyy format
     */
  }, {
    key: "getDateString",
    value: function getDateString(now, dateToAdd) {
      var tempNow = new Date(now);
      tempNow.setDate(tempNow.getDate() + dateToAdd);
      var month = String(tempNow.getMonth() + 1).padStart(2, "0");
      var day = String(tempNow.getDate()).padStart(2, "0");
      return "".concat(day, "-").concat(month, "-").concat(tempNow.getFullYear());
    }

    /**
     * Set date input values with validation
     */
  }, {
    key: "setDateInput",
    value: function setDateInput(startDate, returnDate) {
      var startDateInput = $("#InputStartDate").val().split("-").reverse().join("");
      var returnDateInput = $("#InputReturnDate").val().split("-").reverse().join("");
      var startDateConv = startDate.split("-").reverse().join("");
      var returnDateConv = returnDate.split("-").reverse().join("");

      // Set to minimum date if input is earlier
      if (startDateInput < startDateConv) {
        $("#InputStartDate").val(startDate);
      }
      if (returnDateInput < returnDateConv) {
        $("#InputReturnDate").val(returnDate);
      }
    }

    /**
     * Update blocked dates
     */
  }, {
    key: "updateBlockDate",
    value: function updateBlockDate(dateArray) {
      $("#InputStartDate").datepicker("setDatesDisabled", dateArray);
      $("#InputReturnDate").datepicker("setDatesDisabled", dateArray);
    }
  }]);
}(); // Initialize when DOM is ready
document.addEventListener("DOMContentLoaded", function () {
  // Wait for jQuery and datepicker to be available
  if (typeof $ !== "undefined" && $.fn.datepicker) {
    window.dateTimePicker = new DateTimePicker();
  } else {
    // Fallback: wait a bit more for scripts to load
    setTimeout(function () {
      if (typeof $ !== "undefined" && $.fn.datepicker) {
        window.dateTimePicker = new DateTimePicker();
      } else {
        console.error("jQuery or Bootstrap Datepicker not loaded");
      }
    }, 1000);
  }
});
/******/ })()
;