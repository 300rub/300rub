!function ($, ss) {
    "use strict";

    var name = "adminComponentsPanel";

    var parameters = {
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
         * Footer
         *
         * @var {Object}
         */
        footer: null,

        /**
         * Footer flag
         *
         * @var {Object}
         */
        hasFooter: true,

        /**
         * Init
         */
        init: function () {
        },

        /**
         * Creates a panel
         *
         * @param {Object} options
         */
        create: function (options) {
            this
                .setPanel()
                .setBody()
                .setFooter()
                .extendOptions(options)
                .setHasFooter()
                .setHasHeaderButtons()
                .setBack(null)
                .setCloseEvents(this.getOption("closeEvents"))
                .addDomElement()
                .load();
        },

        /**
         * Sets panel
         */
        setPanel: function () {
            this.panel = ss.init("template").get("panel");
            return this;
        },

        /**
         * Sets body
         */
        setBody: function () {
            this.body = this.panel.find(".body");
            return this;
        },

        /**
         * Sets body
         */
        setFooter: function () {
            this.footer = this.panel.find(".footer");
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
         * Gets footer
         *
         * @returns {Object}
         */
        getFooter: function () {
            return this.footer;
        },

        /**
         * Sets container's max-height
         */
        setMaxHeight: function () {
            this.setPanelMaxHeight();
            $(window).resize(
                $.proxy(
                    function () {
                        this.setPanelMaxHeight();
                    },
                    this
                )
            );

            return this;
        },

        /**
         * Sets container's max-height
         */
        setPanelMaxHeight: function () {
            var headerHeight = this.panel.find(".header").height();
            var footerHeight = this.footer.height();

            var minusHeight = 40;
            if (this.hasFooter === false) {
                footerHeight = 0;
            }

            var maxHeight = $(window).outerHeight();
            maxHeight -= headerHeight;
            maxHeight -= footerHeight;
            maxHeight -= minusHeight;

            this.body.css(
                "max-height",
                function () {
                    return maxHeight;
                }
            );
        },

        /**
         * Sets back button
         *
         * @param {function} onBack
         */
        setBack: function (onBack) {
            if ($.type(onBack) !== "function") {
                onBack = this.getOption("back");
            }

            if ($.type(onBack) !== "function") {
                return this;
            }

            this.panel.find(".header .back")
                .removeClass("hidden")
                .on("click", onBack);

            return this;
        },

        /**
         * Sets title
         */
        setTitle: function () {
            this.panel
                .find(".header .title")
                .text(this.getData("title"));
            return this;
        },

        /**
         * Sets description
         */
        setDescription: function () {
            this.panel
                .find(".header .description")
                .text(this.getData("description"));
            return this;
        },

        /**
         * Close event
         *
         * @param {function} callback
         */
        setCloseEvents: function (callback) {
            this.panel.find(".header .close").off().on(
                "click",
                $.proxy(
                    function () {
                        if ($.type(callback) === "function") {
                            callback();
                        }

                        this.removePanel();
                    },
                    this
                )
            );

            return this;
        },

        /**
         * Removes panel
         */
        removePanel: function () {
            var controlButtons
                = ss.init("app").getDomElement("controlButtons");

            this.panel.addClass("transparent");
            controlButtons.removeClass("hidden");

            setTimeout(
                $.proxy(
                    function () {
                        this.panel.remove();
                    },
                    this
                ),
                300
            );

            setTimeout(
                $.proxy(
                    function () {
                        controlButtons.removeClass("transparent");
                    },
                    this
                ),
                50
            );
        },

        /**
         * Adds element to DOM
         */
        addDomElement: function () {
            var app = ss.init("app");
            var controlButtons = app.getDomElement("controlButtons");

            app.remove("panel");
            app.append(this.panel);

            setTimeout(
                $.proxy(
                    function () {
                        this.panel.removeClass("transparent");
                        controlButtons.addClass("transparent");
                    },
                    this
                ),
                50
            );

            setTimeout(
                $.proxy(
                    function () {
                        controlButtons.addClass("hidden");
                    },
                    this
                ),
                300
            );

            return this;
        },

        /**
         * Loads data
         */
        load: function () {
            var data = $.extend(
                {},
                this.getOption("data", {}),
                {
                    blockSection: this.getBlockSection()
                }
            );

            ss.init(
                "ajax",
                {
                    data: {
                        group: this.getOption("group"),
                        controller: this.getOption("controller"),
                        data: data
                    },
                    error: $.proxy(this.onError, this),
                    success: $.proxy(
                        function (data) {
                            this
                                .setData(data)
                                .setTitle()
                                .setDescription();

                            var switcher
                                = this.getOption("hasBlockSectionSwitcher");
                            if (switcher === true) {
                                this.showBlockSectionSwitcher();
                            }

                            this.onLoadSuccess();

                            this
                                .removeLoading()
                                .setMaxHeight();
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
        onLoadSuccess: function () {
        },

        /**
         * On error
         *
         * @param {Object} jqXHR
         */
        onError: function (jqXHR) {
            ss.init("commonComponentsError").displayAjaxError(jqXHR);
            this.removePanel();
        },

        /**
         * Removes loading
         */
        removeLoading: function () {
            this.panel.removeClass("loading");
            return this;
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
                        css: "btn btn-blue",
                        appendTo: this.footer
                    }
                )
            );

            return this;
        },

        /**
         * Sets header buttons
         */
        setHasHeaderButtons: function () {
            if (this.getOption("hasHeaderButtons") === false) {
                this.removeHeaderButtons();
            }

            return this;
        },

        /**
         * Removes header buttons
         */
        removeHeaderButtons: function () {
            this.panel.find(".header .btn-group").remove();
            return this;
        },

        /**
         * Adds header button
         *
         * @param {Object} [options]
         */
        addHeaderButton: function (options) {
            ss.init(
                "commonComponentsFormButton",
                $.extend(
                    {},
                    options,
                    {
                        appendTo: this.panel.find(".header .btn-group")
                    }
                )
            );

            return this;
        },

        /**
         * Shows block section switcher
         */
        showBlockSectionSwitcher: function () {
            var app = ss.init("app");

            ss.init(
                "commonComponentsFormCheckboxOnOff",
                {
                    value: app.getIsBlockSection(),
                    label: this.getLabel("blockSection"),
                    css: "no-margin small",
                    appendTo: this.panel.find(".header .btn-group"),
                    onCheck: $.proxy(
                        function () {
                            app.setIsBlockSection(true);
                            this.reload(
                                {
                                    data: {
                                        blockSection: app.getSectionId()
                                    }
                                }
                            );
                        },
                        this
                    ),
                onUnCheck: $.proxy(
                    function () {
                            app.setIsBlockSection(false);
                            this.reload(
                                {
                                    data: {
                                        blockSection: 0
                                    }
                                }
                            );
                    },
                    this
                )
                }
            );

            return this;
        },

        /**
         * Gets block section
         *
         * @returns {int}
         */
        getBlockSection: function () {
            var app = ss.init("app");

            if (app.getIsBlockSection() === false) {
                return 0;
            }

            return app.getSectionId();
        },

        /**
         * Sets footer button
         *
         * @param {Object} [options]
         */
        setFooterButton: function (options) {
            ss.init(
                "commonComponentsFormButton",
                $.extend(
                    {},
                    options,
                    {
                        css: "btn btn-gray",
                        appendTo: this.footer
                    }
                )
            );

            return this;
        },

        /**
         * Sets footer
         */
        setHasFooter: function () {
            this.hasFooter = true;

            if (this.getOption("hasFooter") !== false) {
                return this;
            }

            this.removeFooter();

            return this;
        },

        /**
         * Removes footer
         */
        removeFooter: function () {
            this.hasFooter = false;
            this.footer.remove();

            this.setMaxHeight();

            return this;
        },

        /**
         * Reloads the panel
         *
         * @param {Object} options
         */
        reload: function (options) {
            this.panel.remove();
            this.create(options);

            return this;
        },

        /**
         * Adds list item
         *
         * @param {Object} itemOptions
         */
        addListItem: function (itemOptions) {
            itemOptions = $.extend({}, itemOptions);

            var listItem = ss.init("template").get("panel-list-item");

            var item = listItem.find(".item");
            if (itemOptions.label !== undefined) {
                item.find(".text").text(itemOptions.label);
            }

            if (itemOptions.icon !== undefined) {
                item.find(".icon").addClass(itemOptions.icon);
            }

            if ($.type(itemOptions.open) === "function") {
                item.on(
                    "click",
                    itemOptions.open
                );
            }

            var hasSettings = false;
            var settingsButton = listItem.find(".settings");
            if ($.type(itemOptions.settings) === "function") {
                settingsButton.on(
                    "click",
                    itemOptions.settings
                );
                hasSettings = true;
            } else {
                settingsButton.remove();
            }

            var hasDesign = false;
            var designButton = listItem.find(".design");
            if ($.type(itemOptions.design) === "function") {
                designButton.on(
                    "click",
                    itemOptions.design
                );
                hasDesign = true;
            } else {
                designButton.remove();
            }

            if (hasSettings === false
                && hasDesign === false
            ) {
                listItem.addClass("without-buttons");
            }

            this.body.append(listItem);
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
