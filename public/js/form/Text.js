!function ($, Ss) {
    'use strict';

    /**
     * Text form
     *
     * @param {Object} options
     */
    Ss.Form.Text = function (options) {
        Ss.Form.Abstract.call(this, "form-container-text", options);
        this.init();
    };

    /**
     * Text form prototype
     *
     * @type {Object}
     */
    Ss.Form.Text.prototype = Object.create(Ss.Form.Abstract.prototype);

    /**
     * Constructor
     */
    Ss.Form.Text.prototype.constructor = Ss.Form.Text;

    /**
     * Init
     */
    Ss.Form.Text.prototype.init = function () {
        this.getInstance().val(this.getOption("value"));
    };
}(window.jQuery, window.Ss);
