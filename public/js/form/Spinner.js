!function ($, TestS) {
    'use strict';

    /**
     * Spinner form
     *
     * @param {Object} options
     */
    TestS.Form.Spinner = function (options) {
        this.set("form-spinner", options);
        this.init();
    };

    /**
     * Spinner form prototype
     *
     * @type {Object}
     */
    TestS.Form.Spinner.prototype = {

        /**
         * Constructor
         */
        constructor: TestS.Form.Spinner,

        /**
         * Init
         */
        init: function () {
            this.getInstance().val(
                TestS.Library.getIntVal(this.getOption("value"))
            );

            var callback = this.getOption("callback");
            if ($.type(callback) === "function") {
                this.getInstance().on(
                    "keyup",
                    function () {
                        callback(
                            TestS.Library.getIntVal($(this).val())
                        );
                    }
                );
            }

            var iconBeforeElement = this.getForm().find(".icon-before");
            var iconBeforeOption = this.getOption("iconBefore");
            if (iconBeforeOption !== null) {
                iconBeforeElement.addClass(iconBeforeOption);
            } else {
                iconBeforeElement.remove();
            }

            var min = this.getOption("min");
            if (min === null) {
                min = -999999;
            }

            this.getInstance().spinner(
                {
                    min: min,
                    spin: function (event, ui) {
                        if ($.type(callback) === "function") {
                            callback(
                                TestS.Library.getIntVal(ui.value)
                            );
                        }
                    },
                    icons: {
                        up: "fa fa-chevron-up gray-blue-link",
                        down: "fa fa-chevron-down gray-blue-link"
                    }
                }
            );
        }
    };

    /**
     * Extends prototype
     */
    TestS.Form.Spinner.prototype = $.extend(
        TestS.Form.prototype,
        TestS.Form.Spinner.prototype
    );
}(window.jQuery, window.TestS);
