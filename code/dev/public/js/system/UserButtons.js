!function ($, ss) {
    'use strict';

    /**
     * UserButtons
     *
     * @type {Object}
     */
    ss.system.UserButtons = function () {
        this._container = null;

        this.init();
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    ss.system.UserButtons.prototype = {

        /**
         * Constructor
         */
        constructor: ss.system.UserButtons,

        /**
         * Init
         */
        init: function () {
            this._container = $("#user-buttons");

            this
                ._setRelease()
                ._setBlocks()
                ._setSettings()
                ._setLogout();
        },

        /**
         * Sets blocks
         *
         * @returns {ss.system.UserButtons}
         *
         * @private
         */
        _setBlocks: function () {
            $("#user-button-block").on(
                "click",
                function () {
                    new ss.panel.blocks.List();
                }
            );

            return this;
        },

        /**
         * Sets release
         *
         * @returns {ss.system.UserButtons}
         *
         * @private
         */
        _setRelease: function () {
            $("#user-button-release").on(
                "click",
                function () {
                    new ss.panel.settings.ShortInfo();
                }
            );

            return this;
        },

        /**
         * Sets settings
         *
         * @returns {ss.system.UserButtons}
         *
         * @private
         */
        _setSettings: function () {
            $("#user-button-settings").on(
                "click",
                function () {
                    new ss.panel.settings.List();
                }
            );

            return this;
        },

        /**
         * Sets logout events
         *
         * @returns {ss.system.UserButtons}
         *
         * @private
         */
        _setLogout: function () {
            var $logoutConfirmation
                = this._container.find(".logout-confirmation");

            new ss.forms.Button(
                {
                    css: "button",
                    appendTo: $logoutConfirmation,
                    label: $logoutConfirmation.data("yes"),
                    icon: "fas fa-sign-out-alt",
                    ajax: {
                        type: "DELETE",
                        data: {
                            group: "user",
                            controller: "session"
                        },
                        success: function (data) {
                            window.location = data.host;
                        }
                    }
                }
            );

            new ss.forms.Button(
                {
                    type: "button",
                    css: "gray-button",
                    appendTo: $logoutConfirmation,
                    label: $logoutConfirmation.data("no"),
                    icon: "fas fa-ban",
                    onClick: function () {
                        $logoutConfirmation.addClass("hidden");
                    }
                }
            );

            $("#user-button-logout").on(
                "click",
                function () {
                    $logoutConfirmation.removeClass("hidden");
                }
            );

            return this;
        }
    };

    // Login auto init.
    $(document).ready(
        function () {
            new ss.system.UserButtons();
        }
    );
}(window.jQuery, window.ss);
