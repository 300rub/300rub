!function ($, ss) {
    'use strict';

    /**
     * Password form
     *
     * @param {Object} options
     */
    ss.forms.Password = function (options) {
        ss.forms.Abstract.call(this, "form-container-password", options);
        this.init();
    };

    /**
     * Password form prototype
     *
     * @type {Object}
     */
    ss.forms.Password.prototype
        = Object.create(ss.forms.Abstract.prototype);

    /**
     * Constructor
     */
    ss.forms.Password.prototype.constructor = ss.forms.Password;

    /**
     * Init
     */
    ss.forms.Password.prototype.init = function () {
        this.getInstance().val("");
    };

    /**
     * Gets value
     *
     * @returns {String}
     */
    ss.forms.Password.prototype.getValue = function () {
        return window.md5(this.getInstance().val() + "(^_^)");
    };
}(window.jQuery, window.ss);
