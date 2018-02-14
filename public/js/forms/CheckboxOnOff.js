!function ($, ss) {
    'use strict';

    /**
     * CheckboxButton form
     *
     * @param {Object} options
     */
    ss.forms.CheckboxOnOff = function (options) {
        ss.forms.Abstract.call(
            this,
            "form-container-checkbox-on-off",
            options
        );
        this.init();
    };

    /**
     * CheckboxOnOff form prototype
     *
     * @type {Object}
     */
    ss.forms.CheckboxOnOff.prototype
        = Object.create(ss.forms.Abstract.prototype);

    /**
     * Constructor
     */
    ss.forms.CheckboxOnOff.prototype.constructor
        = ss.forms.CheckboxOnOff;

    /**
     * Init
     */
    ss.forms.CheckboxOnOff.prototype.init = function () {
        var t = this;

        if (t.getOption("value") === true) {
            t.getInstance().attr("checked", "checked");
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
    ss.forms.CheckboxOnOff.prototype.getValue = function () {
        return this.getInstance().is(':checked');
    };
}(window.jQuery, window.ss);
