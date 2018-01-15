!function ($, TestS) {
    'use strict';

    /**
     * Errors
     *
     * @var {Object}
     */
    TestS.Components.Errors = {

        /**
         * Errors
         *
         * @var {Object}
         */
        _errors: {},

        /**
         * Sets an error
         *
         * @param {String} key
         * @param {String} value
         */
        set: function (key, value) {
            this._errors[key] = value;
        },

        /**
         * Gets an error
         *
         * @param {String} key
         *
         * @returns {String}
         */
        get: function (key) {
            if (this._errors[key] === undefined) {
                return key;
            }

            return this._errors[key];
        }
    };
}(window.jQuery, window.TestS);
