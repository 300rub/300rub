!function ($, Ss) {
    'use strict';

    /**
     * CheckboxButton form
     *
     * @param {Object} options
     */
    Ss.Form.CheckboxOnOff = function (options) {
        Ss.Form.Abstract.call(
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
    Ss.Form.CheckboxOnOff.prototype
        = Object.create(Ss.Form.Abstract.prototype);

    /**
     * Constructor
     */
    Ss.Form.CheckboxOnOff.prototype.constructor
        = Ss.Form.CheckboxOnOff;

    /**
     * Init
     */
    Ss.Form.CheckboxOnOff.prototype.init = function () {
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
    Ss.Form.CheckboxOnOff.prototype.getValue = function () {
        return this.getInstance().is(':checked');
    };
}(window.jQuery, window.Ss);
