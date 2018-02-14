!function ($, ss) {
    'use strict';

    /**
     * Login
     *
     * @type {Object}
     */
    ss.system.Login = function () {
        this.init();
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    ss.system.Login.prototype = {

        /**
         * Constructor
         */
        constructor: ss.system.Login,

        /**
         * Init
         */
        init: function () {
            $("#login-button").on(
                "click",
                function () {
                    new ss.window.users.Login();
                }
            );
        }
    };

    // Login auto init.
    $(document).ready(
        function () {
            new ss.system.Login();
        }
    );
}(window.jQuery, window.ss);
