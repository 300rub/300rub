!function ($, ss) {
    "use strict";

    var name = "template";

    var parameters = {
        /**
         * Singleton flag
         *
         * @var {boolean}
         */
        isSingleton: true,

        /**
         * Container
         *
         * @var {Object}
         */
        container: null,

        /**
         * Templates
         *
         * @var {Object}
         */
        templates: {},

        /**
         * Init
         */
        init: function () {
            this.container = null;
            this.templates = {};
        },

        /**
         * Gets template
         *
         * @param {String} templateCssClass
         *
         * @returns {Object}
         */
        get: function (templateCssClass) {
            if (this.templates[templateCssClass] === undefined) {
                this.set(templateCssClass);
            }

            return this.templates[templateCssClass].clone();
        },

        /**
         * Sets template
         *
         * @param {String} templateCssClass
         */
        set: function (templateCssClass) {
            if (this.container === null) {
                this.container = $("#templates");
            }

            this.templates[templateCssClass]
                = this.container.find("." + templateCssClass);
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
