!function ($, TestS) {
    'use strict';

    /**
     * Abstract editor
     *
     * @param {Object} options
     *
     * @type {TestS.Panel.Design.AbstractEditor}
     */
    TestS.Panel.Design.AbstractEditor = function (options) {
        this._set(options);
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    TestS.Panel.Design.AbstractEditor.prototype = {

        /**
         * Constructor
         */
        constructor: TestS.Panel.Design.AbstractEditor,

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
         * @returns {TestS.Panel.Design.AbstractEditor}
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
         * @returns {TestS.Panel.Design.AbstractEditor}
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
         * @returns {TestS.Panel.Design.AbstractEditor}
         *
         * @private
         */
        _setDesignContainer: function () {
            this._designContainer = TestS.Components.Template.get(
                this._options.name
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
         * @returns {TestS.Panel.Design.AbstractEditor}
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
         * @returns {TestS.Panel.Design.AbstractEditor}
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
         * @returns {TestS.Panel.Design.AbstractEditor}
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
         * @returns {TestS.Panel.Design.AbstractGroup}
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
         * @returns {TestS.Panel.Design.AbstractGroup}
         *
         * @private
         */
        _setUniqueId: function () {
            this._uniqueId = TestS.Components.Library.getUniqueId();
            return this;
        },

        /**
         * Gets unique ID
         *
         * @returns {String}
         */
        getUniqueId: function () {
            return this._uniqueId;
        }
    };
}(window.jQuery, window.TestS);
