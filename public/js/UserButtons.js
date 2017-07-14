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

        $_container: null,

        /**
         * Init
         */
        init: function () {
            this.$_container = $("#user-buttons");

            this
                ._setBlocks()
                ._setSettings()
                ._setLogout();
        },

        /**
         * Sets blocks
         *
         * @returns {TestS.UserButtons}
         *
         * @private
         */
        _setBlocks: function() {
            $("#user-button-block").on("click", function () {
                new TestS.Panel.Block();
            });

            return this;
        },

        /**
         * Sets settings
         *
         * @returns {TestS.UserButtons}
         *
         * @private
         */
        _setSettings: function() {
            $("#user-button-settings").on("click", function () {
                new TestS.Panel.Settings();
            });

            return this;
        },

        /**
         * Sets logout events
         *
         * @returns {TestS.UserButtons}
         *
         * @private
         */
        _setLogout: function() {
            var $logoutConfirmation = this.$_container.find(".logout-confirmation");

            new TestS.Form({
                type: "button",
                class: "button",
                appendTo: $logoutConfirmation,
                label: $logoutConfirmation.data("yes"),
                icon: "fa-sign-out",
                ajax: {
                    type: "DELETE",
                    data: {
                        controller: "user",
                        action: "session"
                    },
                    success: function() {
                        window.location.reload();
                    },
                    error: function (jqXHR) {
                        var $errorTemplate = TestS.Ajax.getErrorTemplate(jqXHR);
                        $logoutConfirmation
                            .html($errorTemplate)
                            .addClass("error");
                    }
                }
            });

            new TestS.Form({
                type: "button",
                class: "gray-button",
                appendTo: $logoutConfirmation,
                label: $logoutConfirmation.data("no"),
                icon: "fa-ban",
                onClick: function () {
                    $logoutConfirmation.addClass("hidden");
                }
            });

            $("#user-button-logout").on("click", function() {
                $logoutConfirmation.removeClass("hidden");
            });

            return this;
        }
    };

    /**
     * Login auto init
     */
    $(document).ready(function() {
        new TestS.UserButtons();
    });
}(window.jQuery, window.TestS);