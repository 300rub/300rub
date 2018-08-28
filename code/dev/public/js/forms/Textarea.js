!function ($, ss) {
    'use strict';

    /**
     * Textarea form
     *
     * @param {Object} options
     */
    ss.forms.Textarea = function (options) {
        ss.forms.Abstract.call(this, "form-container-textarea", options);
        this.init();
    };

    /**
     * Text form prototype
     *
     * @type {Object}
     */
    ss.forms.Textarea.prototype = Object.create(ss.forms.Abstract.prototype);

    /**
     * Constructor
     */
    ss.forms.Textarea.prototype.constructor = ss.forms.Textarea;

    /**
     * Init
     */
    ss.forms.Textarea.prototype.init = function () {
        this.getInstance().val(this.getOption("value"));

        var rows = this.getOption("rows");
        if (rows !== null) {
            this.getInstance().attr("rows", rows);
        }
    };
}(window.jQuery, window.ss);
