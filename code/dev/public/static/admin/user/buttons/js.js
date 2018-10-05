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
        }
    }
);

$(document).ready(
    function () {
        //ss.init("adminUserButtons");
    }
);