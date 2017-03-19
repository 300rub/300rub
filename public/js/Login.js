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
            var $login = new TestS.Form.Text({
                name: "login",
                appendTo: $("body")
            });
        }
    };

    /**
     * Login auto init
     */
    $(document).ready(function() {
        new TestS.Login();
    });
}(window.jQuery, window.TestS);