!function ($, ss) {
    'use strict';

    /**
     * Spinner form
     *
     * @param {Object} options
     */
    ss.forms.Spinner = function (options) {
        ss.forms.Abstract.call(this, "form-spinner", options);
        this.init();
    };

    /**
     * Spinner form prototype
     *
     * @type {Object}
     */
    ss.forms.Spinner.prototype = Object.create(ss.forms.Abstract.prototype);

    /**
     * Constructor
     */
    ss.forms.Spinner.prototype.constructor = ss.forms.Spinner;

    /**
     * Init
     */
    ss.forms.Spinner.prototype.init = function () {
        this.getInstance().val(
            ss.components.Library.getIntVal(this.getOption("value"))
        );

        var callback = this.getOption("callback");
        if ($.type(callback) === "function") {
            this.getInstance().on(
                "keyup",
                function () {
                    callback(
                        ss.components.Library.getIntVal($(this).val())
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
                            ss.components.Library.getIntVal(ui.value)
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
    ss.forms.Spinner.prototype.getValue = function () {
        return ss.components.Library.getIntVal(this.getInstance().val());
    };
}(window.jQuery, window.ss);
