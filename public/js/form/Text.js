!function ($, TestS) {
    'use strict';

    /**
     * Text form
     *
     * @param {Object} options
     */
    TestS.Form.Text = function (options) {
        TestS.Form.Abstract.call(this, "form-container-text", options);
        this.init();
    };

    /**
     * Text form prototype
     *
     * @type {Object}
     */
    TestS.Form.Text.prototype = Object.create(TestS.Form.Abstract.prototype);

    /**
     * Constructor
     */
    TestS.Form.Text.prototype.constructor = TestS.Form.Text;

    /**
     * Init
     */
    TestS.Form.Text.prototype.init = function () {
        this.getInstance().val(this.getOption("value"));
    };
}(window.jQuery, window.TestS);
