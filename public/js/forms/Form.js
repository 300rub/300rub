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
        this.options = $.extend({}, options);
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
        options: {},

        /**
         * Form Instance
         *
         * @var {Object}
         */
        $_form: null,

        /**
         * Init
         */
        init: function () {
            switch (this.options.type) {
                case "text":
                    this.setTextForm();
                    break;
                case "password":
                    this.setPasswordForm();
                    break;
                case "checkbox":
                    this.setCheckboxForm();
                    break;
                case "button":
                    this.setButtonForm();
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
            return this.$_form;
        },

        /**
         * Sets name
         *
         * @returns {TestS.Form}
         *
         * @private
         */
        _setName: function() {
            if (this.options.name === undefined) {
                return this;
            }

            this.$_form.find(".form-instance").attr("name", this.options.name);
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
            if (this.options.placeholder === undefined) {
                return this;
            }

            this.$_form.find(".form-instance").attr("placeholder", this.options.placeholder);
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
            if (this.options.class === undefined) {
                return this;
            }

            this.$_form.addClass(this.options.class);
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
            if (this.options.validation === undefined) {
                return this;
            }

            this.$_form.on("blur", $.proxy(function() {
                var validator = new TestS.Validator(this.getValue(), this.options.validation);
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
            if (this.options.appendTo === undefined) {
                return this;
            }

            this.$_form.appendTo(this.options.appendTo);
            return this;
        },

        /**
         * Gets value
         *
         * @returns {mixed}
         */
        getValue: function() {
            return this.$_form.val();
        }
    };
}(window.jQuery, window.TestS);