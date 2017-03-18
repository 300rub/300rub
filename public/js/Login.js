!function ($, TestS) {
    'use strict';

    /**
     * Login
     *
     * @type {Object}
     */
    TestS.Login = function () {
        this.init();
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    TestS.Login.prototype = {
        init: function () {
            console.log(134);
        }
    };

    /**
     * Login auto init
     */
    $(document).ready(function() {
        new TestS.Login();
    });
}(window.jQuery, window.TestS);