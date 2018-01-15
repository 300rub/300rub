!function ($, TestS) {
    'use strict';

    /**
     * Spinner form
     *
     * @param {Object} options
     */
    TestS.Form.Spinner = function (options) {
        TestS.Form.Abstract.call(this, "form-spinner", options);
        this.init();
    };

    /**
     * Spinner form prototype
     *
     * @type {Object}
     */
    TestS.Form.Spinner.prototype = Object.create(TestS.Form.Abstract.prototype);

    /**
     * Constructor
     */
    TestS.Form.Spinner.prototype.constructor = TestS.Form.Spinner;

    /**
     * Init
     */
    TestS.Form.Spinner.prototype.init = function () {
        this.getInstance().val(
            TestS.Components.Library.getIntVal(this.getOption("value"))
        );

        var callback = this.getOption("callback");
        if ($.type(callback) === "function") {
            this.getInstance().on(
                "keyup",
                function () {
                    callback(
                        TestS.Components.Library.getIntVal($(this).val())
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
                            TestS.Components.Library.getIntVal(ui.value)
                        );
                    }
                },
                icons: {
                    up: "fa fa-chevron-up gray-blue-link",
                    down: "fa fa-chevron-down gray-blue-link"
                }
            }
        );
    };

    /**
     * Gets value
     *
     * @returns {String}
     */
    TestS.Form.Spinner.prototype.getValue = function () {
        return TestS.Components.Library.getIntVal(this.getInstance().val());
    };
}(window.jQuery, window.TestS);
