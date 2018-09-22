!function ($, ss) {
    'use strict';

    /**
     * Abstract window
     *
     * @param {Object} options
     *
     * @type {Object}
     */
    ss.window.Abstract = function (options) {
        this._window = null;
        this._body = null;
        this._overlay = null;
        this._options = {};

        this._hasFooter = true;

        this._set(options);
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    ss.window.Abstract.prototype = {

        /**
         * Constructor
         */
        constructor: ss.window.Abstract,

        /**
         * Init
         *
         * @param {Object} options
         */
        _set: function (options) {
            this._window = ss.components.Template.get("window");
            this._body = this._window.find(".body");
            this._overlay = ss.components.Template.get("window-overlay");
            this._options = $.extend({}, options);

            this
                ._setCssClass()
                ._addToCollection()
                ._setCloseEvents()
                ._addDomElement()
                ._loadData()
                ._setMaxHeight();

            return this;
        },

        /**
         * Gets parent
         *
         * @returns {ss.window.Abstract}
         */
        getParent: function () {
            if (this._options.parent === undefined) {
                return null;
            }

            return ss.window.Collection.get(this._options.parent);
        },

        /**
         * Gets window
         *
         * @returns {Object}
         */
        getWindow: function () {
            return this._window;
        },

        /**
         * Gets body
         *
         * @returns {Object}
         */
        getBody: function () {
            return this._body;
        },

        /**
         * Sets title
         *
         * @param {String} title
         *
         * @returns {ss.window.Abstract}
         */
        setTitle: function (title) {
            this._window.find(".header .title").text(title);
            return this;
        },

        /**
         * Sets CSS class
         *
         * @returns {ss.window.Abstract}
         *
         * @private
         */
        _setCssClass: function () {
            if (this._options.name === undefined) {
                return this;
            }

            this._window.addClass("window-" + this._options.name);

            return this;
        },

        /**
         * Adds window to the collection
         *
         * @returns {ss.window.Abstract}
         *
         * @private
         */
        _addToCollection: function () {
            if (this._options.name === undefined) {
                return this;
            }

            ss.window.Collection.add(this._options.name, this);

            var parent = this.getParent();
            if (parent !== null) {
                parent.getWindow().addClass("transparent");
            }

            return this;
        },

        /**
         * Close event
         *
         * @returns {ss.window.Abstract}
         *
         * @private
         */
        _setCloseEvents: function () {
            this._overlay.on("click",  $.proxy(this._checkUnsavedAndClose, this));
            this._window
                .find(".header .close")
                .on("click", $.proxy(this._checkUnsavedAndClose, this));

            return this;
        },

        /**
         * Checks unsaved
         *
         * @private
         */
        _checkUnsavedAndClose: function() {
            if (this._body.find(".form-changed").length === 0) {
                this.remove(false);
                return this;
            }

            var confirmedWindow
                = this._window.find(".window-confirm-unsaved");

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

            this._window.append(confirmedWindow);

            return this;
        },

        /**
         * Removes window and overlay
         */
        remove: function (isReloadParent) {
            this._window.addClass("transparent");
            this._overlay.addClass("transparent");

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
                        this._window.remove();
                        this._overlay.remove();

                        if (this._options.name !== undefined) {
                            ss.window.Collection.remove(
                                this._options.name
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
         *
         * @returns {ss.window.Abstract}
         *
         * @private
         */
        _addDomElement: function () {
            if (this._options.level !== undefined) {
                this._window.addClass("level-" + this._options.level);
                this._overlay.addClass("level-" + this._options.level);
            }

            ss.system.App.append(this._window);
            ss.system.App.append(this._overlay);

            setTimeout(
                $.proxy(
                    function () {
                        this._window.removeClass("transparent");
                        this._overlay.removeClass("transparent");
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
         *
         * @returns {ss.window.Abstract}
         */
        reload: function () {
            this._window.remove();
            this._overlay.remove();
            this._set(this._options);

            return this;
        },

        /**
         * Sets window's max-height
         *
         * @private
         *
         * @returns {ss.window.Abstract}
         */
        _setMaxHeight: function () {
            this._setWindowMaxHeight();

            $(window).resize(
                $.proxy(
                    function () {
                        this._setWindowMaxHeight();
                    },
                    this
                )
            );

            return this;
        },

        /**
         * Sets window's max-height
         *
         * @private
         */
        _setWindowMaxHeight: function () {
            var minusHeight = 148;
            if (this._hasFooter === false) {
                minusHeight = 90;
            }

            this._body.css(
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
         *
         * @private
         *
         * @returns {ss.window.Abstract}
         */
        _loadData: function () {
            var ajaxData = {
                group: this._options.group,
                controller: this._options.controller
            };

            if ($.type(this._options.data) === "object") {
                ajaxData.data = this._options.data;
            }

            new ss.components.Ajax(
                {
                    data: ajaxData,
                    success: $.proxy(this._onLoadSuccess, this),
                    error: $.proxy(this._onLoadError, this)
                }
            );

            return this;
        },

        /**
         * On load success
         *
         * @param {Object} data
         */
        _onLoadSuccess: function (data) {
            this._options.success(data);
            this._window.removeClass("loading");
        },

        /**
         * On load error
         *
         * @param {Object} jqXHR
         */
        _onLoadError: function (jqXHR) {
            ss.components.Error.displayAjaxError(jqXHR);
            this.remove();
        },

        /**
         * Sets submit
         *
         * @param {Object} [options]
         *
         * @returns {ss.window.Abstract}
         */
        setSubmit: function (options) {
            var submit = new ss.forms.Button(
                $.extend(
                    {
                        css: "btn btn-big btn-blue submit",
                        appendTo: this._window.find(".footer")
                    },
                    options
                )
            );

            return this;
        },

        /**
         * Removes footer
         *
         * @returns {ss.window.Abstract}
         */
        removeFooter: function() {
            this._hasFooter = false;
            this._setWindowMaxHeight();

            this._window.find(".footer").remove();
            return this;
        }
    };
}(window.jQuery, window.ss);
