!function ($, TestS) {
    'use strict';

    /**
     * Password form
     *
     * @param {Object} options
     */
    TestS.Form.Password = function (options) {
        this.set("form-container-password", options);
        this.init();
    };

    /**
     * Password form prototype
     *
     * @type {Object}
     */
    var prototype = {

        /**
         * Constructor
         */
        constructor: TestS.Form.Password,

        /**
         * Init
         */
        init: function () {
            this.getInstance().val("");
        },

        /**
         * Gets value
         *
         * @returns {String}
         */
        getValue: function () {
            return window.md5(this.getInstance().val() + "(^_^)");
        }
    };

    /**
     * Extends prototype
     */
    TestS.Form.Password.prototype = $.extend(
        Object.create(TestS.Form.prototype),
        prototype
    );
}(window.jQuery, window.TestS);
