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
         * Init
         *
         * @param {Object} options
         *
         * @private
         */
        _set: function(options) {
            this
                ._setSelector(options.selector)
                ._setStyleContainer(options.cssId)
                ._setDesignContainer(options.name)
                ._setRollback()
        },

        /**
         * Sets selector
         *
         * @returns {TestS.Panel.Design.AbstractEditor}
         *
         * @private
         */
        _setSelector: function(selector) {
            if (selector !== undefined) {
                this._selector = selector;
            }

            return this;
        },

        /**
         * Gets selector
         *
         * @returns {String}
         */
        getSelector: function() {
            return this._selector;
        },

        /**
         * Sets style container
         *
         * @returns {TestS.Panel.Design.AbstractEditor}
         *
         * @private
         */
        _setStyleContainer: function(cssId) {
            if (cssId !== undefined) {
                this._styleContainer = $("#" + cssId);
            }

            return this;
        },

        /**
         * Gets style container
         *
         * @returns {Object}
         */
        getStyleContainer: function() {
            return this._styleContainer;
        },

        /**
         * Sets design container
         *
         * @param {String} name
         *
         * @returns {TestS.Panel.Design.AbstractEditor}
         *
         * @private
         */
        _setDesignContainer: function(name) {
            this._designContainer = TestS.Components.Template.get(name);
            return this;
        },

        /**
         * Gets design container
         *
         * @returns {Object}
         */
        getDesignContainer: function() {
            return this._designContainer;
        },

        /**
         * Sets rollback styles
         *
         * @returns {TestS.Panel.Design.AbstractEditor}
         *
         * @private
         */
        _setRollback: function() {
            this._rollbackStyles = this._styleContainer.html();

            return this;
        },

        /**
         * Rollbacks
         */
        rollback: function() {
            this._styleContainer.html(this._rollbackStyles);
        }
    };
}(window.jQuery, window.TestS);
