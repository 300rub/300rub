!function ($, TestS) {
    'use strict';

    TestS.Library = {
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
            return parseInt(value) || 0;
        }
    }
}(window.jQuery, window.TestS);