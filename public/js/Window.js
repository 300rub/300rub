!function ($, TestS) {
    'use strict';

    /**
     * Window
     *
     * @type {TestS.Window}
     */
    TestS.Window = function (options) {
        this._options = $.extend({}, options);
        this.init();
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    TestS.Window.prototype = {

        /**
         * _options
         *
         * @var {Object}
         */
        _options: {},

        /**
         * Window
         *
         * @var {Object}
         */
        $_instance: null,

        /**
         * Window
         *
         * @var {Object}
         */
        $_body: null,

        /**
         * Overlay
         *
         * @var {Object}
         */
        $_overlay: null,

        /**
         * Init
         */
        init: function () {
            this.$_instance = TestS.Template.get("window");
            this.$_body = this.$_instance.find(".body");
            this.$_overlay = TestS.Template.get("window-overlay");
            this
                ._setCloseEvents()
                ._addDomElement()
                ._loadData();

            return this;
        },

        /**
         * Gets instance
         *
         * @returns {Object}
         */
        getInstance: function() {
            return this.$_instance;
        },

        /**
         * Gets body
         *
         * @returns {Object}
         */
        getBody: function() {
            return this.$_body;
        },

        /**
         * Gets overlay
         *
         * @returns {Object}
         */
        getOverlay: function() {
            return this.$_overlay;
        },

        /**
         * Close event
         *
         * @returns {TestS.Window}
         *
         * @private
         */
        _setCloseEvents: function() {
            this.getOverlay().on("click",  $.proxy(this._removeWindow, this));
            this.getInstance().find(".header .close").on("click", $.proxy(this._removeWindow, this));

            return this;
        },

        /**
         * Removes window and overlay
         *
         * @private
         */
        _removeWindow: function() {
            this.getInstance().addClass("transparent");
            this.getOverlay().addClass("transparent");

            setTimeout($.proxy(function() {
                this.getInstance().remove();
                this.getOverlay().remove();
            }, this), 350);
        },

        /**
         * Adds element to DOM
         *
         * @returns {TestS.Window}
         *
         * @private
         */
        _addDomElement: function() {
            TestS.append(this.getInstance());
            TestS.append(this.getOverlay());

            setTimeout($.proxy(function() {
                this.getInstance().removeClass("transparent");
                this.getOverlay().removeClass("transparent");
            }, this), 50);

            return this;
        },

        /**
         * Loads data
         *
         * @private
         */
        _loadData: function() {
            new TestS.Ajax({
                data: {
                    controller: this._options.controller,
                    action: this._options.action
                },
                success: this._options.success
            });
        },

        /**
         * Sets title
         *
         * @param {String} title
         *
         * @returns {TestS.Window}
         */
        setTitle: function(title) {
            this.getInstance().find(".header .title").text(title);
            return this;
        },

        /**
         * Removes loading
         *
         * @returns {TestS.Window}
         */
        removeLoading: function() {
            this.getInstance().removeClass("loading");
            return this;
        },

        /**
         * Adds loading
         *
         * @returns {TestS.Window}
         */
        addLoading: function() {
            this.getInstance().addClass("loading");
            return this;
        },

        /**
         * Adds loading
         *
         * @param {Object} [options]
         *
         * @returns {TestS.Window}
         */
        setSubmit: function(options) {
            var submit = new TestS.Form(
                $.extend(
                    {
                        class: "submit",
                        appendTo: this.getInstance().find(".footer")
                    },
                    options
                )
            );
            return this;
        }
    };
}(window.jQuery, window.TestS);