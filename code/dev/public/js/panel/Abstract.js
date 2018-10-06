!function ($, ss) {
    'use strict';

    /**
     * Panel
     *
     * @param {Object} options
     *
     * @type {ss.panel.Abstract}
     */
    ss.panel.Abstract = function (options) {

        
        this._userButtons = null;



        this._set(options);
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    ss.panel.Abstract.prototype = {

        /**
         * Constructor
         */
        constructor: ss.panel.Abstract,

        /**
         * Init
         *
         * @param {Object} options
         */
        _set: function (options) {
            this._userButtons = $("#user-buttons");

            this
                .setCloseEvents(null)
                .addDomElement()
                .loadData();
        },

        /**
         * Sets container's max-height
         *
         * @return {ss.panel.Abstract}
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
            var footerHeight = this.panel.find(".footer").height();

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
         * Gets instance
         *
         * @returns {Object}
         */
        getPanel: function () {
            return this.panel;
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
         *
         * @returns {ss.panel.Abstract}
         */
        setTitle: function (title) {
            this.panel.find(".header .title").text(title);
            return this;
        },

        /**
         * Sets back button
         *
         * @param {function} onClick
         *
         * @returns {ss.panel.Abstract}
         */
        setBack: function (onClick) {
            this.panel.find(".header .back")
                .removeClass("hidden")
                .on("click", onClick);

            return this;
        },

        /**
         * Sets description
         *
         * @param {String} description
         *
         * @returns {ss.panel.Abstract}
         */
        setDescription: function (description) {
            this.panel.find(".header .description").text(description);
            return this;
        },

        /**
         * Close event
         *
         * @param {function} callback
         *
         * @returns {ss.panel.Abstract}
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
            this.panel.addClass("transparent");
            this._userButtons.removeClass("hidden");

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
                        this._userButtons.removeClass("transparent");
                    },
                    this
                ),
                50
            );
        },

        /**
         * Adds element to DOM
         *
         * @returns {ss.panel.Abstract}
         *
         * @private
         */
        addDomElement: function () {
            ss.system.App.remove("panel");
            ss.system.App.append(this.panel);

            setTimeout(
                $.proxy(
                    function () {
                        this.panel.removeClass("transparent");
                        this._userButtons.addClass("transparent");
                    },
                    this
                ),
                50
            );

            setTimeout(
                $.proxy(
                    function () {
                        this._userButtons.addClass("hidden");
                    },
                    this
                ),
                300
            );

            return this;
        },

        /**
         * Loads data
         *
         * @private
         */
        loadData: function () {
            var data = {
                group: this._options.group,
                controller: this._options.controller
            };

            if ($.type(this._options.data) === "object") {
                data.data = this._options.data;
            }

            new ss.components.Ajax(
                {
                    data: data,
                    error: $.proxy(this.onError, this),
                    success: $.proxy(
                        function (data) {
                            this._options.success(data);
                            this
                                .removeLoading()
                                .setMaxHeight();
                        },
                        this
                    )
                }
            );
        },

        /**
         * On error
         *
         * @param {Object} jqXHR
         */
        onError: function (jqXHR) {
            ss.components.Error.displayAjaxError(jqXHR);
            this.removePanel();
        },

        /**
         * Removes loading
         *
         * @returns {ss.panel.Abstract}
         *
         * @private
         */
        removeLoading: function () {
            this.panel.removeClass("loading");
            return this;
        },

        /**
         * Sets submit
         *
         * @param {Object} [options]
         *
         * @returns {ss.panel.Abstract}
         */
        setSubmit: function (options) {
            var submit = new ss.forms.Button(
                $.extend(
                    {},
                    options,
                    {
                        css: "btn btn-blue",
                        appendTo: this.panel.find(".footer")
                    }
                )
            );

            return this;
        },

        /**
         * Adds header button
         *
         * @param {Object} [options]
         *
         * @returns {ss.panel.Abstract}
         */
        addHeaderButton: function (options) {
            new ss.forms.Button(
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
         *
         * @param {String} label
         *
         * @returns {ss.panel.Abstract}
         */
        showBlockSectionSwitcher: function(label) {
            new ss.forms.CheckboxOnOff(
                {
                    value: ss.system.App.getIsBlockSection(),
                    label: label,
                    css: "no-margin small",
                    appendTo: this.panel.find(".header .btn-group"),
                    onCheck: $.proxy(function() {
                        ss.system.App.setIsBlockSection(true);
                        this.reload({
                            data: {
                                blockSection: ss.system.App.getSectionId()
                            }
                        });
                    }, this),
                    onUnCheck: $.proxy(function() {
                        ss.system.App.setIsBlockSection(false);
                        this.reload({
                            data: {
                                blockSection: 0
                            }
                        });
                    }, this)
                }
            );

            return this;
        },

        /**
         * Gets block section
         *
         * @returns {int}
         */
        getBlockSection: function() {
            if (ss.system.App.getIsBlockSection() === false) {
                return 0;
            }

            return ss.system.App.getSectionId();
        },

        /**
         * Sets footer button
         *
         * @param {Object} [options]
         *
         * @returns {ss.panel.Abstract}
         */
        setFooterButton: function (options) {
            new ss.forms.Button(
                $.extend(
                    {},
                    options,
                    {
                        css: "btn btn-gray",
                        appendTo: this.panel.find(".footer")
                    }
                )
            );

            return this;
        },

        /**
         * Removes footer
         *
         * @returns {ss.panel.Abstract}
         */
        removeFooter: function() {
            this.hasFooter = false;
            this.setPanelMaxHeight();

            this.panel.find(".footer").remove();
            return this;
        },

        /**
         * Reloads the panel
         *
         * @param {Object} options
         *
         * @returns {ss.panel.Abstract}
         */
        reload: function (options) {
            this.panel.remove();
            this._set($.extend({}, this._options, options));

            return this;
        }
    };
}(window.jQuery, window.ss);
