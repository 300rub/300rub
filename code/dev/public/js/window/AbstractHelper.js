!function ($, ss) {
    'use strict';

    /**
     * Abstract window helper
     *
     * @param {Object} options
     *
     * @type {Object}
     */
    ss.window.AbstractHelper = function (options) {
        this._window = null;
        this._body = null;
        this._overlay = null;
        this._options = {};

        this._set(options);
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    ss.window.AbstractHelper.prototype = {

        /**
         * Constructor
         */
        constructor: ss.window.AbstractHelper,

        /**
         * Init
         *
         * @param {Object} options
         */
        _set: function (options) {
            this._window = ss.components.Template.get("window-helper");
            this._body = this._window.find(".body");
            this._overlay = ss.components.Template.get("window-overlay");
            this._options = $.extend({}, options);

            this
                ._setCssClass()
                ._setCloseEvents()
                ._addDomElement()
                ._setMaxHeight();

            return this;
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
         * Sets CSS class
         *
         * @returns {ss.window.AbstractHelper}
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
         * Close event
         *
         * @returns {ss.window.AbstractHelper}
         *
         * @private
         */
        _setCloseEvents: function () {
            this._overlay.on("click",  $.proxy(this.remove, this));
            this._window
                .find(".close")
                .on("click", $.proxy(this.remove, this));

            return this;
        },

        /**
         * Removes window and overlay
         */
        remove: function () {
            this._window.addClass("transparent");
            this._overlay.addClass("transparent");

            setTimeout(
                $.proxy(
                    function () {
                        this._window.remove();
                        this._overlay.remove();
                    },
                    this
                ),
                350
            );
        },

        /**
         * Adds element to DOM
         *
         * @returns {ss.window.AbstractHelper}
         *
         * @private
         */
        _addDomElement: function () {
            this._window.addClass("level-last");
            this._overlay.addClass("level-last");

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

            return this;
        },

        /**
         * Sets window's max-height
         *
         * @private
         *
         * @returns {ss.window.AbstractHelper}
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
         * Gets option
         *
         * @param {String} key
         *
         * @returns {*}
         */
        getOption: function(key) {
            if (this._options[key] === undefined) {
                return null;
            }

            return this._options[key];
        }
    };
}(window.jQuery, window.ss);
