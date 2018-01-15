!function ($, TestS) {
    'use strict';

    /**
     * Checkbox form
     *
     * @param {Object} options
     */
    TestS.Form.Checkbox = function (options) {
        TestS.Form.Abstract.call(this, "form-container-checkbox", options);
        this.init();
    };

    /**
     * Checkbox form prototype
     *
     * @type {Object}
     */
    TestS.Form.Checkbox.prototype
        = Object.create(TestS.Form.Abstract.prototype);

    /**
     * Constructor
     */
    TestS.Form.Checkbox.prototype.constructor = TestS.Form.Checkbox;

    /**
     * Init
     */
    TestS.Form.Checkbox.prototype.init = function () {
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
    TestS.Form.Checkbox.prototype.getValue = function () {
        return this.getInstance().is(':checked');
    };
}(window.jQuery, window.TestS);
