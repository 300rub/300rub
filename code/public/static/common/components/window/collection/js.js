!function ($, ss) {
    "use strict";

    var name = "commonComponentsWindowCollection";

    var parameters = {
        /**
         * Singleton flag
         *
         * @var {boolean}
         */
        isSingleton: true,

        /**
         * Collection of windows
         *
         * @var {Object}
         */
        instances: {},

        /**
         * Init
         */
        init: function () {
        },

        /**
         * Adds window to collection
         *
         * @param {String} name
         * @param {Object} window
         */
        add: function (name, window) {
            this.instances[name] = window;
            return this;
        },

        /**
         * Deletes window from collection
         *
         * @param {String} name
         */
        remove: function (name) {
            if (this.instances[name] !== undefined) {
                delete(this.instances[name]);
            }

            return this;
        },

        /**
         * Gets window from collection
         *
         * @param {String} name
         */
        get: function (name) {
            if (this.instances[name] === undefined) {
                return null;
            }

            return this.instances[name];
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
