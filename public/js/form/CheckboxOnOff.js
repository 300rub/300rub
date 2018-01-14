!function ($, TestS) {
    'use strict';

    /**
     * CheckboxButton form
     *
     * @param {Object} options
     */
    TestS.Form.CheckboxOnOff = function (options) {
        this.set("form-container-checkbox-on-off", options);
        this.init();
    };

    /**
     * CheckboxOnOff form prototype
     *
     * @type {Object}
     */
    TestS.Form.CheckboxOnOff.prototype = {

        /**
         * Constructor
         */
        constructor: TestS.Form.CheckboxOnOff,

        /**
         * Init
         */
        init: function () {
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
        },

        /**
         * Gets value
         *
         * @returns {Boolean}
         */
        getValue: function () {
            return this.getInstance().is(':checked');
        }
    };

    /**
     * Extends prototype
     */
    TestS.Form.CheckboxOnOff.prototype = $.extend(
        TestS.Form.prototype,
        TestS.Form.CheckboxOnOff.prototype
    );
}(window.jQuery, window.TestS);
