!function ($, Ss) {
    'use strict';

    /**
     * CheckboxButton form
     *
     * @param {Object} options
     */
    Ss.Form.CheckboxButton = function (options) {
        Ss.Form.Abstract.call(this, "checkbox-button", options);
        this.init();
    };

    /**
     * CheckboxButton form prototype
     *
     * @type {Object}
     */
    Ss.Form.CheckboxButton.prototype
        = Object.create(Ss.Form.Abstract.prototype);

    /**
     * Constructor
     */
    Ss.Form.CheckboxButton.prototype.constructor
        = Ss.Form.CheckboxButton;

    /**
     * Init
     */
    Ss.Form.CheckboxButton.prototype.init = function () {
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
    Ss.Form.CheckboxButton.prototype.getValue = function () {
        return this.getInstance().is(':checked');
    };
}(window.jQuery, window.Ss);
