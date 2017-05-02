!function ($, TestS) {
    'use strict';

    /**
     * Panel
     *
     * @type {TestS.Panel}
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
         * Panel
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
            this.$_body = this.$_instance.find(".body");
            this.$_userButtons = $("#user-buttons");

            this
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
         * Removes loading
         *
         * @returns {TestS.Window}
         */
        removeLoading: function() {
            this.getInstance().removeClass("loading");
            return this;
        }
    };
}(window.jQuery, window.TestS);