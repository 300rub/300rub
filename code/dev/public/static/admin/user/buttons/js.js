/**
 * User buttons
 */
ss.add(
    "adminUserButtons",
    {
        /**
         * Release button
         *
         * @var {Object}
         */
        releaseButton: null,

        /**
         * Release interval
         *
         * @var {Number}
         */
        releaseInterval: null,

        /**
         * Container
         *
         * @var {Object}
         */
        container: null,

        /**
         * Init
         */
        init: function() {
            this.releaseButton = null;
            this.releaseInterval = null;
            this.container = $("#user-buttons");

            this
                .setRelease()
                .setSection()
                .setBlocks()
                .setSettings()
                .setLogout();
        },

        /**
         * Sets section
         */
        setSection: function () {
            $("#user-button-section").on(
                "click",
                function () {
                    new ss.panel.section.List();
                }
            );

            return this;
        },

        /**
         * Sets blocks
         */
        setBlocks: function () {
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
         */
        setRelease: function () {
            this.releaseButton = $("#user-button-release");

            if (this.releaseButton.length === 0) {
                return this;
            }

            this.releaseButton.on(
                "click",
                function () {
                    new ss.panel.settings.ShortInfo();
                }
            );

            this.getReadyToRelease();
            this.releaseInterval = setInterval(
                $.proxy(this.getReadyToRelease, this),
                60000
            );

            return this;
        },

        /**
         * Gets is ready for release
         */
        getReadyToRelease: function() {
            new ss.components.Ajax(
                {
                    data: {
                        group: "release",
                        controller: "ready"
                    },
                    success: $.proxy(function (data) {
                        if (data.isReadyToRelease === true) {
                            clearInterval(this.releaseInterval);
                            this.releaseButton.removeClass('hidden');
                        }
                    }, this)
                }
            );

            return this;
        },

        /**
         * Sets settings
         */
        setSettings: function () {
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
         */
        setLogout: function () {
            var $logoutConfirmation
                = this.container.find(".logout-confirmation");

            new ss.forms.Button(
                {
                    css: "btn btn-red",
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
                    css: "btn btn-gray",
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
    }
);

$(document).ready(
    function () {
        //ss.init("adminUserButtons");
    }
);