!function (window) {
    'use strict';

    /**
     * Main object for application
     *
     * @type {Object}
     */
    window.TestS = {
        $_ajaxWrapper: null,
        $_templates: null,

        getAjaxWrapper: function () {
            if (this.$_ajaxWrapper === null) {
                this.$_ajaxWrapper = $("#ajax-wrapper");
            }
            return this.$_ajaxWrapper;
        },

        getTemplates: function () {
            if (this.$_templates === null) {
                this.$_templates = $("#templates");
            }
            return this.$_templates;
        },

        appendToAjaxWrapper: function ($object)
        {
            this.getAjaxWrapper().append($object);
            return this;
        }
    }
}(window);