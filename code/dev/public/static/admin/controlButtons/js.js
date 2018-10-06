/**
 * User buttons
 */
ss.add(
    "adminControlButtons",
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
                "ajax",
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
                .setHelp()
                .setLogout()
                .display();
        },

        /**
         * Displays buttons
         */
        display: function() {
            var app = ss.init("app");

            app
                .append(this.container)
                .addDomElement("controlButtons", this.container);

            setTimeout($.proxy(function(){
                this.container.removeClass("transparent");
            }, this), 50);

            return this;
        },

        /**
         * Sets container
         */
        setContainer: function() {
            this.container = ss.init("template").get("control-buttons");
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
                    ss.init("adminReleasePanel");
                }
            );

            btn.find(".label").text(this.getLabel("releaseButton"));

            if (this.getData("isReadyToRelease") === true) {
                btn.removeClass("hidden");
                return this;
            }

            var releaseInterval = setInterval(
                function() {
                    ss.init(
                        "ajax",
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
                    )
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
                    ss.init("adminBlockList");
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
                    ss.init("adminSettingsList");
                }
            );

            btn.find(".label").text(this.getLabel("settingsButton"));

            return this;
        },

        /**
         * Sets help
         */
        setHelp: function () {
            var btn = this.container.find(".help");

            btn.find(".label").text(this.getLabel("helpButton"));

            return this;
        },

        /**
         * Sets logout events
         */
        setLogout: function () {
            var btn = this.container.find(".logout");

            btn.find(".label").text(this.getLabel("logoutButton"));

            var logoutConfirmation
                = this.container.find(".logout-confirmation");

            logoutConfirmation
                .find(".text")
                .text(this.getLabel("logoutConfirmText"));

            btn.on(
                "click",
                function () {
                    logoutConfirmation.removeClass("hidden");
                }
            );

            ss.init(
                "commonComponentsFormButton",
                {
                    css: "btn btn-red",
                    appendTo: logoutConfirmation,
                    label: this.getLabel("logoutYes"),
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

            ss.init(
                "commonComponentsFormButton",
                {
                    css: "btn btn-gray",
                    appendTo: logoutConfirmation,
                    label: this.getLabel("logoutNo"),
                    icon: "fas fa-ban",
                    onClick: function () {
                        logoutConfirmation.addClass("hidden");
                    }
                }
            );

            return this;
        }
    }
);
