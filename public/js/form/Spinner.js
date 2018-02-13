!function ($, Ss) {
    'use strict';

    /**
     * Spinner form
     *
     * @param {Object} options
     */
    Ss.Form.Spinner = function (options) {
        Ss.Form.Abstract.call(this, "form-spinner", options);
        this.init();
    };

    /**
     * Spinner form prototype
     *
     * @type {Object}
     */
    Ss.Form.Spinner.prototype = Object.create(Ss.Form.Abstract.prototype);

    /**
     * Constructor
     */
    Ss.Form.Spinner.prototype.constructor = Ss.Form.Spinner;

    /**
     * Init
     */
    Ss.Form.Spinner.prototype.init = function () {
        this.getInstance().val(
            Ss.Components.Library.getIntVal(this.getOption("value"))
        );

        var callback = this.getOption("callback");
        if ($.type(callback) === "function") {
            this.getInstance().on(
                "keyup",
                function () {
                    callback(
                        Ss.Components.Library.getIntVal($(this).val())
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
                            Ss.Components.Library.getIntVal(ui.value)
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
    Ss.Form.Spinner.prototype.getValue = function () {
        return Ss.Components.Library.getIntVal(this.getInstance().val());
    };
}(window.jQuery, window.Ss);
