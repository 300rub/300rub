/**
 * Abstract window
 */
ss.add(
    "commonComponentsWindowAbstract",
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
         * Has footer
         *
         * @var {boolean}
         */
        hasFooter: true,

        /**
         * Init
         */
        init: function() {
        },

        /**
         * Creates a window
         *
         * @var {Object} options
         */
        create: function(options) {
            this.hasFooter = true;

            this
                .setWindow()
                .setBody()
                .setOverlay()
                .extendOptions(options)
                .setHasFooter()
                .setCssClass()
                .addToCollection()
                .setCloseEvents()
                .addDomElement()
                .setMaxHeight()
                .load();
        },

        /**
         * Sets footer
         */
        setHasFooter: function() {
            this.hasFooter = true;

            if (this.getOption("hasFooter") !== false) {
                return this;
            }

            this.hasFooter = false;
            this.window.find(".footer").remove();

            return this;
        },

        /**
         * Sets window
         */
        setWindow: function() {
            this.window = ss.init("template").get("window");
            return this;
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
         * Sets body
         */
        setBody: function() {
            this.body = this.window.find(".body");
            return this;
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
         * Sets overlay
         */
        setOverlay: function() {
            this.overlay = ss.init("template").get("window-overlay");
            return this;
        },

        /**
         * Gets parent
         */
        getParent: function () {
            if (this.getOption("parent") === null) {
                return null;
            }

            return ss.init("commonComponentsWindowCollection")
                .get(this.getOption("parent"));
        },

        /**
         * Sets title
         */
        setTitle: function () {
            this.window.find(".header .title").text(this.getData("title"));
            return this;
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
         * Adds window to the collection
         */
        addToCollection: function () {
            if (this.getOption("name") === null) {
                return this;
            }

            ss.init("commonComponentsWindowCollection")
                .add(this.getOption("name"), this);

            var parent = this.getParent();
            if (parent !== null) {
                parent.getWindow().addClass("transparent");
            }

            return this;
        },

        /**
         * Close event
         */
        setCloseEvents: function () {
            this.overlay.on("click",  $.proxy(this.checkUnsavedAndClose, this));
            this.window
                .find(".header .close")
                .on("click", $.proxy(this.checkUnsavedAndClose, this));

            return this;
        },

        /**
         * Checks unsaved
         */
        checkUnsavedAndClose: function() {
            if (this.body.find(".form-changed").length === 0) {
                this.remove(false);
                return this;
            }

            var confirmedWindow
                = this.window.find(".window-confirm-unsaved");

            if (confirmedWindow.length > 0) {
                return this;
            }

            confirmedWindow
                = ss.init("template").get("window-confirm-unsaved");

            var buttons = confirmedWindow.find(".buttons");

            ss.init(
                "commonComponentsFormButton",
                {
                    css: "btn btn-red",
                    icon: "fas fa-times",
                    label: buttons.data("close"),
                    appendTo: buttons,
                    onClick: $.proxy(function () {
                        this.remove(false);
                    }, this)
                }
            );

            ss.init(
                "commonComponentsFormButton",
                {
                    css: "btn btn-gray",
                    icon: "fas fa-undo",
                    label: buttons.data("stay"),
                    appendTo: buttons,
                    onClick: $.proxy(function () {
                        confirmedWindow.remove();
                    }, this)
                }
            );

            this.window.append(confirmedWindow);

            return this;
        },

        /**
         * Removes window and overlay
         */
        remove: function (isReloadParent) {
            this.window.addClass("transparent");
            this.overlay.addClass("transparent");

            var parent = this.getParent();
            if (parent !== null) {
                if (isReloadParent === true) {
                    parent.reload();
                } else {
                    parent.getWindow().removeClass("transparent");
                }
            } else {
                ss.init("app").getWrapper()
                    .find(".panel")
                    .removeClass("transparent");
            }

            setTimeout(
                $.proxy(
                    function () {
                        this.window.remove();
                        this.overlay.remove();

                        if (this.getOption("name") !== null) {
                            ss.init("commonComponentsWindowCollection")
                                .remove(
                                    this.getOption("name")
                                );
                        }
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
            var app = ss.init("app");

            if (this.getOption("level") !== null) {
                this.window.addClass("level-" + this.getOption("level"));
                this.overlay.addClass("level-" + this.getOption("level"));
            }

            app.append(this.window);
            app.append(this.overlay);

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

            app.getWrapper()
                .find(".panel")
                .addClass("transparent");

            return this;
        },

        /**
         * Reloads the window
         *
         * @param {Object} options
         */
        reload: function (options) {
            this.window.remove();
            this.overlay.remove();
            this.create(options);

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
            if (this.hasFooter === false) {
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
        },

        /**
         * Loads data
         */
        load: function () {
            ss.init(
                "ajax",
                {
                    data: {
                        group: this.getOption("group"),
                        controller: this.getOption("controller"),
                        data: this.getOption("data", {})
                    },
                    success: $.proxy(
                        function(data) {
                            this
                                .setData(data)
                                .setTitle();

                            this.onLoadSuccess();

                            this.window.removeClass("loading");
                        },
                        this
                    ),
                    error: $.proxy(
                        function(jqXHR) {
                            ss.components.Error.displayAjaxError(jqXHR);
                            this.remove();
                        },
                        this
                    )
                }
            );

            return this;
        },

        /**
         * On load success
         */
        onLoadSuccess: function() {
        },

        /**
         * Sets submit
         *
         * @param {Object} [options]
         */
        setSubmit: function (options) {
            ss.init(
                "commonComponentsFormButton",
                $.extend(
                    {},
                    options,
                    {
                        css: "btn btn-big btn-blue submit",
                        appendTo: this.window.find(".footer")
                    }
                )
            );

            return this;
        },

        /**
         * Sets footer button
         *
         * @param {Object} [options]
         */
        addFooterButton: function (options) {
            ss.init(
                "commonComponentsFormButton",
                $.extend(
                    {},
                    {
                        css: "btn btn-gray button",
                        appendTo: this.window.find(".footer")
                    },
                    options
                )
            );

            return this;
        }
    }
);