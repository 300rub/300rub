!function ($, ss) {
    'use strict';

    /**
     * Checkbox form
     *
     * @param {Object} options
     */
    ss.forms.Checkbox = function (options) {
        ss.forms.Abstract.call(this, "form-container-checkbox", options);
        this.init();
    };

    /**
     * Checkbox form prototype
     *
     * @type {Object}
     */
    ss.forms.Checkbox.prototype
        = Object.create(ss.forms.Abstract.prototype);

    /**
     * Constructor
     */
    ss.forms.Checkbox.prototype.constructor = ss.forms.Checkbox;

    /**
     * Init
     */
    ss.forms.Checkbox.prototype.init = function () {
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
    ss.forms.Checkbox.prototype.getValue = function () {
        return this.getInstance().is(':checked');
    };
}(window.jQuery, window.ss);
