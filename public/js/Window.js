!function ($, TestS) {
    'use strict';

    /**
     * Window
     *
     * @type {Object}
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
        $instance: null,

        /**
         * Overlay
         *
         * @var {Object}
         */
        $overlay: null,

        /**
         * Init
         */
        init: function () {
            if (TestS.hasWindow === true) {
                return this;
            }

            TestS.hasWindow = true;

            this.$instance = TestS.getTemplates().find(".window").clone();
            this.$overlay = TestS.getTemplates().find(".window-overlay").clone();
            this
                ._setCloseEvents()
                ._addDomElement()
                ._loadData();

            return this;
        },

        /**
         * Close event
         *
         * @returns {TestS.Window}
         *
         * @private
         */
        _setCloseEvents: function() {
            this.$overlay.on("click",  $.proxy(this._removeWindow, this));
            this.$instance.find(".header .close").on("click", $.proxy(this._removeWindow, this));

            return this;
        },

        /**
         * Removes window and overlay
         *
         * @private
         */
        _removeWindow: function() {
            TestS.hasWindow = false;

            this.$instance.addClass("transparent");
            this.$overlay.addClass("transparent");

            setTimeout($.proxy(function() {
                this.$instance.remove();
                this.$overlay.remove();
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
            TestS.appendToAjaxWrapper(this.$instance);
            TestS.appendToAjaxWrapper(this.$overlay);

            setTimeout($.proxy(function() {
                this.$instance.removeClass("transparent");
                this.$overlay.removeClass("transparent");
            }, this), 50);

            return this;
        },

        /**
         * Loads data
         *
         * @private
         */
        _loadData: function() {

        }
    };
}(window.jQuery, window.TestS);