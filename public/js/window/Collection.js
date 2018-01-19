!function ($, TestS) {
    'use strict';

    /**
     * Window Collection
     *
     * @type {Object}
     */
    TestS.Window.Collection = {

        /**
         * Collection of windows
         *
         * @var {Object}
         */
        _instances: {},

        /**
         * Adds window to collection
         *
         * @param {String}                name
         * @param {TestS.Window.Abstract} window
         *
         * @returns {TestS}
         */
        add: function (name, window) {
            this._instances[name] = window;
            return this;
        },

        /**
         * Deletes window from collection
         *
         * @param {String} name
         *
         * @returns {TestS}
         */
        delete: function (name) {
            if (this._instances[name] !== undefined) {
                delete(this._instances[name]);
            }

            return this;
        },

        /**
         * Gets window from collection
         *
         * @param {String} name
         *
         * @returns {TestS.Window.Abstract}
         */
        get: function (name) {
            if (this._instances[name] === undefined) {
                return null;
            }

            return this._instances[name];
        }
    };
}(window.jQuery, window.TestS);