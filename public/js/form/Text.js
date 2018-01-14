!function ($, TestS) {
    'use strict';

    /**
     * Text form
     *
     * @param {Object} options
     */
    TestS.Form.Text = function (options) {
        this.set("form-container-text", options);
        this.init();
    };

    /**
     * Text form prototype
     *
     * @type {Object}
     */
    var prototype = {

        /**
         * Constructor
         */
        constructor: TestS.Form.Text,

        /**
         * Init
         */
        init: function () {
            this.getInstance().val(this.getOption("value"));
        }
    };

    /**
     * Extends prototype
     */
    TestS.Form.Text.prototype = $.extend(
        Object.create(TestS.Form.prototype),
        prototype
    );
}(window.jQuery, window.TestS);
