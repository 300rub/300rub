!function ($, TestS) {
    'use strict';

    /**
     * CheckboxButton form
     *
     * @param {Object} options
     */
    TestS.Form.CheckboxButton = function (options) {
        this.set("checkbox-button", options);
        this.init();
    };

    /**
     * CheckboxButton form prototype
     *
     * @type {Object}
     */
    var prototype = {

        /**
         * Constructor
         */
        constructor: TestS.Form.CheckboxButton,

        /**
         * Init
         */
        init: function () {
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
    TestS.Form.CheckboxButton.prototype = $.extend(
        Object.create(TestS.Form.prototype),
        prototype
    );
}(window.jQuery, window.TestS);
