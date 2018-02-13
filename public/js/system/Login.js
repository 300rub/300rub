!function ($, Ss) {
    'use strict';

    /**
     * Login
     *
     * @type {Object}
     */
    Ss.System.Login = function () {
        this.init();
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    Ss.System.Login.prototype = {

        /**
         * Constructor
         */
        constructor: Ss.System.Login,

        /**
         * Init
         */
        init: function () {
            $("#login-button").on(
                "click",
                function () {
                    new Ss.Window.Users.Login();
                }
            );
        }
    };

    // Login auto init.
    $(document).ready(
        function () {
            new Ss.System.Login();
        }
    );
}(window.jQuery, window.Ss);
