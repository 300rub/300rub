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
        this.$_form = null;
        this.$_instance = null;

        this.init();
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    TestS.Form.prototype = {
        /**
         * Init
         */
        init: function () {
            switch (this._options.type) {
                case "text":
                    this._setTextForm();
                    break;
                case "hidden":
                    this._setHiddenForm();
                    break;
                case "password":
                    this._setPasswordForm();
                    break;
                case "checkbox":
                    this._setCheckboxForm();
                    break;
                case "checkboxButton":
                    this._setCheckboxButton();
                    break;
                case "checkboxOnOff":
                    this._setCheckboxOnOffForm();
                    break;
                case "radioButtons":
                    this._setRadioButtonsForm();
                    break;
                case "select":
                    this._setSelectForm();
                    break;
                case "color":
                    this._setColor();
                    break;
                case "button":
                    this._setButtonForm();
                    break;
                case "spinner":
                    this._setSpinner();
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
            var t = this;

            t.$_form = TestS.Template.get("form-container-select");

            var $instance = t.getFormInstance();
            var $optionTemplate = t.$_form.find(".option-template");

            if ($.type(t._options.list) === "array") {
                $.each(t._options.list, function(i, object) {
                    var $option = $optionTemplate.clone()
                        .attr("value", object["key"])
                        .text(object["value"]);

                    if (object["class"] !== undefined) {
                        $option.addClass(object["class"]);
                    }

                    $option.appendTo($instance);
                });
            }
            $optionTemplate.remove();

            if (t._options.value !== undefined) {
                $instance.val(t._options.value);
            }

            if ($.type(t._options.onChange) === "function") {
                $instance.on("change", function() {
                    t._options.onChange(
                        TestS.getIntVal($(this).val())
                    );
                });
            }
        },

        /**
         * Sets color form
         *
         * @private
         */
        _setColor: function () {
            this.$_form = TestS.Template.get("color-picker-container");

            var title = "";
            if (this._options["title"] !== undefined) {
                title = this._options["title"];
            }

            if (this._options["value"] !== undefined) {
                this.getFormInstance().val(this._options["value"]);
            }

            var $iconBefore = this.$_form.find(".icon-before");
            if (this._options["iconBefore"] !== undefined) {
                $iconBefore.addClass(this._options["iconBefore"]);
            } else {
                $iconBefore.remove();
            }

            var $label = this.$_form.find(".label-text");
            if (this._options["label"] !== undefined) {
                $label.text(this._options["label"]);
            } else {
                $label.remove();
            }

            this.getFormInstance().colorpicker({
                parts: 'full',
                alpha: true,
                showOn: 'button',
                buttonColorize: true,
                buttonClass: "color-button",
                buttonImage: "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7",
                buttonImageOnly: true,
                showNoneButton: true,
                title: title,
                colorFormat: "RGBA",
                select: $.proxy(function (event, data) {
                    if ($.type(this._options["callback"]) === "function") {
                        this._options["callback"](data.formatted);
                    }
                }, this)
            });
        },

        /**
         * Sets spinner
         *
         * @private
         */
        _setSpinner: function () {
            var t = this;

            this.$_form = TestS.Template.get("form-spinner");

            this._allowOnlyNumbers();

            if (this._options.value !== undefined) {
                this.getFormInstance().val(
                    TestS.getIntVal(this._options.value)
                );
            }

            if ($.type(this._options.callback) === "function") {
                this.getFormInstance().on("keyup", function() {
                    t._options.callback(
                        TestS.getIntVal($(this).val())
                    )
                });
            }

            var $iconBefore = this.$_form.find(".icon-before");
            if (this._options["iconBefore"] !== undefined) {
                $iconBefore.addClass(this._options["iconBefore"]);
            } else {
                $iconBefore.remove();
            }

            var min = -999999;
            if (this._options["min"] !== undefined) {
                min = this._options["min"];
            }

            this.getFormInstance().spinner({
                min: min,
                spin: function (event, ui) {
                    if ($.type(t._options.callback) === "function") {
                        t._options.callback(
                            TestS.getIntVal(ui.value)
                        );
                    }
                },
                icons: {
                    up: "fa fa-chevron-up gray-blue-link",
                    down: "fa fa-chevron-down gray-blue-link"
                }
            });
        },

        /**
         * Allows only numbers
         *
         * Allow: Ctrl+A/C/V/X, Command+A/C/V/X
         * Allow: home, end, left, right, down, up
         * Ensure that it is a number and stop the keypress
         *
         * @returns {TestS.Form}
         *
         * @private
         */
        _allowOnlyNumbers: function() {
            this.getFormInstance().on("keydown", function(e) {
                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13]) !== -1
                    || (
                        (e.ctrlKey === true || e.metaKey === true)
                        && (e.keyCode == 65 || e.keyCode == 67 || e.keyCode == 86 || e.keyCode == 88)
                    )
                    || (e.keyCode >= 35 && e.keyCode <= 40)
                ) {
                    return null;
                }

                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57))
                    && (e.keyCode < 96 || e.keyCode > 105)
                ) {
                    return false;
                }
            });

            return this;
        },

        /**
         * Sets text form
         *
         * @private
         */
        _setTextForm: function () {
            this.$_form = TestS.Template.get("form-container-text");

            if (this._options.value !== undefined) {
                this.getFormInstance().val(this._options.value);
            }
        },

        /**
         * Sets hidden form
         *
         * @private
         */
        _setHiddenForm: function () {
            this.$_form = TestS.Template.get("form-container-hidden");

            if (this._options.value !== undefined) {
                this.getFormInstance().val(this._options.value);
            }
        },

        /**
         * Sets password form
         *
         * @private
         */
        _setPasswordForm: function () {
            this.$_form = TestS.Template.get("form-container-password");
            this.getFormInstance().val("");
        },

        /**
         * Sets checkbox form
         *
         * @private
         */
        _setCheckboxForm: function () {
            var t = this;

            t.$_form = TestS.Template.get("form-container-checkbox");

            if (t._options["value"] === true) {
                t.getFormInstance().attr("checked", "checked");
            }

            if ($.type(t._options["onCheck"]) === "function") {
                t.getFormInstance().on("change", function() {
                    if (this.checked) {
                        t._options.onCheck();
                    }
                });
            }

            if ($.type(t._options["onUnCheck"]) === "function") {
                t.getFormInstance().on("change", function() {
                    if (!this.checked) {
                        t._options.onUnCheck();
                    }
                });
            }
        },

        /**
         * Sets checkbox button
         *
         * @private
         */
        _setCheckboxButton: function () {
            var t = this;

            t.$_form = TestS.Template.get("checkbox-button");

            if (t._options["value"] === true) {
                t.getFormInstance().attr("checked", "checked");
            }

            var $icon = t.getFormInstance().find(".icon");
            if (t._options["icon"] !== undefined) {
                $icon.addClass(t._options["icon"]);
            } else {
                $icon.remove();
            }

            var $label = t.getFormInstance().find(".label");
            if (t._options["label"] !== undefined) {
                $label.text(t._options["label"]);
            } else {
                $label.remove();
            }

            if ($.type(t._options["onCheck"]) === "function") {
                t.getFormInstance().on("change", function() {
                    if (this.checked) {
                        t._options.onCheck();
                    }
                });
            }

            if ($.type(t._options["onUnCheck"]) === "function") {
                t.getFormInstance().on("change", function() {
                    if (!this.checked) {
                        t._options.onUnCheck();
                    }
                });
            }
        },

        /**
         * Sets checkbox On / Off form
         *
         * @private
         */
        _setCheckboxOnOffForm: function () {
            var t = this;

            t.$_form = TestS.Template.get("form-container-checkbox-on-off");

            if (t._options["value"] === true) {
                t.getFormInstance().attr("checked", "checked");
            }

            if ($.type(t._options["onCheck"]) === "function") {
                t.getFormInstance().on("change", function() {
                    if (this.checked) {
                        t._options.onCheck();
                    }
                });
            }

            if ($.type(t._options["onUnCheck"]) === "function") {
                t.getFormInstance().on("change", function() {
                    if (!this.checked) {
                        t._options.onUnCheck();
                    }
                });
            }
        },

        /**
         * Sets radio form
         *
         * @returns {TestS.Form}
         *
         * @private
         */
        _setRadioButtonsForm: function () {
            var t = this;

            t.$_form = TestS.Template.get("form-container-radio-buttons");

            if ($.type(t._options["data"]) !== "array") {
                return t;
            }

            var name;
            if (t._options["name"] === undefined) {
                name = "radio" + TestS.getUniqueId();
            } else {
                name = t._options["name"];
            }

            var $label = t.$_form.find(".label-text");
            if (t._options["label"] !== undefined) {
                $label.text(t._options["label"]);
            } else {
                $label.remove();
            }

            var $radioButtons = t.$_form.find(".radio-buttons");

            $.each(t._options["data"], function(i, data) {
                if ($.type(data) !== "object"
                    || data["value"] === undefined
                ) {
                    return false;
                }

                var $item = TestS.Template.get("radio-button-item");

                var $icon = $item.find(".label-icon");
                if (data["icon"] !== undefined) {
                    $icon.addClass(data["icon"]);
                } else {
                    $icon.remove();
                }

                var $label = $item.find(".label");
                if (data["label"] !== undefined) {
                    $label.text(data["label"]);
                } else {
                    $label.remove();
                }

                if (data["class"] !== undefined) {
                    $item.addClass(data["class"]);
                }

                var $formInstance = $item.find(".form-instance");
                $formInstance.val(data["value"]);
                $formInstance.attr("name", name);

                if ((t._options["value"] === undefined && i === 0)
                    || t._options["value"] !== undefined && t._options["value"] === data["value"]
                ) {
                    $formInstance.attr("checked", true);
                }

                $radioButtons.append($item);
            });

            if ($.type(t._options["onChange"]) === "function") {
                t.getFormInstance().on("change", function () {
                    t._options["onChange"]($(this).val());
                });
            }

            return this;
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
            this.getFormInstance().focus();
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

                    var data = this._parseFormData($.extend({}, flattenData));

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

                        if (ajax["data"] !== undefined
                            && $.type(ajax["data"]["data"]) === "function"
                        ) {
                            ajax["data"]["data"] = this._parseFormData($.extend({}, ajax["data"]["data"]()));
                        }

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
         * Parses form data
         *
         * @param {Object} data
         *
         * @return {Object}
         *
         * @private
         */
        _parseFormData: function(data) {
            var helpObject = {};
            var object = {};
            var t = this;

            $.each(data, function (fullFieldName, value) {
                if (fullFieldName.indexOf(".") !== -1) {
                    var arr = fullFieldName.split(".");
                    var alias = arr.shift();
                    var field = arr.join(".");
                    if (helpObject[alias] === undefined) {
                        helpObject[alias] = {};
                    }
                    helpObject[alias][field] = value;
                } else {
                    object[fullFieldName] = value;
                }
            });

            $.each(helpObject, function (key, value) {
                object[key] = t._parseFormData(value);
            });

            return object;
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
         * Gets form instance
         *
         * @returns {Object}
         */
        getFormInstance: function () {
            if (this.$_instance === null) {
                this.$_instance = this.getInstance().find(".form-instance");
            }

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

            this.getFormInstance().attr("name", this._options.name);
            return this;
        },

        /**
         * Gets the name
         *
         * @returns {String}
         */
        getName: function() {
            return this.getFormInstance().attr("name");
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

            this.getFormInstance().attr("placeholder", this._options.placeholder);
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
            this.getFormInstance().on("blur", $.proxy(this.validate, this));
            return this;
        },

        /**
         * Validates the form
         *
         * @returns {TestS.Form}
         */
        validate: function() {
            this.$_form.removeClass("error");

            if ($.type(this._options.validation) !== "object" || this._options.validation.length === 0) {
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
            return this.getFormInstance().val();
        },

        /**
         * Gets parsed value
         *
         * @returns {mixed}
         */
        getParsedValue: function () {
            var $formInstance = this.getFormInstance();
            var value;

            switch (this._options.type) {
                case "password":
                    value = md5($formInstance.val() + "(^_^)");
                    break;
                case "checkbox":
                    value = $formInstance.is(':checked');
                    break;
                case "checkboxButton":
                    value = $formInstance.is(':checked');
                    break;
                case "spinner":
                    value = TestS.getIntVal($formInstance.val());
                    break;
                default:
                    value = $formInstance.val();
                    break;
            }

            return value;
        },

        /**
         * Sets value
         *
         * @param {mixed} value
         *
         * @returns {TestS.Form}
         */
        setValue: function(value) {
            this.getFormInstance().val(value);
            return this;
        }
    };
}(window.jQuery, window.TestS);