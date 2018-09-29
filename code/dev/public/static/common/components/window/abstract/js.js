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
            this.window = ss.components.Template.get("window");
            this.body = this.window.find(".body");
            this.overlay = ss.components.Template.get("window-overlay");
            this.hasFooter = true;

            this
                .setCssClass()
                .addToCollection()
                .setCloseEvents()
                .addDomElement()
                .loadData()
                .setMaxHeight();
        },

        /**
         * Gets parent
         */
        getParent: function () {
            if (this.getOption("parent") === null) {
                return null;
            }

            return ss.window.Collection.get(this.getOption("parent"));
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
         * Sets title
         *
         * @param {String} title
         */
        setTitle: function (title) {
            this.window.find(".header .title").text(title);
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

            ss.window.Collection.add(this.getOption("name"), this);

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
                = ss.components.Template.get("window-confirm-unsaved");

            var buttons = confirmedWindow.find(".buttons");

            new ss.forms.Button(
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

            new ss.forms.Button(
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
                ss.system.App.getWrapper()
                    .find(".panel")
                    .removeClass("transparent");
            }

            setTimeout(
                $.proxy(
                    function () {
                        this.window.remove();
                        this.overlay.remove();

                        if (this.getOption("name") !== null) {
                            ss.window.Collection.remove(
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
            if (this.getOption("level") !== null) {
                this.window.addClass("level-" + this.getOption("level"));
                this.overlay.addClass("level-" + this.getOption("level"));
            }

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

            ss.system.App.getWrapper()
                .find(".panel")
                .addClass("transparent");

            return this;
        },

        /**
         * Reloads the window
         */
        reload: function () {
            this.window.remove();
            this.overlay.remove();
            this._set(this.getOptions());

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
        loadData: function () {
            var ajaxData = {
                group: this.getOption("group"),
                controller: this.getOption("controller")
            };

            if ($.type(this.getOption("data")) === "object") {
                ajaxData.data = this.getOption("data");
            }

            new ss.components.Ajax(
                {
                    data: ajaxData,
                    success: $.proxy(this.onLoadSuccess, this),
                    error: $.proxy(this.onLoadError, this)
                }
            );

            return this;
        },

        /**
         * On load success
         *
         * @param {Object} data
         */
        onLoadSuccess: function (data) {
            var success = this.getOption("success");
            if ($.type(success) === "function") {
                success(data);
            }

            this.window.removeClass("loading");
        },

        /**
         * On load error
         *
         * @param {Object} jqXHR
         */
        onLoadError: function (jqXHR) {
            ss.components.Error.displayAjaxError(jqXHR);
            this.remove();
        },

        /**
         * Sets submit
         *
         * @param {Object} [options]
         */
        setSubmit: function (options) {
            var submit = new ss.forms.Button(
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
         * Removes footer
         */
        removeFooter: function() {
            this.hasFooter = false;
            this.setWindowMaxHeight();

            this.window.find(".footer").remove();
            return this;
        },

        /**
         * Sets footer button
         *
         * @param {Object} [options]
         */
        addFooterButton: function (options) {
            new ss.forms.Button(
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