!function ($, Ss) {
    'use strict';

    /**
     * Password form
     *
     * @param {Object} options
     */
    Ss.Form.Password = function (options) {
        Ss.Form.Abstract.call(this, "form-container-password", options);
        this.init();
    };

    /**
     * Password form prototype
     *
     * @type {Object}
     */
    Ss.Form.Password.prototype
        = Object.create(Ss.Form.Abstract.prototype);

    /**
     * Constructor
     */
    Ss.Form.Password.prototype.constructor = Ss.Form.Password;

    /**
     * Init
     */
    Ss.Form.Password.prototype.init = function () {
        this.getInstance().val("");
    };

    /**
     * Gets value
     *
     * @returns {String}
     */
    Ss.Form.Password.prototype.getValue = function () {
        return window.md5(this.getInstance().val() + "(^_^)");
    };
}(window.jQuery, window.Ss);
