!function ($, TestS) {
    'use strict';

    /**
     * Gets text form
     *
     * @param {Object} [_options]
     *
     * @type {Object}
     *
     * @returns {Object}
     */
    TestS.Form = function (_options) {
        this._options = $.extend({}, _options);
        this.init();
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    TestS.Form.prototype = {

        /**
         * _options
         *
         * @var {Object}
         */
        _options: {},

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
            switch (this._options.type) {
                case "text":
                    this._setTextForm();
                    break;
                case "password":
                    this._setPasswordForm();
                    break;
                case "checkbox":
                    this._setCheckboxForm();
                    break;
                case "button":
                    this._setButtonForm();
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
         * Sets text form
         *
         * @private
         */
        _setTextForm: function () {
            if (this._options.label !== undefined) {
                this.$_form = TestS.Template.get("form-container-text-label");
            } else {
                this.$_form = TestS.Template.get("form-container-text");
            }
        },

        /**
         * Sets password form
         *
         * @private
         */
        _setPasswordForm: function () {
            this.$_form = TestS.Template.get("form-container-password");
        },

        /**
         * Sets checkbox form
         *
         * @private
         */
        _setCheckboxForm: function () {
            this.$_form = TestS.Template.get("form-container-checkbox");
            if (this._options.label !== undefined) {
                this.$_form.find(".label-text").text(this._options.label);
            }
        },

        /**
         * Sets button form
         *
         * @private
         */
        _setButtonForm: function() {
            this.$_form = TestS.Template.get("form-container-button");
            if (this._options.icon !== undefined) {
                this.$_form.find("button i").addClass(this._options.icon);
            }
            if (this._options.label !== undefined) {
                this.$_form.find("button span").text(this._options.label);
            }
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
            if (this._options.name === undefined) {
                return this;
            }

            this.$_form.find(".form-instance").attr("name", this._options.name);
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

            this.$_form.find(".form-instance").attr("placeholder", this._options.placeholder);
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

            this.$_form.addClass(this._options.class);
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

            this.$_form.on("blur", $.proxy(function() {
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

            this.$_form.appendTo(this._options.appendTo);
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