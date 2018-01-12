!function ($, TestS) {
    'use strict';

    /**
     * Abstract form object
     *
     * @constructor
     */
    TestS.Form = function () {
    };

    /**
     * Abstract form prototype
     *
     * @type {Object}
     */
    TestS.Form.prototype = {

        /**
         * Form
         *
         * @var {Object}
         */
        _form: null,

        /**
         * Form instance
         *
         * @var {Object}
         */
        _instance: null,

        /**
         * Options
         *
         * @var {Object}
         */
        _options: {},

        /**
         * Init
         *
         * @param {String} name
         * @param {Object} options
         */
        set: function (name, options) {
            this._form = TestS.Template.get(name);
            this._instance = this._form.find(".form-instance");
            this._options = $.extend({}, options);

            this
                ._setName()
                ._setLabel()
                ._setPlaceholder()
                ._setCssClass()
                ._setOnBlur()
                ._appendTo();
        },

        /**
         * Gets form
         *
         * @returns {Object}
         */
        getForm: function () {
            return this._form;
        },

        /**
         * Gets form instance
         *
         * @returns {Object}
         */
        getInstance: function () {
            return this._instance;
        },

        /**
         * Gets option
         *
         * @param {String} option
         *
         * @returns {String|mixed}
         */
        getOption: function (option) {
            if (this._options[option] === undefined) {
                return null;
            }

            return this._options[option];
        },

        /**
         * Sets name
         *
         * @returns {TestS.Form}
         *
         * @private
         */
        _setName: function () {
            var name = this.getOption("name");
            if (name === null) {
                return this;
            }

            this._instance.attr("name", name);
            return this;
        },

        /**
         * Gets the name
         *
         * @returns {String}
         */
        getName: function () {
            return this._instance.attr("name");
        },

        /**
         * Sets label
         *
         * @returns {TestS.Form}
         *
         * @private
         */
        _setLabel: function () {
            var label = this.getOption("label");
            if (label === null) {
                return this;
            }

            this._form.find(".label-text").text(label);
            return this;
        },

        /**
         * Sets placeholder
         *
         * @returns {TestS.Form}
         *
         * @private
         */
        _setPlaceholder: function () {
            var placeholder = this.getOption("placeholder");
            if (placeholder === null) {
                return this;
            }

            this._instance.attr("placeholder", placeholder);
            return this;
        },

        /**
         * Sets CSS class
         *
         * @returns {TestS.Form}
         *
         * @private
         */
        _setCssClass: function () {
            var css = this.getOption("css");
            if (css === null) {
                return this;
            }

            this._form.addClass(css);
            return this;
        },

        /**
         * Sets on blur event (validation)
         *
         * @returns {TestS.Form}
         *
         * @private
         */
        _setOnBlur: function () {
            this._instance.on("blur", $.proxy(this.validate, this));
            return this;
        },

        /**
         * Validates the form
         *
         * @returns {TestS.Form}
         */
        validate: function () {
            this._form.removeClass("error");

            var validation = this.getOption("validation");
            if ($.type(validation) !== "object"
                || validation.length === 0
            ) {
                return this;
            }

            var validator = new TestS.Validator(this.getValue(), validation);
            var errors = validator.getErrors();
            if (errors.length > 0) {
                this.setError(errors[0]);
            } else {
                this._form.removeClass("error");
                this._form.find("span.error").text("");
            }

            return this;
        },

        /**
         * Sets value
         *
         * @param {mixed} value
         *
         * @returns {TestS.Form}
         */
        setValue: function (value) {
            this._instance.val(value);
            return this;
        },

        /**
         * Gets value
         *
         * @returns {mixed}
         */
        getValue: function () {
            return this._instance.val();
        },

        /**
         * Sets error
         *
         * @param {String} error
         *
         * @returns {TestS.Form}
         */
        setError: function (error) {
            this._form.addClass("error");
            this._form.find("span.error").text(error);

            return this;
        },

        /**
         * Appends to
         *
         * @returns {TestS.Form}
         *
         * @private
         */
        _appendTo: function () {
            var appendTo = this.getOption("appendTo");
            if (appendTo === null) {
                return this;
            }

            this._form.appendTo(appendTo);
            return this;
        },

        /**
         * Does focus on instance
         *
         * @returns {TestS.Form}
         */
        focus: function () {
            this._instance.focus();
            return this;
        },

        /**
         * Scrolls container to the form
         *
         * @returns {TestS.Form}
         */
        scrollTo: function () {
            var scrollContainer = this._instance.closest(".scroll-container");
            var scrollTop = this._instance.position().top;
            var scrollTopContainer
                = scrollContainer.find("div:first-child").position().top;
            scrollContainer.scrollTop(scrollTop - scrollTopContainer);
            return this;
        }
    };
}(window.jQuery, window.TestS);
