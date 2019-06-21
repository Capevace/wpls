(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[3],{

/***/ "./resources/assets/js/components/data-table.js":
/*!******************************************************!*\
  !*** ./resources/assets/js/components/data-table.js ***!
  \******************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var deep_assign__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! deep-assign */ "./node_modules/deep-assign/index.js");
/* harmony import */ var deep_assign__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(deep_assign__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var lodash_debounce__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! lodash.debounce */ "./node_modules/lodash.debounce/index.js");
/* harmony import */ var lodash_debounce__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(lodash_debounce__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _utils__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../utils */ "./resources/assets/js/utils/index.js");


function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }





var DataDisplay = {
  props: ['entry', 'column'],
  computed: {
    value: function value() {
      return Object(_utils__WEBPACK_IMPORTED_MODULE_4__["getNested"])(this.entry, this.column.path);
    },
    defaultedComponent: function defaultedComponent() {
      if (this.column.component) return Object.assign({
        props: ['entry', 'column']
      }, this.column.component);else return null;
    }
  },
  filters: {
    date: function date(value) {
      var date = new Date(value);
      return date.toLocaleDateString();
    },
    datetime: function datetime(value) {
      var date = new Date(value);
      return date.toLocaleString();
    },
    time: function time(value) {
      var date = new Date(value);
      return date.toLocaleTimeString();
    }
  },
  template: "\n        <span>\n            <template v-if=\"column.component\">\n                <component :is=\"defaultedComponent\" :entry=\"entry\" :column=\"column\"></component>\n            </template>\n            <template v-else-if=\"column.type === 'date'\">\n                {{ value | date }}\n            </template>\n            <template v-else-if=\"column.type === 'datetime'\">\n                {{ value | datetime }}\n            </template>\n            <template v-else-if=\"column.type === 'time'\">\n                {{ value | time }}\n            </template>\n            <template v-else>\n                {{ value }}\n            </template>\n        </span>\n    "
};
/* harmony default export */ __webpack_exports__["default"] = ({
  props: {
    dataUrl: {
      required: true,
      type: String
    },
    columns: {
      required: true,
      type: Array
    },
    options: {
      type: Object,
      "default": {}
    }
  },
  data: function data(props) {
    return {
      loading: true,
      error: null,
      orderBy: props.options && props.options.orderBy ? props.options.orderBy : 'id',
      orderType: props.options && props.options.orderType ? props.options.orderType : 'asc',
      limit: 25,
      search: '',
      page: 1,
      lastPage: 1,
      entries: []
    };
  },
  mounted: function () {
    var _mounted = _asyncToGenerator(
    /*#__PURE__*/
    _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee() {
      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee$(_context) {
        while (1) {
          switch (_context.prev = _context.next) {
            case 0:
              this.fetchEntries();

            case 1:
            case "end":
              return _context.stop();
          }
        }
      }, _callee, this);
    }));

    function mounted() {
      return _mounted.apply(this, arguments);
    }

    return mounted;
  }(),
  computed: {
    defaultedOptions: function defaultedOptions() {
      return deep_assign__WEBPACK_IMPORTED_MODULE_2___default()({
        includeStyle: true,
        displayFooter: true,
        displaySearch: true,
        displayLimit: true,
        displayLoader: true,
        displayPagination: true,
        displayPaginationButtons: true,
        customLoader: null,
        classes: {
          table: 'table',
          row: '',
          level: 'level',
          levelLeft: 'level-left',
          levelRight: 'level-right',
          levelItem: 'level-item',
          label: 'label is-small',
          formField: 'field',
          searchInput: 'input is-small',
          limitInput: 'select',
          limitInputContainer: 'select is-small',
          pagination: 'pagination is-centered is-small',
          paginationPrevious: 'pagination-previous',
          paginationNext: 'pagination-next',
          paginationList: 'pagination-list',
          paginationLink: 'pagination-link',
          paginationLinkCurrent: 'is-current',
          paginationEllipsis: 'pagination-ellipsis'
        },
        labels: {
          searchLabel: 'Search',
          searchPlaceholder: 'Search...',
          limitLabel: 'Limit',
          loadingLabel: 'Loading...',
          sortingDesc: '▲',
          sortingAsc: '▼'
        },
        limits: [5, 10, 25, 50, 100, 500],
        searchKey: ''
      }, this.options);
    },
    pages: function pages() {
      return Object(_utils__WEBPACK_IMPORTED_MODULE_4__["getPaginationArray"])(this.page, this.lastPage);
    }
  },
  methods: {
    isOrderedBy: function isOrderedBy(column) {
      if (column.component) return;
      return this.orderBy !== column.path ? '' : this.orderType === 'desc' ? this.defaultedOptions.labels.sortingDesc : this.defaultedOptions.labels.sortingAsc;
    },
    columnAction: function columnAction(column) {
      if (column.component) return; // If we're already ordering by that column, swap type

      if (this.orderBy === column.path) {
        this.orderType = this.orderType === 'asc' ? 'desc' : 'asc';
      } else {
        this.orderBy = column.path;
        this.orderType = 'asc';
      }

      this.fetchEntries();
    },
    goToPage: function goToPage(pageNumber) {
      if (this.page === pageNumber || pageNumber < 1 || pageNumber > this.lastPage) return;
      this.page = pageNumber;
      this.fetchEntries();
    },
    fetchEntries: function () {
      var _fetchEntries = _asyncToGenerator(
      /*#__PURE__*/
      _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee2() {
        var queryString, response, responseData;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                this.loading = true;
                queryString = '';

                if (this.orderBy !== '') {
                  queryString += 'order-by=' + encodeURIComponent(this.orderBy) + '&';
                  queryString += 'order-type=' + encodeURIComponent(this.orderType) + '&';
                }

                if (this.limit) queryString += 'limit=' + encodeURIComponent(this.limit) + '&';
                if (this.search) queryString += 'search=' + encodeURIComponent(this.search) + '&';
                if (this.options.searchKey) queryString += 'search-key=' + encodeURIComponent(this.options.searchKey) + '&';
                if (this.page) queryString += 'page=' + encodeURIComponent(this.page) + '&';
                _context2.prev = 7;
                _context2.next = 10;
                return Object(axios__WEBPACK_IMPORTED_MODULE_1__["get"])("".concat(this.dataUrl, "?").concat(queryString));

              case 10:
                response = _context2.sent;
                responseData = response.data;
                this.entries = responseData.data;
                this.lastPage = responseData.last_page;
                this.error = null;
                this.loading = false;
                _context2.next = 24;
                break;

              case 18:
                _context2.prev = 18;
                _context2.t0 = _context2["catch"](7);
                this.entries = [];
                this.lastPage = 0;
                this.error = JSON.stringify(_context2.t0);
                this.loading = false;

              case 24:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2, this, [[7, 18]]);
      }));

      function fetchEntries() {
        return _fetchEntries.apply(this, arguments);
      }

      return fetchEntries;
    }(),
    refresh: function refresh() {
      this.fetchEntries();
    }
  },
  watch: {
    search: lodash_debounce__WEBPACK_IMPORTED_MODULE_3___default()(function () {
      this.fetchEntries();
    }, 300),
    limit: function limit() {
      this.fetchEntries();
    },
    dataUrl: function dataUrl() {
      this.error = null;
      this.orderBy = 'id';
      this.orderType = 'asc';
      this.limit = 25;
      this.search = '';
      this.page = 1;
      this.lastPage = 1;
      this.entries = [];
      this.fetchEntries();
    }
  },
  components: {
    'data-display': DataDisplay
  },
  template: "\n        <div>\n            <div :class=\"{[defaultedOptions.classes.level]: true}\">\n                <div :class=\"{[defaultedOptions.classes.levelLeft]: true}\">\n                    <div :class=\"{[defaultedOptions.classes.levelItem]: true}\">\n                        <div :class=\"{[defaultedOptions.classes.formField]: true}\">\n                            <label \n                                for=\"limit-input\"\n                                :class=\"{[defaultedOptions.classes.label]: true}\">\n                                {{ defaultedOptions.labels.limitLabel }}\n                            </label>\n                            <div :class=\"{[defaultedOptions.classes.limitInputContainer]: true}\">\n                                <select\n                                    name=\"limit-input\"\n                                    :class=\"{[defaultedOptions.classes.limitInput]: true}\"\n                                    v-model=\"limit\"\n                                    :disabled=\"loading\">\n                                    <option v-for=\"limit in defaultedOptions.limits\" :value=\"limit\">{{ limit }}</option>        \n                                </select>\n                            </div>\n                        </div>\n                    </div>\n                </div>\n\n                <div :class=\"{[defaultedOptions.classes.levelItem]: true}\" v-if=\"defaultedOptions.displayLoader\">\n                    <h3 v-if=\"!defaultedOptions.customLoader && loading\" class=\"is-size-4\">\n                        {{ defaultedOptions.labels.loadingLabel }}\n                    </h3>\n                    <component v-else :is=\"defaultedOptions.customLoader\" :loading=\"loading\"></component>\n                </div>\n\n                <div :class=\"{[defaultedOptions.classes.levelRight]: true}\">\n                    <div :class=\"{[defaultedOptions.classes.levelItem]: true}\">\n                        <div :class=\"{[defaultedOptions.classes.formField]: true}\">\n                            <label \n                                for=\"search-input\"\n                                :class=\"{[defaultedOptions.classes.label]: true}\">\n                                {{ defaultedOptions.labels.searchLabel }}\n                            </label>\n                            <input \n                                name=\"search-input\" \n                                :placeholder=\"defaultedOptions.labels.searchPlaceholder\" \n                                :class=\"{[defaultedOptions.classes.searchInput]: true}\"\n                                :disabled=\"loading\"\n                                v-model=\"search\">\n                        </div>\n                    </div>\n                </div>\n            </div>\n            <table :class=\"{[defaultedOptions.classes.table]: true, 'smdt__table': true, 'is-loading': loading}\">\n                <thead>\n                    <th \n                        v-for=\"column in columns\" \n                        :key=\"column.path || column.title\" \n                        :class=\"{[column.headingClass  || '']: true, 'is-sortable': !column.component}\"\n                        @click=\"columnAction(column)\">\n                        {{ column.title ? column.title : column.path }} {{ isOrderedBy(column) }}\n                    </th>\n                </thead>\n                <tbody>\n                    <tr v-for=\"(entry, index) in entries\" :class=\"{[defaultedOptions.classes.row]: true}\">\n                        <td v-for=\"column in columns\" :key=\"column.path || column.title\" :class=\"{[column.columnClass || '']: true}\">\n                            <data-display :entry=\"entry\" :column=\"column\"></data-display>\n                        </td>\n                    </tr>\n                </tbody>\n                <tfoot v-if=\"defaultedOptions.displayFooter\">\n                    <th v-for=\"column in columns\" :key=\"column.path || column.title\" :class=\"{[column.headingClass || '']: true}\">\n                        {{ column.title ? column.title : column.path }}\n                    </th>\n                </tfoot>\n            </table>\n\n            <nav aria-label=\"pagination\" :class=\"{[defaultedOptions.classes.pagination]: true}\" role=\"navigation\" v-if=\"defaultedOptions.displayPagination\">\n                <a v-if=\"defaultedOptions.displayPaginationButtons\" :disabled=\"page <= 1\" :class=\"{[defaultedOptions.classes.paginationPrevious]: true}\" @click=\"goToPage(page - 1)\">Previous</a>\n                <a v-if=\"defaultedOptions.displayPaginationButtons\" :disabled=\"page >= lastPage\" :class=\"{[defaultedOptions.classes.paginationNext]: true}\"  @click=\"goToPage(page + 1)\">Next page</a>\n                <ul :class=\"{[defaultedOptions.classes.paginationList]: true}\">\n                    <template v-for=\"pageNumber in pages\">\n                        <li v-if=\"pageNumber === '...'\">\n                            <span :class=\"{[defaultedOptions.classes.paginationEllipsis]: true}\">&hellip;</span>\n                        </li>\n                        <li v-else>\n                            <a \n                                :aria-label=\"'Goto page ' + pageNumber\" \n                                :class=\"{[defaultedOptions.classes.paginationLink]: true, [defaultedOptions.classes.paginationLinkCurrent]: page === pageNumber}\"\n                                @click=\"goToPage(pageNumber)\"\n                                :disabled=\"page === pageNumber\">\n                                {{ pageNumber }}\n                            </a>\n                        </li>\n                    </template>\n                </ul>\n            </nav>\n            \n        </div>\n    "
});

/***/ }),

/***/ "./resources/assets/js/utils/announcement-type-to-modifier-class.js":
/*!**************************************************************************!*\
  !*** ./resources/assets/js/utils/announcement-type-to-modifier-class.js ***!
  \**************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return announcementTypeToModifierClass; });
function announcementTypeToModifierClass(type) {
  switch (type) {
    case 'info':
      return 'is-primary';

    case 'success':
      return 'is-success';

    case 'warning':
      return 'is-warning';

    case 'error':
      return 'is-danger';

    case 'default':
    default:
      return 'is-white';
  }
}

/***/ }),

/***/ "./resources/assets/js/utils/format-month.js":
/*!***************************************************!*\
  !*** ./resources/assets/js/utils/format-month.js ***!
  \***************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return formatMonth; });
function formatMonth(month) {
  var monthNumber = month + 1;
  return monthNumber < 10 ? '0' + String(monthNumber) : String(monthNumber);
}

/***/ }),

/***/ "./resources/assets/js/utils/generate-license.js":
/*!*******************************************************!*\
  !*** ./resources/assets/js/utils/generate-license.js ***!
  \*******************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var randomstring__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! randomstring */ "./node_modules/randomstring/index.js");
/* harmony import */ var randomstring__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(randomstring__WEBPACK_IMPORTED_MODULE_0__);


function generateLicense() {
  return randomstring__WEBPACK_IMPORTED_MODULE_0___default.a.generate({
    length: 32,
    charset: 'alphanumeric'
  });
}

/* harmony default export */ __webpack_exports__["default"] = (generateLicense);

/***/ }),

/***/ "./resources/assets/js/utils/get-nested.js":
/*!*************************************************!*\
  !*** ./resources/assets/js/utils/get-nested.js ***!
  \*************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
function getNested(theObject, path) {
  var separator = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : '.';

  try {
    return path.replace('[', separator).replace(']', '').split(separator).reduce(function (obj, property) {
      return obj[property];
    }, theObject);
  } catch (err) {
    return undefined;
  }
}

/* harmony default export */ __webpack_exports__["default"] = (getNested);

/***/ }),

/***/ "./resources/assets/js/utils/get-pagination-array.js":
/*!***********************************************************!*\
  !*** ./resources/assets/js/utils/get-pagination-array.js ***!
  \***********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
function getPaginationArray(c, m) {
  var current = c,
      last = m,
      delta = 2,
      left = current - delta,
      right = current + delta + 1,
      range = [],
      rangeWithDots = [],
      l;

  for (var i = 1; i <= last; i++) {
    if (i == 1 || i == last || i >= left && i < right) {
      range.push(i);
    }
  }

  for (var _i = 0, _range = range; _i < _range.length; _i++) {
    var _i2 = _range[_i];

    if (l) {
      if (_i2 - l === 2) {
        rangeWithDots.push(l + 1);
      } else if (_i2 - l !== 1) {
        rangeWithDots.push('...');
      }
    }

    rangeWithDots.push(_i2);
    l = _i2;
  }

  return rangeWithDots;
}

/* harmony default export */ __webpack_exports__["default"] = (getPaginationArray);

/***/ }),

/***/ "./resources/assets/js/utils/index.js":
/*!********************************************!*\
  !*** ./resources/assets/js/utils/index.js ***!
  \********************************************/
/*! exports provided: formatMonth, generateLicense, announcementTypeToModifierClass, getPaginationArray, getNested */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _format_month__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./format-month */ "./resources/assets/js/utils/format-month.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "formatMonth", function() { return _format_month__WEBPACK_IMPORTED_MODULE_0__["default"]; });

/* harmony import */ var _generate_license__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./generate-license */ "./resources/assets/js/utils/generate-license.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "generateLicense", function() { return _generate_license__WEBPACK_IMPORTED_MODULE_1__["default"]; });

/* harmony import */ var _announcement_type_to_modifier_class__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./announcement-type-to-modifier-class */ "./resources/assets/js/utils/announcement-type-to-modifier-class.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "announcementTypeToModifierClass", function() { return _announcement_type_to_modifier_class__WEBPACK_IMPORTED_MODULE_2__["default"]; });

/* harmony import */ var _get_pagination_array__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./get-pagination-array */ "./resources/assets/js/utils/get-pagination-array.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "getPaginationArray", function() { return _get_pagination_array__WEBPACK_IMPORTED_MODULE_3__["default"]; });

/* harmony import */ var _get_nested__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./get-nested */ "./resources/assets/js/utils/get-nested.js");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "getNested", function() { return _get_nested__WEBPACK_IMPORTED_MODULE_4__["default"]; });








/***/ }),

/***/ 1:
/*!**********************!*\
  !*** util (ignored) ***!
  \**********************/
/*! no static exports found */
/***/ (function(module, exports) {

/* (ignored) */

/***/ }),

/***/ 2:
/*!**********************!*\
  !*** util (ignored) ***!
  \**********************/
/*! no static exports found */
/***/ (function(module, exports) {

/* (ignored) */

/***/ }),

/***/ 3:
/*!************************!*\
  !*** buffer (ignored) ***!
  \************************/
/*! no static exports found */
/***/ (function(module, exports) {

/* (ignored) */

/***/ }),

/***/ 4:
/*!************************!*\
  !*** crypto (ignored) ***!
  \************************/
/*! no static exports found */
/***/ (function(module, exports) {

/* (ignored) */

/***/ })

}]);