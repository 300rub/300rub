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
            var $login = $("#login");
            var $whiteContainer = $login.find(".white-container");

            var user = new TestS.Form({
                type: "text",
                name: "user",
                class: "user",
                placeholder: "Username",
                appendTo: $whiteContainer
            });

            var password = new TestS.Form({
                type: "password",
                name: "password",
                class: "password",
                placeholder: "Password",
                appendTo: $whiteContainer
            });

            var checkbox = new TestS.Form({
                type: "checkbox",
                name: "isRemember",
                appendTo: $login
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