!function ($, TestS) {
    'use strict';

    /**
     * Hidden form
     *
     * @param {Object} options
     */
    TestS.Form.Hidden = function (options) {
        this.set("form-container-hidden", options);
        this.init();
    };

    /**
     * Hidden form prototype
     *
     * @type {Object}
     */
    TestS.Form.Hidden.prototype = {

        /**
         * Constructor
         */
        constructor: TestS.Form.Hidden,

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
    TestS.Form.Hidden.prototype = $.extend(
        TestS.Form.prototype,
        TestS.Form.Hidden.prototype
    );
}(window.jQuery, window.TestS);
