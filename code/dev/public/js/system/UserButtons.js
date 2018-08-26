!function ($, ss) {
    'use strict';

    /**
     * UserButtons
     *
     * @type {Object}
     */
    ss.system.UserButtons = function () {
        this._container = null;

        this._releaseButton = null;
        this._releaseInterval = null;

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
            this._releaseButton = $("#user-button-release");

            if (this._releaseButton.length === 0) {
                return this;
            }

            this._releaseButton.on(
                "click",
                function () {
                    new ss.panel.settings.ShortInfo();
                }
            );

            this._getReadyToRelease();
            this._releaseInterval = setInterval(
                $.proxy(this._getReadyToRelease, this),
                60000
            );

            return this;
        },

        /**
         * Gets is ready for release
         *
         * @returns {ss.system.UserButtons}
         *
         * @private
         */
        _getReadyToRelease: function() {
            new ss.components.Ajax(
                {
                    data: {
                        group: "release",
                        controller: "ready"
                    },
                    success: $.proxy(function (data) {
                        if (data.isReadyToRelease === true) {
                            clearInterval(this._releaseInterval);
                            this._releaseButton.removeClass('hidden');
                        }
                    }, this)
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
