!function ($, ss) {
    'use strict';

    /**
     * Accordion element
     *
     * @param {Object} options
     *
     * @type {Object}
     */
    ss.components.accordion.Element = function (options) {
        this._options = $.extend({}, options);
        this._container = null;
        this._body = null;

        this.init();
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    ss.components.accordion.Element.prototype = {

        /**
         * Constructor
         */
        constructor: ss.components.accordion.Element,

        /**
         * Init
         */
        init: function () {
            this._container
                = ss.components.Template.get("accordion-container");
            this._body = this._container.find(".accordion-body");

            this
                ._setTitle()
                ._setBody()
                ._appendTo();
        },

        /**
         * Sets title
         *
         * @returns {ss.components.accordion.Element}
         *
         * @private
         */
        _setTitle: function() {
            if (this._options.title !== undefined) {
                this._container
                    .find(".accordion-title .text")
                    .text(this._options.title);
            }

            return this;
        },

        /**
         * Sets body
         *
         * @returns {ss.components.accordion.Element}
         *
         * @private
         */
        _setBody: function() {
            if (this._options.body !== undefined) {
                this.add(this._options.body);
            }

            return this;
        },

        /**
         * Appends element to parent
         *
         * @returns {ss.components.accordion.Element}
         *
         * @private
         */
        _appendTo: function() {
            if (this._options.appendTo !== undefined) {
                this.appendTo(this._options.appendTo);
            }

            return this;
        },

        /**
         * Adds object to the body
         *
         * @param {Object} object
         *
         * @return {ss.components.accordion.Element}
         */
        add: function (object) {
            this._body.append(object);
            return this;
        },

        /**
         * Gets body
         *
         * @return {Object}
         */
        getBody: function () {
            return this._body;
        },

        /**
         * Gets container
         *
         * @return {Object}
         */
        get: function () {
            return this._container;
        },

        /**
         * Appends container to the object
         *
         * @param {Object} object
         *
         * @return {ss.components.accordion.Element}
         */
        appendTo: function (object) {
            this._container.appendTo(object);
            return this;
        }
    };
}(window.jQuery, window.ss);
