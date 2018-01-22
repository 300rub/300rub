!function ($, TestS) {
    'use strict';

    /**
     * Login
     *
     * @type {Object}
     */
    TestS.System.Login = function () {
        this.init();
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    TestS.System.Login.prototype = {
        /**
         * Init
         */
        init: function () {
            $("#login-button").on(
                "click",
                function () {
                    new TestS.Window.Users.Login();
                }
            );
        }
    };

    // Login auto init.
    $(document).ready(
        function () {
            new TestS.System.Login();
        }
    );
}(window.jQuery, window.TestS);
