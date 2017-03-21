!function ($, TestS) {
    'use strict';

    /**
     * Validator
     *
     * @param {string} [value]
     * @param {Object} [rules]
     *
     * @type {Object}
     */
    TestS.Validator = function (value, rules) {
        this._value = value;
        this._rules = rules;
        this.init();
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    TestS.Validator.prototype = {

        /**
         * Value
         *
         * @var {string}
         */
        _value: "",

        /**
         * Rules
         *
         * @var {Object}
         */
        _rules: {},

        /**
         * Errors
         *
         * @var {Array}
         */
        _errors: [],

        /**
         * Init
         */
        init: function () {
            this._errors = [];

            $.each(this._rules, $.proxy(function(key, value) {
                switch (key) {
                    case "required":
                        this._checkRequired();
                        break;
                    case "max":
                        this._checkMaxLength(value);
                        break;
                    case "min":
                        this._checkMinLength(value);
                        break;
                    case "latinDigitUnderscoreHyphen":
                        this._checkLatinDigitUnderscoreHyphen();
                        break;
                }
            }, this));
        },

        /**
         * Adds error
         *
         * @param {String} [error]
         *
         * @private
         */
        _addError: function (error) {
            this._errors.push(error);
        },

        /**
         * Gets errors
         *
         * @returns {Array}
         */
        getErrors: function() {
            return this._errors;
        },

        /**
         * Verifies required
         *
         * @private
         */
        _checkRequired: function() {
            if ($.trim(this._value) === "") {
                this._addError("required");
            }
        },

        /**
         * Verifies string length for max value
         *
         * @param {Integer} [max]
         *
         * @private
         */
        _checkMaxLength: function(max) {
            if ($.trim(this._value).length > parseInt(max)) {
                this._addError("max");
            }
        },

        /**
         * Verifies string length for min value
         *
         * @param {Integer} [min]
         *
         * @private
         */
        _checkMinLength: function(min) {
            if ($.trim(this._value).length < parseInt(min)) {
                this._addError("min");
            }
        },

        /**
         * Verifies regex: latin, digit, underscore, hyphen
         *
         * @private
         */
        _checkLatinDigitUnderscoreHyphen: function() {
            var pattern = new RegExp("^[0-9a-z-_]+$");
            if (!pattern.test($.trim(this._value))) {
                this._addError("latinDigitUnderscoreHyphen");
            }
        }
    };
}(window.jQuery, window.TestS);