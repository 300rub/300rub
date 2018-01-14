!function ($, TestS) {
    'use strict';

    /**
     * Checkbox form
     *
     * @param {Object} options
     */
    TestS.Form.Checkbox = function (options) {
        this.set("form-container-checkbox", options);
        this.init();
    };

    /**
     * Checkbox form prototype
     *
     * @type {Object}
     */
    TestS.Form.Checkbox.prototype = {

        /**
         * Constructor
         */
        constructor: TestS.Form.Checkbox,

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
    TestS.Form.Checkbox.prototype = $.extend(
        TestS.Form.prototype,
        TestS.Form.Checkbox.prototype
    );
}(window.jQuery, window.TestS);
