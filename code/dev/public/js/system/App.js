!function ($, ss) {
    'use strict';

    /**
     * Application
     *
     * @type {Object}
     */
    ss.system.App = {

        /**
         * Wrapper
         *
         * @var {Object}
         */
        _wrapper: null,

        /**
         * Language
         *
         * @var {number}
         */
        _language: 0,

        /**
         * Section ID
         *
         * @var {number}
         */
        _sectionId: 0,

        /**
         * Token
         *
         * @var {String}
         */
        _token: "",

        /**
         * Appends to ajax wrapper
         *
         * @param {Object} object
         *
         * @returns {ss.system.App}
         */
        append: function (object) {
            this.getWrapper().append(object);
            return this;
        },

        /**
         * Removes element by class name
         *
         * @param {String} className
         *
         * @return {ss.system.App}
         */
        remove: function (className) {
            this.getWrapper().find("." + className).remove();
            return this;
        },

        /**
         * Gets wrapper
         *
         * @returns {Object}
         */
        getWrapper: function () {
            if (this._wrapper === null) {
                this._wrapper = $("#ajax-wrapper");
            }

            return this._wrapper;
        },

        /**
         * Sets language
         *
         * @param {number} language
         *
         * @returns {ss.system.App}
         */
        setLanguage: function (language) {
            this._language = language;
            return this;
        },

        /**
         * Gets language
         *
         * @returns {number}
         */
        getLanguage: function () {
            return this._language;
        },

        /**
         * Sets section ID
         *
         * @param {number} sectionId
         *
         * @returns {ss.system.App}
         */
        setSectionId: function (sectionId) {
            this._sectionId = sectionId;
            return this;
        },

        /**
         * Gets section ID
         *
         * @returns {number}
         */
        getSectionId: function () {
            return this._sectionId;
        },

        /**
         * Sets token
         *
         * @param {String} token
         *
         * @returns {ss.system.App}
         */
        setToken: function (token) {
            this._token = token;
            return this;
        },

        /**
         * Gets token
         *
         * @returns {String}
         */
        getToken: function () {
            return this._token;
        },

        /**
         * Shows error message
         *
         * @param {Object} jqXHR
         */
        showError: function (jqXHR) {
            console.log(jqXHR);
        }
    };
}(window.jQuery, window.ss);
