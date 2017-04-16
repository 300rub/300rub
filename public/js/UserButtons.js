!function ($, TestS) {
    'use strict';

    /**
     * UserButtons
     *
     * @type {Object}
     */
    TestS.UserButtons = function () {
        this.init();
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    TestS.UserButtons.prototype = {

        /**
         * Init
         */
        init: function () {
            $("#user-button-logout").on("click", this._onLogoutClick);
        },

        _onLogoutClick: function () {
            var $logoutConfirmation = $("#logout-confirmation");
            $logoutConfirmation.removeClass("hidden");

            var yes = new TestS.Form({
                type: "button",
                class: "yes",
                appendTo: $logoutConfirmation,
                label: $logoutConfirmation.data("yes"),
                icon: "fa-sign-out"
            });

            var no = new TestS.Form({
                type: "button",
                class: "no",
                appendTo: $logoutConfirmation,
                label: $logoutConfirmation.data("no"),
                icon: "fa-ban",
                onClick: function () {
                    $logoutConfirmation.addClass("hidden");
                    remove(yes.getInstance());
                }
            });
        }
    };

    /**
     * Login auto init
     */
    $(document).ready(function() {
        new TestS.UserButtons();
    });
}(window.jQuery, window.TestS);