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
                case "select":
                    this._setSelectForm();
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
         * Sets select form
         *
         * @private
         */
        _setSelectForm: function () {
            this.$_form = TestS.Template.get("form-container-select");

            var $instance = this.$_form.find(".form-instance");
            var $optionTemplate = this.$_form.find(".option-template");

            if ($.type(this._options.list) === "array") {
                $.each(this._options.list, function(i, object) {
                    $optionTemplate.clone()
                        .attr("value", object.key)
                        .text(object.value)
                        .appendTo($instance);
                });
            }
            $optionTemplate.remove();

            if (this._options.value !== undefined) {
                $instance.val(this._options.value);
            }

            if ($.type(this._options.onChange) === "function") {
                if ($.type(this._options.data) === "object") {
                    $instance.on("change", this._options.data, this._options.onChange);
                } else {
                    $instance.on("change", this._options.onChange);
                }
            }
        },

        /**
         * Sets text form
         *
         * @private
         */
        _setTextForm: function () {
            this.$_form = TestS.Template.get("form-container-text");

            if (this._options.value !== undefined) {
                this.$_form.find(".form-instance").val(this._options.value);
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

            if (this._options.value === true) {
                this.$_form.find(".form-instance").attr("checked", "checked");
            }
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
                if ($.type(this._options.confirm) === "object") {
                    var $form = this.$_form;
                    $form.on("click", $.proxy(function(){
                        var $confirmWindow = TestS.Template.get("confirm-window");
                        var $buttons = $confirmWindow.find(".buttons");
                        var $confirmOverlay = TestS.Template.get("confirm-overlay");
                        var $text = $confirmWindow.find(".text");
                        $text.text(this._options.confirm.text);

                        new TestS.Form({
                            type: "button",
                            class: "gray-button button-small",
                            icon: this._options.confirm.yes.icon,
                            label: this._options.confirm.yes.label,
                            appendTo: $buttons,
                            ajax: $.extend(
                                this._options.ajax,
                                {
                                    complete: function() {
                                        $confirmWindow.remove();
                                        $confirmOverlay.remove();
                                    }
                                }
                            )
                        });

                        new TestS.Form({
                            type: "button",
                            class: "gray-button button-small",
                            icon: "fa-ban",
                            label: this._options.confirm.no,
                            appendTo: $buttons,
                            onClick: function () {
                                $confirmWindow.remove();
                                $confirmOverlay.remove();
                            }
                        });

                        TestS.append($confirmOverlay);
                        TestS.append($confirmWindow);

                        $confirmOverlay.on("click", function() {
                            $confirmWindow.remove();
                            $confirmOverlay.remove();
                        });

                        var left = $form.offset().left + $form.outerWidth() / 2 - $confirmWindow.outerWidth() / 2;
                        if (left < 0) {
                            left = 0;
                        }

                        var top = $form.offset().top + $form.outerHeight() / 2 - $confirmWindow.outerHeight() / 2;
                        if (top < 0) {
                            top = 0;
                        }

                        $confirmWindow.css({
                            "left": left,
                            "top": top
                        });
                    }, this));
                } else {
                    this.$_form.on("click", $.proxy(function () {
                        var $icon = this.$_form.find(".icons .icon");
                        var $spinner = this.$_form.find(".icons .fa-spin");
                        this.$_form.addClass("disabled");

                        $icon.addClass("hidden");
                        $spinner.removeClass("hidden");

                        var ajax = this._options.ajax;
                        if ($.type(ajax.complete) !== "function") {
                            ajax.complete = $.proxy(function () {
                                $icon.removeClass("hidden");
                                $spinner.addClass("hidden");
                                this.$_form.removeClass("disabled");
                            }, this);
                        }

                        new TestS.Ajax(ajax);
                    }, this));
                }
            }

            if ($.type(this._options.onClick) === "function") {
                if ($.type(this._options.data) === "object") {
                    this.$_form.on("click", this._options.data, this._options.onClick);
                } else {
                    this.$_form.on("click", this._options.onClick);
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