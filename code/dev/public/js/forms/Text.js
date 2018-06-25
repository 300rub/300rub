!function ($, ss) {
    'use strict';

    /**
     * Text form
     *
     * @param {Object} options
     */
    ss.forms.Text = function (options) {
        ss.forms.Abstract.call(this, "form-container-text", options);
        this.init();
    };

    /**
     * Text form prototype
     *
     * @type {Object}
     */
    ss.forms.Text.prototype = Object.create(ss.forms.Abstract.prototype);

    /**
     * Constructor
     */
    ss.forms.Text.prototype.constructor = ss.forms.Text;

    /**
     * Init
     */
    ss.forms.Text.prototype.init = function () {
        this.getInstance().val(this.getOption("value"));
    };
}(window.jQuery, window.ss);
