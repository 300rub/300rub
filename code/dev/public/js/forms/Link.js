!function ($, ss) {
    'use strict';

    /**
     * Link form
     *
     * @param {Object} options
     */
    ss.forms.Link = function (options) {
        ss.forms.Abstract.call(this, "form-link", options);
        this.init();
    };

    /**
     * Link form prototype
     *
     * @type {Object}
     */
    ss.forms.Link.prototype = Object.create(ss.forms.Abstract.prototype);

    /**
     * Constructor
     */
    ss.forms.Link.prototype.constructor = ss.forms.Link;

    /**
     * Init
     */
    ss.forms.Link.prototype.init = function () {
        var onClick = this.getOption("onClick");
        var data = this.getOption("data");

        if ($.type(onClick) === "function") {
            if ($.type(data) === "object") {
                this.getForm().on("click", data, onClick);
            } else {
                this.getForm().on("click", onClick);
            }
        }
    };
}(window.jQuery, window.ss);
