!function ($, TestS) {
    'use strict';

    /**
     * Hidden form
     *
     * @param {Object} options
     */
    TestS.Form.Hidden = function (options) {
        TestS.Form.Abstract.call(this, "form-container-hidden", options);
        this.init();
    };

    /**
     * Hidden form prototype
     *
     * @type {Object}
     */
    TestS.Form.Hidden.prototype = Object.create(TestS.Form.Abstract.prototype);

    /**
     * Constructor
     */
    TestS.Form.Hidden.prototype.constructor = TestS.Form.Hidden;

    /**
     * Init
     */
    TestS.Form.Hidden.prototype.init = function () {
        this.getInstance().val(this.getOption("value"));
    };
}(window.jQuery, window.TestS);
