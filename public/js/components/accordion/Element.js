!function ($, Ss) {
    'use strict';

    /**
     * Accordion element
     *
     * @param {String} title
     *
     * @type {Object}
     */
    Ss.Components.Accordion.Element = function (title) {
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
    Ss.Components.Accordion.Element.prototype = {

        /**
         * Constructor
         */
        constructor: Ss.Components.Accordion.Element,

        /**
         * Init
         */
        init: function () {
            this._container
                = Ss.Components.Template.get("accordion-container");
            this._container.find(".accordion-title .text").text(this._title);
            this._body = this._container.find(".accordion-body");
        },

        /**
         * Adds object to the body
         *
         * @param {Object} object
         *
         * @return {Ss.Components.Accordion.Element}
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
         * @return {Ss.Components.Accordion.Element}
         */
        appendTo: function (object) {
            this._container.appendTo(object);
            return this;
        }
    };
}(window.jQuery, window.Ss);
