!function ($, TestS) {
    'use strict';

    /**
     * Application
     *
     * @type {Object}
     */
    TestS.System.App = {

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
         * @returns {TestS}
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
         * @return {TestS}
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
         * @returns {TestS}
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
         * Sets token
         *
         * @param {String} token
         *
         * @returns {TestS}
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
}(window.jQuery, window.TestS);
