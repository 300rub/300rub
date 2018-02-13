!function ($, Ss) {
    'use strict';

    /**
     * Checkbox form
     *
     * @param {Object} options
     */
    Ss.Form.Checkbox = function (options) {
        Ss.Form.Abstract.call(this, "form-container-checkbox", options);
        this.init();
    };

    /**
     * Checkbox form prototype
     *
     * @type {Object}
     */
    Ss.Form.Checkbox.prototype
        = Object.create(Ss.Form.Abstract.prototype);

    /**
     * Constructor
     */
    Ss.Form.Checkbox.prototype.constructor = Ss.Form.Checkbox;

    /**
     * Init
     */
    Ss.Form.Checkbox.prototype.init = function () {
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
    Ss.Form.Checkbox.prototype.getValue = function () {
        return this.getInstance().is(':checked');
    };
}(window.jQuery, window.Ss);
