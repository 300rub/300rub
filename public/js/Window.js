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
         * Body
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
                ._setNameAndAddToCollection()
                ._setCloseEvents()
                ._addDomElement()
                ._loadData();

            this._setMaxHeight();
            $(window).resize($.proxy(function () {
                this._setMaxHeight();
            }, this));

            return this;
        },

        /**
         * Sets container's max-height
         *
         * @private
         */
        _setMaxHeight: function() {
            this.$_body.css("max-height", $.proxy(function () {
                return $(window).outerHeight() - 148;
            }, this));
        },

        /**
         * Sets window name (class) and adds to the collection
         *
         * @returns {TestS.Window}
         *
         * @private
         */
        _setNameAndAddToCollection: function() {
            if (this._options.name === undefined) {
                return this;
            }

            this.getInstance().addClass("window-" + this._options.name);

            TestS.Window.Collection.add(this._options.name, this);

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

                if (this._options.name !== undefined) {
                    TestS.Window.Collection.delete(this._options.name);
                }
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
                success: this._options.success,
                error: $.proxy(this.onError, this)
            });
        },

        /**
         * On error
         *
         * @param {Object} jqXHR
         */
        onError: function (jqXHR) {
            var $errorTemplate = TestS.Ajax.getErrorTemplate(jqXHR);
            this.getInstance()
                .removeClass("loading")
                .addClass("error");
            this.getBody().html($errorTemplate);
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

            this.getBody().keypress(function(e) {
                if (e.which === 13) {
                    submit.getInstance().click();
                }
            });

            return this;
        }
    };
}(window.jQuery, window.TestS);