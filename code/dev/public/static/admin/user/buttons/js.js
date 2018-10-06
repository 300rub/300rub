/**
 * User buttons
 */
ss.add(
    "adminUserButtons",
    {

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
            ss.init(
                "commonComponentsCommonAjax",
                {
                    data: {
                        group: "user",
                        controller: "buttons"
                    },
                    success: $.proxy(this.onLoadSuccess, this)
                }
            );
        },

        /**
         * On load success
         *
         * @param {Object} data
         */
        onLoadSuccess: function(data) {
            this
                .setData(data)
                .setContainer()
                .setRelease()
                .setSection()
                .setBlocks()
                .setSettings()
            ;
        },

        /**
         * Sets container
         */
        setContainer: function() {
            this.container = ss.components.Template.get(
                this.getOption("user-buttons")
            );

            // Append

            return this;
        },

        /**
         * Sets release
         */
        setRelease: function () {
            var btn = this.container.find(".release");

            if (this.getData("canRelease") !== true) {
                btn.remove();
                return this;
            }

            btn.on(
                "click",
                function () {
                    new ss.panel.settings.ShortInfo();
                }
            );

            btn.find(".label").text(this.getLabel("releaseButton"));

            if (this.getData("isReadyToRelease") === true) {
                btn.removeClass("hidden");
                return this;
            }

            var releaseInterval = setInterval(
                function() {
                    new ss.components.Ajax(
                        {
                            data: {
                                group: "release",
                                controller: "ready"
                            },
                            success: function (data) {
                                if (data.isReadyToRelease === true) {
                                    clearInterval(releaseInterval);
                                    btn.removeClass('hidden');
                                }
                            }
                        }
                    );
                },
                60000
            );

            return this;
        },

        /**
         * Sets section
         */
        setSection: function () {
            var btn = this.container.find(".section");

            if (this.getData("isDisplaySections") !== true) {
                btn.remove();
                return this;
            }

            btn.on(
                "click",
                function () {
                    new ss.panel.section.List();
                }
            );

            btn.find(".label").text(this.getLabel("sectionsButton"));

            return this;
        },

        /**
         * Sets blocks
         */
        setBlocks: function () {
            var btn = this.container.find(".block");

            if (this.getData("isDisplayBlocks") !== true) {
                btn.remove();
                return this;
            }

            btn.on(
                "click",
                function () {
                    new ss.panel.blocks.List();
                }
            );

            btn.find(".label").text(this.getLabel("blocksButton"));

            return this;
        },

        /**
         * Sets settings
         */
        setSettings: function () {
            var btn = this.container.find(".settings");

            btn.on(
                "click",
                function () {
                    new ss.panel.settings.List();
                }
            );

            btn.find(".label").text(this.getLabel("settingsButton"));

            return this;
        },

        /**
         * Sets logout events
         */
        setLogout: function () {
            var btn = this.container.find(".logout");
            var logoutConfirmation
                = this.container.find("logout-confirmation");

            new ss.forms.Button(
                {
                    css: "btn btn-red",
                    appendTo: logoutConfirmation,
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
                    appendTo: logoutConfirmation,
                    label: $logoutConfirmation.data("no"),
                    icon: "fas fa-ban",
                    onClick: function () {
                        logoutConfirmation.addClass("hidden");
                    }
                }
            );

            btn.on(
                "click",
                function () {
                    logoutConfirmation.removeClass("hidden");
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