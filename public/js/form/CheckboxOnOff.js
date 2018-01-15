!function ($, TestS) {
    'use strict';

    /**
     * CheckboxButton form
     *
     * @param {Object} options
     */
    TestS.Form.CheckboxOnOff = function (options) {
        TestS.Form.Abstract.call(
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
    TestS.Form.CheckboxOnOff.prototype
        = Object.create(TestS.Form.Abstract.prototype);

    /**
     * Constructor
     */
    TestS.Form.CheckboxOnOff.prototype.constructor
        = TestS.Form.CheckboxOnOff;

    /**
     * Init
     */
    TestS.Form.CheckboxOnOff.prototype.init = function () {
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
    TestS.Form.CheckboxOnOff.prototype.getValue = function () {
        return this.getInstance().is(':checked');
    };
}(window.jQuery, window.TestS);
