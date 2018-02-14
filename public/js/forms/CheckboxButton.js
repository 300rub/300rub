!function ($, ss) {
    'use strict';

    /**
     * CheckboxButton form
     *
     * @param {Object} options
     */
    ss.forms.CheckboxButton = function (options) {
        ss.forms.Abstract.call(this, "checkbox-button", options);
        this.init();
    };

    /**
     * CheckboxButton form prototype
     *
     * @type {Object}
     */
    ss.forms.CheckboxButton.prototype
        = Object.create(ss.forms.Abstract.prototype);

    /**
     * Constructor
     */
    ss.forms.CheckboxButton.prototype.constructor
        = ss.forms.CheckboxButton;

    /**
     * Init
     */
    ss.forms.CheckboxButton.prototype.init = function () {
        var t = this;

        if (t.getOption("value") === true) {
            t.getInstance().attr("checked", "checked");
        }

        var iconElement = t.getForm().find(".icon");
        var iconValue = t.getOption("icon");
        if (iconValue !== null) {
            iconElement.addClass(iconValue);
        } else {
            iconElement.remove();
        }

        var labelElement = t.getForm().find(".label");
        var labelValue = t.getOption("icon");
        if (labelValue !== null) {
            labelElement.text(labelValue);
        } else {
            labelElement.remove();
        }

        var onCheck = t.getOption("onCheck");
        if ($.type(onCheck) === "function") {
            t.getInstance().on(
                "change",
                function () {
                    if (this.checked === true) {
                        onCheck();
                    }
                }
            );
        }

        var onUnCheck = t.getOption("onUnCheck");
        if ($.type(onUnCheck) === "function") {
            t.getInstance().on(
                "change",
                function () {
                    if (this.checked === false) {
                        onUnCheck();
                    }
                }
            );
        }
    };

    /**
     * Gets value
     *
     * @returns {Boolean}
     */
    ss.forms.CheckboxButton.prototype.getValue = function () {
        return this.getInstance().is(':checked');
    };
}(window.jQuery, window.ss);
