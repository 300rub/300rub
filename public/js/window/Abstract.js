!function ($, TestS) {
    'use strict';

    /**
     * Abstract window
     *
     * @param {Object} options
     *
     * @type {Object}
     */
    TestS.Window.Abstract = function (options) {
        this._set(options);
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    TestS.Window.Abstract.prototype = {

        /**
         * Constructor
         */
        constructor: TestS.Window.Abstract,

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
         * Init
         *
         * @param {Object} options
         */
        _set: function (options) {
            this._window = TestS.Components.Template.get("window");
            this._body = this._window.find(".body");
            this._overlay = TestS.Components.Template.get("window-overlay");

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
         * @returns {TestS.Window.Abstract}
         */
        getParent: function () {
            if (this._options.parent === undefined) {
                return null;
            }

            return TestS.Window.Collection.get(this._options.parent);
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
         * Gets overlay
         *
         * @returns {Object}
         */
        getOverlay: function () {
            return this._overlay;
        },

        /**
         * Sets title
         *
         * @param {String} title
         *
         * @returns {TestS.Window.Abstract}
         */
        setTitle: function (title) {
            this._window.find(".header .title").text(title);
            return this;
        },

        /**
         * Sets CSS class
         *
         * @returns {TestS.Window.Abstract}
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
         * @returns {TestS.Window.Abstract}
         *
         * @private
         */
        _addToCollection: function () {
            if (this._options.name === undefined) {
                return this;
            }

            TestS.Window.Collection.add(this._options.name, this);

            var parent = this.getParent();
            if (parent !== null) {
                parent.getInstance().addClass("transparent");
            }

            return this;
        },

        /**
         * Close event
         *
         * @returns {TestS.Window.Abstract}
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
                TestS.System.App.getWrapper()
                    .find(".panel")
                    .removeClass("transparent");
            }

            setTimeout(
                $.proxy(
                    function () {
                        this._window.remove();
                        this._overlay.remove();

                        if (this._options.name !== undefined) {
                            TestS.Window.Collection.remove(
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
         * @returns {TestS.Window.Abstract}
         *
         * @private
         */
        _addDomElement: function () {
            if (this._options.level !== undefined) {
                this._window.addClass("level-" + this._options.level);
                this._overlay.addClass("level-" + this._options.level);
            }

            TestS.System.App.append(this._window);
            TestS.System.App.append(this._overlay);

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

            TestS.System.App.getWrapper()
                .find(".panel")
                .addClass("transparent");

            return this;
        },

        /**
         * Reloads the window
         *
         * @returns {TestS.Window.Abstract}
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
         * @returns {TestS.Window.Abstract}
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
         * @returns {TestS.Window.Abstract}
         */
        _loadData: function () {
            var ajaxData = {
                group: this._options.group,
                controller: this._options.controller
            };

            if ($.type(this._options.data) === "object") {
                ajaxData.data = this._options.data;
            }

            new TestS.Components.Ajax(
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
            var errorTemplate
                = TestS.Components.Error.getAjaxErrorTemplate(jqXHR);
            this._window
                .removeClass("loading")
                .addClass("error");
            this.getBody().html(errorTemplate);
        },

        /**
         * Sets submit
         *
         * @param {Object} [options]
         *
         * @returns {TestS.Window.Abstract}
         */
        setSubmit: function (options) {
            var submit = new TestS.Form.Button(
                $.extend(
                    {
                        css: "btn btn-big btn-blue submit",
                        appendTo: this._window.find(".footer")
                    },
                    options
                )
            );

            this.getBody().keypress(
                function (e) {
                    if (e.which === 13) {
                        submit.getInstance().click();
                    }
                }
            );

            return this;
        }
    };
}(window.jQuery, window.TestS);
