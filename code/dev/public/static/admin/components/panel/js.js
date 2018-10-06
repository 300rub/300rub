/**
 * Abstract form
 */
ss.add(
    "adminComponentsPanel",
    {
        /**
         * Load options
         *
         * @var {Object}
         */
        loadOptions: {},

        /**
         * Panel
         *
         * @var {Object}
         */
        panel: null,

        /**
         * Body
         *
         * @var {Object}
         */
        body: null,

        /**
         * Footer flag
         *
         * @var {Object}
         */
        hasFooter: true,

        /**
         * Init
         */
        init: function() {
        },

        create: function(loadOptions) {
            this
                .setLoadOptions(loadOptions)
                .setPanel()
                .setBody()
            ;
        },

        setLoadOptions: function(loadOptions) {
            this.loadOptions = $.extend({}, loadOptions);
            return this;
        },

        setPanel: function() {
            this.panel = ss.init("template").get("panel");
            return this;
        },

        setBody: function() {
            this.body = this.panel.find(".body");
            return this;
        },
    }
);
