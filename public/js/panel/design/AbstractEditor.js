!function ($, ss) {
    'use strict';

    /**
     * Abstract editor
     *
     * @param {Object} options
     *
     * @type {ss.panel.design.AbstractEditor}
     */
    ss.panel.design.AbstractEditor = function (options) {
        this._set(options);
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    ss.panel.design.AbstractEditor.prototype = {

        /**
         * Constructor
         */
        constructor: ss.panel.design.AbstractEditor,

        /**
         * Options
         *
         * @var {Object}
         */
        _options: {},

        /**
         * Selector
         *
         * @var {String}
         */
        _selector: "",

        /**
         * Style container
         *
         * @var {Object}
         */
        _styleContainer: null,

        /**
         * Style container
         *
         * @var {Object}
         */
        _designContainer: null,

        /**
         * Rollback styles
         *
         * @var {String}
         */
        _rollbackStyles: "",

        /**
         * Labels
         *
         * @var {Object}
         */
        _labels: {},

        /**
         * Values
         *
         * @var {Object}
         */
        _values: {},

        /**
         * Namespace
         *
         * @var {String}
         */
        _namespace: "",

        /**
         * Unique ID
         *
         * @var {String}
         */
        _uniqueId: "",

        /**
         * Init
         *
         * @param {Object} options
         *
         * @private
         */
        _set: function (options) {
            this._options = $.extend({}, options);

            this
                ._setSelector()
                ._setStyleContainer()
                ._setDesignContainer()
                ._setLabels()
                ._setValues()
                ._setNamespace()
                ._setUniqueId()
                ._setRollback();
        },

        /**
         * Sets selector
         *
         * @returns {ss.panel.design.AbstractEditor}
         *
         * @private
         */
        _setSelector: function () {
            if (this._options.selector !== undefined) {
                this._selector = this._options.selector;
            }

            return this;
        },

        /**
         * Gets selector
         *
         * @returns {String}
         */
        getSelector: function () {
            return this._selector;
        },

        /**
         * Sets style container
         *
         * @returns {ss.panel.design.AbstractEditor}
         *
         * @private
         */
        _setStyleContainer: function () {
            if (this._options.cssId !== undefined) {
                this._styleContainer = $("#" + this._options.cssId);
            }

            return this;
        },

        /**
         * Gets style container
         *
         * @returns {Object}
         */
        getStyleContainer: function () {
            return this._styleContainer;
        },

        /**
         * Sets design container
         *
         * @returns {ss.panel.design.AbstractEditor}
         *
         * @private
         */
        _setDesignContainer: function () {
            this._designContainer = ss.components.Template.get(
                "design-" + this._options.type + "-container"
            );
            return this;
        },

        /**
         * Gets design container
         *
         * @returns {Object}
         */
        getDesignContainer: function () {
            return this._designContainer;
        },

        /**
         * Sets rollback styles
         *
         * @returns {ss.panel.design.AbstractEditor}
         *
         * @private
         */
        _setRollback: function () {
            this._rollbackStyles = this._styleContainer.html();

            return this;
        },

        /**
         * Rollbacks
         */
        rollback: function () {
            this._styleContainer.html(this._rollbackStyles);
        },

        /**
         * Sets labels
         *
         * @returns {ss.panel.design.AbstractEditor}
         *
         * @private
         */
        _setLabels: function () {
            this._labels = $.extend({}, this._options.labels);
            return this;
        },

        /**
         * Gets labels
         *
         * @returns {Object}
         */
        getLabels: function () {
            return this._labels;
        },

        /**
         * Sets labels
         *
         * @returns {ss.panel.design.AbstractEditor}
         *
         * @private
         */
        _setValues: function () {
            this._values = $.extend({}, this._options.values);
            return this;
        },

        /**
         * Gets values
         *
         * @returns {Object}
         */
        getValues: function () {
            return this._values;
        },

        /**
         * Sets namespace
         *
         * @returns {ss.panel.design.AbstractEditor}
         *
         * @private
         */
        _setNamespace: function () {
            if (this._options.namespace !== undefined) {
                this._namespace = this._options.namespace;
            }

            return this;
        },

        /**
         * Gets namespace
         *
         * @returns {String}
         */
        getNamespace: function () {
            return this._namespace;
        },

        /**
         * Sets unique ID
         *
         * @returns {ss.panel.design.AbstractEditor}
         *
         * @private
         */
        _setUniqueId: function () {
            this._uniqueId = ss.components.Library.getUniqueId();
            return this;
        },

        /**
         * Gets unique ID
         *
         * @returns {String}
         */
        getUniqueId: function () {
            return this._uniqueId;
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
}(window.jQuery, window.ss);
