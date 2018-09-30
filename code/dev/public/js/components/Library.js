!function ($, ss) {
    'use strict';

    ss.components.Library = {
        /**
         * Gets unique ID
         *
         * @returns {number}
         */
        getUniqueId: function() {
            return Math.round(new Date().getTime() + (Math.random() * 100));
        },

        /**
         * Gets int value
         *
         * @param {mixed} value
         *
         * @return {int}
         */
        getIntVal: function(value) {
            return parseInt(value, 10) || 0;
        }
    };
}(window.jQuery, window.ss);