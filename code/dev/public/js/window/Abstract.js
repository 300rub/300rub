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
         * Window instance
         *
         * @var {Object}
         */
        _window: null,

        /**
         * Body
         *
         * @var {Object}
         */
        _body: null,

        /**
         * Overlay
         *
         * @var {Object}
         */
        _overlay: null,

        /**
         * Options
         *
         * @var {Object}
         */
        _options: {},

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
            this._overlay.on("click",  $.proxy(this.remove, this));
            this._window
                .find(".header .close")
                .on("click", $.proxy(this.remove, this));

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
            this._body.css(
                "max-height",
                $.proxy(
                    function () {
                        return ($(window).outerHeight() - 148);
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

            this._body.keypress(
                function (e) {
                    if (e.which === 13) {
                        submit.getForm().click();
                    }
                }
            );

            return this;
        }
    };
}(window.jQuery, window.ss);
