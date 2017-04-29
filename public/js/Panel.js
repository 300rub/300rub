!function ($, TestS) {
    'use strict';

    /**
     * Panel
     *
     * @type {TestS.Window}
     */
    TestS.Panel = function (options) {
        this._options = $.extend({}, options);
        this.init();
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    TestS.Panel.prototype = {

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
         * User buttons
         *
         * @var {Object}
         */
        $_userButtons: null,

        /**
         * Init
         */
        init: function () {
            this.$_instance = TestS.Template.get("panel");
            this.$_userButtons = $("#user-buttons");

            this
                ._setCloseEvents()
                ._addDomElement();

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
         * Close event
         *
         * @returns {TestS.Panel}
         *
         * @private
         */
        _setCloseEvents: function() {
            this.getInstance().find(".header .close").on("click", $.proxy(this._removePanel, this));

            return this;
        },

        /**
         * Removes panel
         *
         * @private
         */
        _removePanel: function() {
            this.getInstance().addClass("transparent");
            this.$_userButtons.removeClass("hidden");


            setTimeout($.proxy(function() {
                this.getInstance().remove();
            }, this), 300);

            setTimeout($.proxy(function() {
                this.$_userButtons.removeClass("transparent");
            }, this), 50);
        },

        /**
         * Adds element to DOM
         *
         * @returns {TestS.Panel}
         *
         * @private
         */
        _addDomElement: function() {
            TestS.append(this.getInstance());

            setTimeout($.proxy(function() {
                this.getInstance().removeClass("transparent");
                this.$_userButtons.addClass("transparent");
            }, this), 50);

            setTimeout($.proxy(function() {
                this.$_userButtons.addClass("hidden");
            }, this), 300);

            return this;
        }
    };
}(window.jQuery, window.TestS);