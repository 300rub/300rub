ss.add(
    "adminBlockImageSettings",
    {
        /**
         * Parent
         *
         * @var {String}
         */
        parent: "adminComponentsPanel",

        /**
         * Auto crop data
         *
         * @type {Array}
         */
        autoCropData: [
            {value: 1, icon: "fas fa-arrow-right", css: "deg-45"},
            {value: 2, icon: "fas fa-arrow-down"},
            {value: 3, icon: "fas fa-arrow-down", css: "deg-45"},
            {value: 4, icon: "fas fa-arrow-right"},
            {value: 5, icon: "fas fa-arrows-alt"},
            {value: 6, icon: "fas fa-arrow-left"},
            {value: 7, icon: "fas fa-arrow-up", css: "deg-45"},
            {value: 8, icon: "fas fa-arrow-up"},
            {value: 9, icon: "fas fa-arrow-left", css: "deg-45"}
        ],

        /**
         * Container
         *
         * @var {Object}
         */
        container: null,

        /**
         * Forms
         *
         * @var {Object}
         */
        forms: {},

        /**
         * Init
         */
        init: function() {
            this.container = null;
            this.forms = {};

            this.create(
                {
                    group: "image",
                    controller: "block",
                    data: {
                        id: this.getOption("blockId", 0)
                    },
                    back: function() {
                        ss.init("adminBlockImageList");
                    }
                }
            );
        },

        /**
         * On load success
         */
        onLoadSuccess: function() {
            var type = "PUT";
            var icon = "fas fa-save";
            if (data.id === 0) {
                type = "POST";
                icon = "fas fa-plus";
            }

            this
                .setContainer()
            ;
        },

        /**
         * Sets container
         */
        setContainer: function () {
            this.container
                = ss.get("template").get("image-settings-container");
            this.container.appendTo(this.getBody());

            return this;
        }
    }
);
