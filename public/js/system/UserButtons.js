!function ($, Ss) {
    'use strict';

    /**
     * UserButtons
     *
     * @type {Object}
     */
    Ss.System.UserButtons = function () {
        this._container = null;

        this.init();
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    Ss.System.UserButtons.prototype = {

        /**
         * Constructor
         */
        constructor: Ss.System.UserButtons,

        /**
         * Init
         */
        init: function () {
            this._container = $("#user-buttons");

            this
                ._setBlocks()
                ._setSettings()
                ._setLogout();
        },

        /**
         * Sets blocks
         *
         * @returns {Ss.System.UserButtons}
         *
         * @private
         */
        _setBlocks: function () {
            $("#user-button-block").on(
                "click",
                function () {
                    new Ss.Panel.Blocks.List();
                }
            );

            return this;
        },

        /**
         * Sets settings
         *
         * @returns {Ss.System.UserButtons}
         *
         * @private
         */
        _setSettings: function () {
            $("#user-button-settings").on(
                "click",
                function () {
                    new Ss.Panel.Settings.List();
                }
            );

            return this;
        },

        /**
         * Sets logout events
         *
         * @returns {Ss.System.UserButtons}
         *
         * @private
         */
        _setLogout: function () {
            var $logoutConfirmation
                = this._container.find(".logout-confirmation");

            new Ss.Form.Button(
                {
                    css: "button",
                    appendTo: $logoutConfirmation,
                    label: $logoutConfirmation.data("yes"),
                    icon: "fa-sign-out",
                    ajax: {
                        type: "DELETE",
                        data: {
                            group: "user",
                            controller: "session"
                        },
                        success: function () {
                            window.location.reload();
                        },
                        error: function (jqXHR) {
                            var $errorTemplate = Ss.Components.Error
                                .getAjaxErrorTemplate(jqXHR);
                            $logoutConfirmation
                            .html($errorTemplate)
                            .addClass("error");
                        }
                    }
                }
            );

            new Ss.Form.Button(
                {
                    type: "button",
                    css: "gray-button",
                    appendTo: $logoutConfirmation,
                    label: $logoutConfirmation.data("no"),
                    icon: "fa-ban",
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
            new Ss.System.UserButtons();
        }
    );
}(window.jQuery, window.Ss);
