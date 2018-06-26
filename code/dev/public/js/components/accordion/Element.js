!function ($, ss) {
    'use strict';

    /**
     * Accordion element
     *
     * @param {String} title
     *
     * @type {Object}
     */
    ss.components.accordion.Element = function (title) {
        this._title = title;
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
            this._container.find(".accordion-title .text").text(this._title);
            this._body = this._container.find(".accordion-body");
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