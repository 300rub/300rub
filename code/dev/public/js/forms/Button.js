!function ($, ss) {
    'use strict';

    /**
     * Button form
     *
     * @param {Object} options
     */
    ss.forms.Button = function (options) {
        ss.forms.Abstract.call(this, "form-button", options);
        this.init();
    };

    /**
     * Button form prototype
     *
     * @type {Object}
     */
    ss.forms.Button.prototype = Object.create(ss.forms.Abstract.prototype);

    /**
     * Constructor
     */
    ss.forms.Button.prototype.constructor = ss.forms.Button;

    /**
     * Init
     */
    ss.forms.Button.prototype.init = function () {
        var icon = this.getOption("icon");
        if (icon !== null) {
            this.getForm().find(".icons .icon").addClass(icon);
        } else {
            this.getForm().find(".icons").remove();
        }

        var ajax = this.getOption("ajax");
        if ($.type(this.getOption("forms")) === "array") {
            this.getForm().on("click", $.proxy(this._processForm, this));
        } else if ($.type(ajax) === "object"
            && this.getForm().prop("disabled") === false
        ) {
            if ($.type(this.getOption("confirm")) === "object") {
                this.getForm().on(
                    "click",
                    $.proxy(this._setConfirmWindow, this)
                );
            } else {
                this.getForm().on(
                    "click",
                    $.proxy(this._processAjax, this)
                );
            }
        }

        var onClick = this.getOption("onClick");
        var data = this.getOption("data");
        if ($.type(onClick) === "function") {
            if ($.type(data) === "object") {
                this.getForm().on("click", data, onClick);
            } else {
                this.getForm().on("click", onClick);
            }
        }
    };

    /**
     * Processes AJAX
     *
     * @private
     */
    ss.forms.Button.prototype._processAjax = function () {
        var icon = this.getForm().find(".icons .icon");
        var spinner = this.getForm().find(".icons .fa-spin");
        this.getForm().attr("disabled", true);

        icon.addClass("hidden");
        spinner.removeClass("hidden");

        var ajax = this.getOption("ajax");

        if (ajax.data !== undefined
            && $.type(ajax.data.data) === "function"
        ) {
            ajax.data.data = this._parseFormData(
                $.extend({}, ajax.data.data())
            );
        }

        if ($.type(ajax.complete) !== "function") {
            ajax.complete = $.proxy(
                function () {
                    icon.removeClass("hidden");
                    spinner.addClass("hidden");
                    this.getForm().attr("disabled", false);
                },
                this
            );
        }

        new ss.components.Ajax(ajax);
    };

    /**
     * Sets confirm window
     *
     * @private
     */
    ss.forms.Button.prototype._setConfirmWindow = function () {
        var confirm = this.getOption("confirm");
        var confirmWindow = ss.components.Template.get("confirm-window");
        var buttons = confirmWindow.find(".buttons");
        var confirmOverlay = ss.components.Template.get("confirm-overlay");
        var text = confirmWindow.find(".text");
        text.text(confirm.text);

        new ss.forms.Button(
            {
                css: "btn btn-red btn-small",
                icon: confirm.yes.icon,
                label: confirm.yes.label,
                appendTo: buttons,
                ajax: $.extend(
                    this.getOption("ajax"),
                    {
                        complete: function () {
                            confirmWindow.remove();
                            confirmOverlay.remove();
                        }
                    }
                )
            }
        );

        new ss.forms.Button(
            {
                css: "btn btn-gray btn-small",
                icon: "fas fa-ban",
                label: confirm.no,
                appendTo: buttons,
                onClick: function () {
                    confirmWindow.remove();
                    confirmOverlay.remove();
                }
            }
        );

        ss.system.App.append(confirmOverlay);
        ss.system.App.append(confirmWindow);

        confirmOverlay.on(
            "click",
            function () {
                confirmWindow.remove();
                confirmOverlay.remove();
            }
        );

        var formLeft = this.getForm().offset().left;
        var formLeftCenter = (this.getForm().outerWidth() / 2);
        var confirmLeftCenter = (confirmWindow.outerWidth() / 2);
        var left = formLeft + (formLeftCenter - confirmLeftCenter);
        if (left < 0) {
            left = 0;
        }

        var formTop = this.getForm().offset().top;
        var formTopCenter = (this.getForm().outerHeight() / 2);
        var confirmTopCenter = (confirmWindow.outerWidth() / 2);
        var top = formTop + (formTopCenter - confirmTopCenter);
        if (top < 0) {
            top = 0;
        }

        confirmWindow.css(
            {
                "left": left,
                "top": top
            }
        );
    };

    /**
     * Processes form
     *
     * @return {Boolean}
     *
     * @private
     */
    ss.forms.Button.prototype._processForm = function () {
        var flattenData = {};
        var hasError = false;
        var isScrolled = false;

        $.each(
            this.getOption("forms"),
            $.proxy(
                function (i, item) {
                    item.validate();
                    if (item.getForm().hasClass("error") === true) {
                        hasError = true;
                        if (isScrolled === false) {
                            isScrolled = true;
                            item.scrollTo().focus();
                        }
                    }

                    flattenData[item.getName()] = item.getValue();
                },
                this
            )
        );

        var data = this._parseFormData($.extend({}, flattenData));

        var ajax = this.getOption("ajax");
        if (hasError === true
            || $.type(ajax) !== "object"
            || this.getForm().prop("disabled") === true
        ) {
            return false;
        }

        var icon = this.getForm().find(".icons .icon");
        var spinner = this.getForm().find(".icons .fa-spin");
        this.getForm().attr("disabled", true);

        icon.addClass("hidden");
        spinner.removeClass("hidden");

        if ($.type(ajax.data.data) === "object") {
            ajax.data.data = $.extend(ajax.data.data, data);
        } else {
            ajax.data.data = data;
        }

        ajax.complete = $.proxy(
            function () {
                icon.removeClass("hidden");
                spinner.addClass("hidden");
                this.getForm().attr("disabled", false);
            },
            this
        );

        new ss.components.Ajax(ajax);
        return true;
    };

    /**
     * Parses form data
     *
     * @param {Object} data
     *
     * @return {Object}
     */
    ss.forms.Button.prototype._parseFormData = function (data) {
        var helpObject = {};
        var object = {};

        $.each(
            data,
            function (fullFieldName, value) {
                if (fullFieldName.indexOf(".") === -1) {
                    object[fullFieldName] = value;
                } else {
                    var arr = fullFieldName.split(".");
                    var alias = arr.shift();
                    var field = arr.join(".");
                    if (helpObject[alias] === undefined) {
                        helpObject[alias] = {};
                    }

                    helpObject[alias][field] = value;
                }
            }
        );

        $.each(
            helpObject,
            $.proxy(
                function (key, value) {
                    object[key] = this._parseFormData(value);
                },
                this
            )
        );

        return object;
    };
}(window.jQuery, window.ss);
