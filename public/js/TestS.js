!function (window) {
    'use strict';

    /**
     * Main object for application
     *
     * @type {Object}
     */
    window.TestS = {

        /**
         * Ajax wrapper
         *
         * @var {Object}
         */
        $_ajaxWrapper: null,

        /**
         * Templates
         *
         * @var {Object}
         */
        $_templates: null,

        /**
         * Gets ajax wrapper
         *
         * @returns {Object}
         */
        getAjaxWrapper: function () {
            if (this.$_ajaxWrapper === null) {
                this.$_ajaxWrapper = $("#ajax-wrapper");
            }
            return this.$_ajaxWrapper;
        },

        /**
         * Gets templates
         *
         * @returns {Object}
         */
        getTemplates: function () {
            if (this.$_templates === null) {
                this.$_templates = $("#templates");
            }
            return this.$_templates;
        },

        /**
         * Appends to ajax wrapper
         *
         * @param {Object} $object
         *
         * @returns {TestS}
         */
        appendToAjaxWrapper: function ($object)
        {
            this.getAjaxWrapper().append($object);
            return this;
        }
    }
}(window);