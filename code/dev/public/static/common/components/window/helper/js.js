!function ($, ss) {
    "use strict";

    var name = "commonComponentsWindowHelper";

    var parameters = {
        /**
         * Window
         *
         * @var {Object}
         */
        window: null,

        /**
         * Body
         *
         * @var {Object}
         */
        body: null,

        /**
         * Overlay
         *
         * @var {Object}
         */
        overlay: null,

        /**
         * Init
         */
        init: function () {
        },

        /**
         * Init
         */
        create: function (options) {
            this.window = null;
            this.body = null;
            this.overlay = null;

            this
                .extendOptions(options)
                .setCssClass()
                .setCloseEvents()
                .addDomElement()
                .setMaxHeight();
        },

        /**
         * Gets window
         *
         * @returns {Object}
         */
        getWindow: function () {
            return this.window;
        },

        /**
         * Gets body
         *
         * @returns {Object}
         */
        getBody: function () {
            return this.body;
        },

        /**
         * Sets CSS class
         */
        setCssClass: function () {
            if (this.getOption("name") === null) {
                return this;
            }

            this.window.addClass("window-" + this.getOption("name"));

            return this;
        },

        /**
         * Close event
         */
        setCloseEvents: function () {
            this.overlay.on("click",  $.proxy(this.remove, this));
            this.window
                .find(".close")
                .on("click", $.proxy(this.remove, this));

            return this;
        },

        /**
         * Removes window and overlay
         */
        remove: function () {
            this.window.addClass("transparent");
            this.overlay.addClass("transparent");

            setTimeout(
                $.proxy(
                    function () {
                        this.window.remove();
                        this.overlay.remove();
                    },
                    this
                ),
                350
            );
        },

        /**
         * Adds element to DOM
         */
        addDomElement: function () {
            this.window.addClass("level-last");
            this.overlay.addClass("level-last");

            ss.init("app").append(this.window);
            ss.init("app").append(this.overlay);

            setTimeout(
                $.proxy(
                    function () {
                        this.window.removeClass("transparent");
                        this.overlay.removeClass("transparent");
                    },
                    this
                ),
                50
            );

            return this;
        },

        /**
         * Sets window's max-height
         */
        setMaxHeight: function () {
            this.setWindowMaxHeight();

            $(window).resize(
                $.proxy(
                    function () {
                        this.setWindowMaxHeight();
                    },
                    this
                )
            );

            return this;
        },

        /**
         * Sets window's max-height
         */
        setWindowMaxHeight: function () {
            var minusHeight = 148;

            this.body.css(
                "max-height",
                $.proxy(
                    function () {
                        return ($(window).outerHeight() - minusHeight);
                    },
                    this
                )
            );
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
