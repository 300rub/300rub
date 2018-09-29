/**
 * Abstract window helper
 */
ss.add(
    "commonComponentsWindowHelper",
    {
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
        init: function() {
            this.window = null;
            this.body = null;
            this.overlay = null;

            this
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
            if (this._options.name === undefined) {
                return this;
            }

            this.window.addClass("window-" + this._options.name);

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

            ss.system.App.append(this.window);
            ss.system.App.append(this.overlay);

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
            if (this._hasFooter === false) {
                minusHeight = 90;
            }

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
    }
);