!function ($, TestS) {
    'use strict';

    /**
     * Template
     *
     * @type {Object}
     */
    TestS.Template = {
        /**
         * Container
         *
         * @var {Object}
         */
        $_container: null,

        /**
         * Templates
         *
         * @var {Object}
         */
        _templates: {},

        /**
         * Gets template
         *
         * @param {String} templateCssClass
         *
         * @returns {Object}
         */
        get: function(templateCssClass) {
            if (this._templates[templateCssClass] === undefined) {
                this.set(templateCssClass);
            }

            return this._templates[templateCssClass].clone();
        },

        /**
         * Sets template
         *
         * @param {String} templateCssClass
         */
        set: function(templateCssClass) {
            if (this.$_container === null) {
                this.$_container = $("#templates");
            }

            this._templates[templateCssClass] = this.$_container.find("." + templateCssClass);
        }
    };
}(window.jQuery, window.TestS);