ss.add(
    "adminReleaseWindow",
    {
        /**
         * Parent
         *
         * @var {String}
         */
        parent: "commonComponentsWindowAbstract",

        /**
         * Init
         */
        init: function() {
            this.create(
                {
                    group: "release",
                    controller: "fullInfo",
                    success: $.proxy(this.onLoadSuccess, this),
                    name: "release-full-info",
                    hasFooter: false
                }
            );
        },

        onLoadSuccess: function() {

        }
    }
);
