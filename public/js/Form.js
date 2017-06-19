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
                ._setLabel()
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
            this.$_form = TestS.Template.get("form-container-text");
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
        },

        /**
         * Scrolls container to the forms
         *
         * @returns {TestS.Form}
         */
        scrollTo: function() {
            var $scrollContainer = this.getInstance().closest(".scroll-container");
            var scrollTop = this.getInstance().position().top;
            var scrollTopContainer = $scrollContainer.find("div:first-child").position().top;
            $scrollContainer.scrollTop(scrollTop - scrollTopContainer);
            return this;
        },

        /**
         * Does focus on instance
         *
         * @returns {TestS.Form}
         */
        focus: function() {
            this.getInstance().find(".form-instance").focus();
            return this;
        },

        /**
         * Sets button form
         *
         * @private
         */
        _setButtonForm: function() {
            this.$_form = TestS.Template.get("form-button");

            if (this._options.icon !== undefined) {
                this.$_form.find(".icons .icon").addClass(this._options.icon);
            } else {
                this.$_form.find(".icons").remove();
            }

            if ($.type(this._options.forms) === "array") {
                this.$_form.on("click", $.proxy(function() {
                    var flattenData = {};
                    var hasError = false;
                    var isScrolled = false;
                    $.each(this._options.forms, $.proxy(function(i, item) {
                        item.validate();
                        if (item.getInstance().hasClass("error")) {
                            hasError = true;
                            if (isScrolled === false) {
                                isScrolled = true;
                                item.scrollTo().focus();
                            }
                        }
                        flattenData[item.getName()] = item.getParsedValue();
                    }, this));

                    // @TODO get data
                    var data = $.extend({}, flattenData);

                    if (hasError === false
                        && $.type(this._options.ajax) === "object"
                        && !this.$_form.hasClass("disabled")
                    ) {
                        var $icon = this.$_form.find(".icons .icon");
                        var $spinner = this.$_form.find(".icons .fa-spin");
                        this.$_form.addClass("disabled");

                        $icon.addClass("hidden");
                        $spinner.removeClass("hidden");

                        var ajax = this._options.ajax;
                        ajax.data.data = data;
                        ajax.complete = $.proxy(function() {
                            $icon.removeClass("hidden");
                            $spinner.addClass("hidden");
                            this.$_form. removeClass("disabled");
                        }, this);

                        new TestS.Ajax(ajax);
                    }
                }, this));
            } else if ($.type(this._options.ajax) === "object"
                && !this.$_form.hasClass("disabled")
            ) {
                this.$_form.on("click", $.proxy(function() {
                    var $icon = this.$_form.find(".icons .icon");
                    var $spinner = this.$_form.find(".icons .fa-spin");
                    this.$_form.addClass("disabled");

                    $icon.addClass("hidden");
                    $spinner.removeClass("hidden");

                    var ajax = this._options.ajax;
                    ajax.complete = $.proxy(function() {
                        $icon.removeClass("hidden");
                        $spinner.addClass("hidden");
                        this.$_form. removeClass("disabled");
                    }, this);

                    new TestS.Ajax(ajax);
                }, this));
            }

            if ($.type(this._options.onClick) === "function") {
                if ($.type("confirm") === "object") {
                    
                } else {
                    if ($.type(this._options.data) === "object") {
                        this.$_form.on("click", this._options.data, this._options.onClick);
                    } else {
                        this.$_form.on("click", this._options.onClick);
                    }
                }
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

            this.getInstance().find(".form-instance").attr("name", this._options.name);
            return this;
        },

        /**
         * Gets the name
         *
         * @returns {String}
         */
        getName: function() {
            return this.$_form.find(".form-instance").attr("name");
        },

        /**
         * Sets label
         *
         * @returns {TestS.Form}
         *
         * @private
         */
        _setLabel: function() {
            if (this._options.label === undefined) {
                return this;
            }

            this.$_form.find(".label-text").text(this._options.label);
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
         * Sets on blur event (validation)
         *
         * @returns {TestS.Form}
         *
         * @private
         */
        _setOnBlur: function() {
            this.$_form.find(".form-instance").on("blur", $.proxy(this.validate, this));
            return this;
        },

        /**
         * Validates the form
         *
         * @returns {TestS.Form}
         */
        validate: function() {
            if (this._options.validation === undefined) {
                return this;
            }

            var validator = new TestS.Validator(this.getValue(), this._options.validation);
            var errors = validator.getErrors();
            if (errors.length > 0) {
                this.setError(errors[0]);
            } else {
                this.$_form.removeClass("error");
                this.$_form.find("span.error").text("");
            }

            return this;
        },

        /**
         * Sets error
         *
         * @param {String} error
         *
         * @returns {TestS.Form}
         */
        setError: function(error) {
            this.$_form.addClass("error");
            this.$_form.find("span.error").text(error);

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
            return this.$_form.find(".form-instance").val();
        },

        /**
         * Gets parsed value
         *
         * @returns {mixed}
         */
        getParsedValue: function () {
            var $formInstance = this.$_form.find(".form-instance");
            var value;

            switch (this._options.type) {
                case "password":
                    value = md5($formInstance.val() + "(^_^)");
                    break;
                case "checkbox":
                    value = $formInstance.is(':checked');
                    break;
                default:
                    value = $formInstance.val();
                    break;
            }

            return value;
        }
    };
}(window.jQuery, window.TestS);