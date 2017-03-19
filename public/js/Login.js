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
        $_userInstance: null,
        $_passwordInstance: null,
        $_buttonInstance: null,

        init: function () {
            var $login = $("#login");
            var $whiteContainer = $login.find(".white-container");

            var user = new TestS.Form({
                type: "text",
                name: "user",
                class: "user",
                placeholder: "Username",
                onKeyUp: this._onUserKeyUp,
                appendTo: $whiteContainer
            });
            this.$_userInstance = user.getInstance();

            var password = new TestS.Form({
                type: "password",
                name: "password",
                class: "password",
                placeholder: "Password",
                appendTo: $whiteContainer
            });
            this.$_passwordInstance = password.getInstance();

            var checkbox = new TestS.Form({
                type: "checkbox",
                name: "isRemember",
                appendTo: $login
            });

            var button = new TestS.Form({
                type: "button",
                icon: "fa-arrow-right",
                class: "button disabled",
                appendTo: $whiteContainer
            });
            this.$_buttonInstance = button.getInstance();

            this.$_userInstance.on("keyup", $.proxy(this._setOnKeyUp, this));
            this.$_passwordInstance.on("keyup", $.proxy(this._setOnKeyUp, this));
        },

        /**
         * Sets on keyUp event
         *
         * @returns {TestS.Form}
         *
         * @private
         */
        _setOnKeyUp: function() {
            var userLength = this.$_userInstance.val().length;
            var passwordLength = this.$_passwordInstance.val().length;

            if (userLength >= 3
                && passwordLength >= 3
            ) {
                this.$_buttonInstance.removeClass("disabled");
            } else {
                this.$_buttonInstance.addClass("disabled");
            }
        }
    };

    /**
     * Login auto init
     */
    $(document).ready(function() {
        new TestS.Login();
    });
}(window.jQuery, window.TestS);