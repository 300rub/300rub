!function ($, ss) {
    'use strict';

    /**
     * Validator
     *
     * @param {string} [value]
     * @param {Object} [rules]
     *
     * @type {Object}
     */
    ss.components.Validator = function (value, rules) {
        this._value = value;
        this._rules = $.extend({}, rules);
        this._errors = [];

        this.init();
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    ss.components.Validator.prototype = {

        /**
         * Constructor
         */
        constructor: ss.components.Validator,

        /**
         * Init
         */
        init: function () {
            this._errors = [];

            $.each(
                this._rules,
                $.proxy(
                    function (key, value) {
                        switch (key) {
                            case "required":
                                this._checkRequired();
                                break;
                            case "maxLength":
                                this._checkMaxLength(value);
                                break;
                            case "minLength":
                                this._checkMinLength(value);
                                break;
                            case "latinDigitUnderscoreHyphen":
                                this._checkLatinDigitUnderscoreHyphen();
                                break;
                            case "email":
                                this._checkEmail();
                                break;
                        }
                    },
                    this
                )
            );
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
        getErrors: function () {
            return this._errors;
        },

        /**
         * Verifies required
         *
         * @private
         */
        _checkRequired: function () {
            if ($.trim(this._value) === "") {
                this._addError(
                    ss.components.Error.get("required")
                );
            }
        },

        /**
         * Verifies string length for max value
         *
         * @param {int} [max]
         *
         * @private
         */
        _checkMaxLength: function (max) {
            if ($.trim(this._value).length > parseInt(max, 10)) {
                this._addError(
                    ss.components.Error.get("maxLength")
                );
            }
        },

        /**
         * Verifies string length for min value
         *
         * @param {int} [min]
         *
         * @private
         */
        _checkMinLength: function (min) {
            if ($.trim(this._value).length < parseInt(min, 10)) {
                this._addError(
                    ss.components.Error.get("minLength")
                );
            }
        },

        /**
         * Verifies regex: latin, digit, underscore, hyphen
         *
         * @private
         */
        _checkLatinDigitUnderscoreHyphen: function () {
            var pattern = new RegExp("^[0-9a-z-_]+$");
            if (!pattern.test($.trim(this._value))) {
                this._addError(
                    ss.components.Error.get("latinDigitUnderscoreHyphen")
                );
            }
        },

        /**
         * Checks email
         *
         * @private
         */
        _checkEmail: function () {
            var pattern = new RegExp(
                "^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$"
            );
            if (!pattern.test($.trim(this._value))) {
                this._addError(
                    ss.components.Error.get("email")
                );
            }
        }
    };
}(window.jQuery, window.ss);
