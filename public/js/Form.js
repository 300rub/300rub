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
    TestS.FormOld = function (options) {
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
    TestS.FormOld.prototype = {
        /**
         * Init
         */
        init: function () {
            switch (this._options.type) {
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

                    if (object["style"] !== undefined) {
                        $option.attr("style", object["style"]);
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
                        TestS.Library.getIntVal($(this).val())
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
                name = "radio" + TestS.Library.getUniqueId();
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
         * Gets parsed value
         *
         * @returns {mixed}
         */
        getParsedValue: function () {
            var value;

            switch (this._options.type) {
                case "spinner":
                    value = TestS.Library.getIntVal(this._instance.val());
                    break;
                default:
                    value = this._instance.val();
                    break;
            }

            return value;
        }
    };
}(window.jQuery, window.TestS);