!function ($, ss) {
    'use strict';

    /**
     * Abstract menu
     *
     * @param {Object} options
     *
     * @constructor
     */
    ss.content.menu.Abstract = function (options) {
        this._menu = $(options.selector);
    };

    /**
     * Abstract menu prototype
     *
     * @type {Object}
     */
    ss.content.menu.Abstract.prototype = {

        /**
         * Gets menu object
         *
         * @returns {Object}
         */
        getMenu: function () {
            return this._menu;
        }
    };
}(window.jQuery, window.ss);
