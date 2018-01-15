!function ($, TestS) {
    'use strict';

    /**
     * Password form
     *
     * @param {Object} options
     */
    TestS.Form.Password = function (options) {
        TestS.Form.Abstract.call(this, "form-container-password", options);
        this.init();
    };

    /**
     * Password form prototype
     *
     * @type {Object}
     */
    TestS.Form.Password.prototype
        = Object.create(TestS.Form.Abstract.prototype);

    /**
     * Constructor
     */
    TestS.Form.Password.prototype.constructor = TestS.Form.Password;

    /**
     * Init
     */
    TestS.Form.Password.prototype.init = function () {
        this.getInstance().val("");
    };

    /**
     * Gets value
     *
     * @returns {String}
     */
    TestS.Form.Password.prototype.getValue = function () {
        return window.md5(this.getInstance().val() + "(^_^)");
    };
}(window.jQuery, window.TestS);
