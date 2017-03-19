!function ($, TestS) {
    'use strict';

    /**
     * Gets text form
     *
     * @param {Object} [options]
     *
     * @type {Object}
     *
     * @returns {Object}
     */
    TestS.Form.Text = function (options) {
        this._options = $.extend({}, options);
        this.init();

        return this.getInstance();
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    TestS.Form.Text.prototype = {
        /**
         * Options
         *
         * @var {Object}
         */
        _options: {},

        /**
         * Instance
         *
         * @var {Object}
         */
        $_instance: null,

        /**
         * Init
         */
        init: function () {
            this
                ._setInitialInstance()
                ._setName()
                ._appendTo();
        },

        /**
         * Gets instance
         *
         * @returns {Object}
         */
        getInstance: function () {
            return this.$_instance;
        },

        /**
         * Sets instance
         *
         * @returns {TestS.Form.Text}
         *
         * @private
         */
        _setInitialInstance: function() {
            this.$_instance = $("<input />");
            this.$_instance
                .attr("type", "text")
                .addClass("form-instance");
            return this;
        },

        /**
         * Sets name
         *
         * @returns {TestS.Form.Text}
         *
         * @private
         */
        _setName: function() {
            if (this._options.name === undefined) {
                return this;
            }

            this.$_instance.attr("name", this._options.name);
            return this;
        },

        /**
         * Appends to
         *
         * @returns {TestS.Form.Text}
         *
         * @private
         */
        _appendTo: function() {
            if (this._options.appendTo === undefined) {
                return this;
            }

            this.$_instance.appendTo(this._options.appendTo);
            return this;
        }
    };
}(window.jQuery, window.TestS);