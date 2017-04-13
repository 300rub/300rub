!function (window) {
    'use strict';

    /**
     * Main object for application
     *
     * @type {Object}
     */
    window.TestS = {

        /**
         * Wrapper
         *
         * @var {Object}
         */
        $_wrapper: null,

        /**
         * Language
         *
         * @var {number}
         */
        _language: 0,

        /**
         * Sets language
         *
         * @param {number} language
         *
         * @returns {TestS}
         */
        setLanguage: function(language) {
            this._language = language;
            return this;
        },

        /**
         * Gets language
         *
         * @returns {number}
         */
        getLanguage: function() {
            return this._language;
        },

        /**
         * Appends to ajax wrapper
         *
         * @param {Object} $object
         *
         * @returns {TestS}
         */
        append: function ($object) {
            if (this.$_wrapper === null) {
                this.$_wrapper = $("#ajax-wrapper");
            }

            this.$_wrapper.append($object);
            return this;
        }
    }
}(window);