!function ($, ss) {
    "use strict";

    var name = "adminComponentsDesignAbstractEditor";

    var parameters = {
        /**
         * Selector
         *
         * @var {String}
         */
        selector: "",

        /**
         * Style container
         *
         * @var {Object}
         */
        cssContainer: null,

        /**
         * Editor container
         *
         * @var {Object}
         */
        editorContainer: null,

        /**
         * Values
         *
         * @var {Object}
         */
        values: {},

        /**
         * Namespace
         *
         * @var {String}
         */
        namespace: "",

        /**
         * Unique ID
         *
         * @var {Number}
         */
        uniqueId: 0,

        /**
         * Rollback styles
         *
         * @var {String}
         */
        cssToRollback: "",

        /**
         * Init
         */
        init: function () {
        },

        /**
         * Creates editor
         *
         * @param {Object} options
         */
        create: function(options) {
            this
                .extendOptions(options)
                .setLabels(this.getOption("labels"))
                .setSelector()
                .setCssContainer()
                .setEditorContainer()
                .setValues()
                .setNamespace()
                .setUniqueId()
                .setCssToRollback();
        },

        /**
         * Sets selector
         */
        setSelector: function () {
            if (this.getOption("selector") !== null) {
                this.selector = this.getOption("selector");
            }

            return this;
        },

        /**
         * Gets selector
         *
         * @returns {String}
         */
        getSelector: function () {
            return this.selector;
        },

        /**
         * Sets style container
         */
        setCssContainer: function () {
            if (this.getOption("cssContainerId") !== null) {
                this.cssContainer = $("#" + this.getOption("cssContainerId"));
            }

            return this;
        },

        /**
         * Gets style container
         *
         * @returns {Object}
         */
        getCssContainer: function () {
            return this.cssContainer;
        },

        /**
         * Sets editor container
         */
        setEditorContainer: function () {
            this.editorContainer = ss.init("template").get(
                "design-" + this.getOption("type") + "-container"
            );
            return this;
        },

        /**
         * Gets editor container
         *
         * @returns {Object}
         */
        getEditorContainer: function () {
            return this.editorContainer;
        },

        /**
         * Sets labels
         */
        setValues: function () {
            this.values = $.extend({}, this.getOption("values"));
            return this;
        },

        /**
         * Gets values
         *
         * @returns {Object}
         */
        getValues: function () {
            return this.values;
        },

        /**
         * Sets namespace
         */
        setNamespace: function () {
            this.namespace = this.getOption("namespace");
            return this;
        },

        /**
         * Gets namespace
         *
         * @returns {String}
         */
        getNamespace: function () {
            return this.namespace;
        },

        /**
         * Sets unique ID
         */
        setUniqueId: function () {
            this.uniqueId = Math.round(
                new Date().getTime() + (Math.random() * 100)
            );
            return this;
        },

        /**
         * Gets unique ID
         *
         * @returns {Number}
         */
        getUniqueId: function () {
            return this.uniqueId;
        },

        /**
         * Sets CSS to rollback
         */
        setCssToRollback: function () {
            this.cssToRollback = this.cssContainer.html();
            return this;
        },

        /**
         * Rollbacks
         */
        rollback: function () {
            this.cssContainer.html(this.cssToRollback);
        },

        /**
         * Gets data
         *
         * @returns {Object}
         */
        getData: function () {
            return {};
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
