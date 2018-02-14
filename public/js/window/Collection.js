!function ($, ss) {
    'use strict';

    /**
     * Window Collection
     *
     * @type {Object}
     */
    ss.window.Collection = {

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
         * @param {ss.window.Abstract} window
         *
         * @returns {ss}
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
         * @returns {ss}
         */
        remove: function (name) {
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
         * @returns {ss.window.Abstract}
         */
        get: function (name) {
            if (this._instances[name] === undefined) {
                return null;
            }

            return this._instances[name];
        }
    };
}(window.jQuery, window.ss);