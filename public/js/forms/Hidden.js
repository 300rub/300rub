!function ($, ss) {
    'use strict';

    /**
     * Hidden form
     *
     * @param {Object} options
     */
    ss.forms.Hidden = function (options) {
        ss.forms.Abstract.call(this, "form-container-hidden", options);
        this.init();
    };

    /**
     * Hidden form prototype
     *
     * @type {Object}
     */
    ss.forms.Hidden.prototype = Object.create(ss.forms.Abstract.prototype);

    /**
     * Constructor
     */
    ss.forms.Hidden.prototype.constructor = ss.forms.Hidden;

    /**
     * Init
     */
    ss.forms.Hidden.prototype.init = function () {
        this.getInstance().val(this.getOption("value"));
    };
}(window.jQuery, window.ss);
