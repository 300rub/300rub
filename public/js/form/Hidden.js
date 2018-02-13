!function ($, Ss) {
    'use strict';

    /**
     * Hidden form
     *
     * @param {Object} options
     */
    Ss.Form.Hidden = function (options) {
        Ss.Form.Abstract.call(this, "form-container-hidden", options);
        this.init();
    };

    /**
     * Hidden form prototype
     *
     * @type {Object}
     */
    Ss.Form.Hidden.prototype = Object.create(Ss.Form.Abstract.prototype);

    /**
     * Constructor
     */
    Ss.Form.Hidden.prototype.constructor = Ss.Form.Hidden;

    /**
     * Init
     */
    Ss.Form.Hidden.prototype.init = function () {
        this.getInstance().val(this.getOption("value"));
    };
}(window.jQuery, window.Ss);
