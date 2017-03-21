!function ($, TestS) {
    'use strict';

    /**
     * Gets text form
     *
     * @param {Object} [options]
     *
     * @type {Object}
     *
     * @returns {Object}
     */
    TestS.Form = function (options) {
        this._options = $.extend({}, options);
        this.init();
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    TestS.Form.prototype = {

        /**
         * Options
         *
         * @var {Object}
         */
        _options: {},

        /**
         * Instance
         *
         * @var {Object}
         */
        $_instance: null,

        /**
         * Init
         */
        init: function () {
            switch (this._options.type) {
                case "text":
                    this.setText();
                    break;
                case "password":
                    this.setPassword();
                    break;
                case "checkbox":
                    this.setCheckbox();
                    break;
                case "button":
                    this.setButton();
                    break;
                default:
                    return this;
            }

            this
                ._setName()
                ._setPlaceholder()
                ._setClass()
                ._setOnBlur()
                ._appendTo();
        },

        /**
         * Gets instance
         *
         * @returns {Object}
         */
        getInstance: function () {
            return this.$_instance;
        },

        /**
         * Sets name
         *
         * @returns {TestS.Form}
         *
         * @private
         */
        _setName: function() {
            if (this._options.name === undefined) {
                return this;
            }

            if (this.$_instance.hasClass("form-instance")) {
                this.$_instance.attr("name", this._options.name);
                return this;
            }

            this.$_instance.find(".form-instance").attr("name", this._options.name);
            return this;
        },

        /**
         * Sets name
         *
         * @returns {TestS.Form}
         *
         * @private
         */
        _setPlaceholder: function() {
            if (this._options.placeholder === undefined) {
                return this;
            }

            this.$_instance.attr("placeholder", this._options.placeholder);
            return this;
        },

        /**
         * Sets class
         *
         * @returns {TestS.Form}
         *
         * @private
         */
        _setClass: function() {
            if (this._options.class === undefined) {
                return this;
            }

            this.$_instance.addClass(this._options.class);
            return this;
        },

        /**
         * Sets on blur event
         *
         * @returns {TestS.Form}
         *
         * @private
         */
        _setOnBlur: function() {
            if (this._options.validation === undefined) {
                return this;
            }

            this.$_instance.on("blur", $.proxy(function() {
                var validator = new TestS.Validator(this.getValue(), this._options.validation);
                var errors = validator.getErrors();
                console.log(errors);
            }, this));

            return this;
        },

        /**
         * Appends to
         *
         * @returns {TestS.Form}
         *
         * @private
         */
        _appendTo: function() {
            if (this._options.appendTo === undefined) {
                return this;
            }

            this.$_instance.appendTo(this._options.appendTo);
            return this;
        },

        /**
         * Gets value
         *
         * @returns {mixed}
         */
        getValue: function() {
            return this.$_instance.val();
        }
    };
}(window.jQuery, window.TestS);