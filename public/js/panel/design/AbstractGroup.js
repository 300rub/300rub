!function ($, TestS) {
    'use strict';

    /**
     * Abstract group
     *
     * @param {Object} options
     *
     * @type {TestS.Panel.Design.AbstractGroup}
     */
    TestS.Panel.Design.AbstractGroup = function (options) {
        this._set(options);
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    TestS.Panel.Design.AbstractGroup.prototype = {

        /**
         * Constructor
         */
        constructor: TestS.Panel.Design.AbstractGroup,

        /**
         * Style container
         *
         * @var {Object}
         */
        _designContainer: null,

        /**
         * Group container
         *
         * @var {Object}
         */
        _groupContainer: null,

        /**
         * Flag of values
         *
         * @var {boolean}
         */
        _hasValues: false,

        /**
         * Update example event
         *
         * @var {String}
         */
        _updateExampleEvent: "",

        /**
         * Labels
         *
         * @var {Object}
         */
        _labels: {},

        /**
         * Init
         *
         * @param {Object} options
         *
         * @private
         */
        _set: function (options) {
            this
                ._setDesignContainer(options.designContainer)
                ._setGroupContainer(options.groupContainerName)
                ._setValues(options.values.keys, options.values.values)
                ._checkValues()
                ._setLabels(options.labels)
                ._setTitle(options.title)
                ._setUpdateExampleEvent(options.updateExampleEvent)
                .updateExample();
        },

        /**
         * Sets design container
         *
         * @param {Object} designContainer
         *
         * @returns {TestS.Panel.Design.AbstractGroup}
         *
         * @private
         */
        _setDesignContainer: function (designContainer) {
            this._designContainer = designContainer;
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
         * Sets group container
         *
         * @param {String} groupContainerName
         *
         * @returns {TestS.Panel.Design.AbstractGroup}
         *
         * @private
         */
        _setGroupContainer: function (groupContainerName) {
            this._groupContainer
                = this._designContainer.find("." + groupContainerName);
            return this;
        },

        /**
         * Gets group container
         *
         * @returns {Object}
         */
        getGroupContainer: function () {
            return this._groupContainer;
        },

        /**
         * Sets values
         *
         * @param {Array}  keys
         * @param {Object} values
         *
         * @return {TestS.Panel.Design.AbstractGroup}
         *
         * @private
         */
        _setValues: function (keys, values) {
            this._hasValues = false;

            $.each(
                keys,
                $.proxy(
                    function (index, key) {
                        if (values[key] !== undefined) {
                            this["_" + key] = values[key];
                            this._hasValues = true;
                        }
                    },
                    this
                )
            );

            return this;
        },

        /**
         * Sets labels
         *
         * @param {Object} labels
         *
         * @return {TestS.Panel.Design.AbstractGroup}
         *
         * @private
         */
        _setLabels: function (labels) {
            this._labels = $.extend({}, labels);
            return this;
        },

        /**
         * Gets label
         *
         * @param {String} key
         *
         * @returns {String}
         */
        getLabel: function (key) {
            if (this._labels[key] !== undefined) {
                return this._labels[key];
            }

            return "";
        },

        /**
         * Checks values
         *
         * @returns {TestS.Panel.Design.AbstractGroup}
         *
         * @private
         */
        _checkValues: function () {
            if (this._hasValues === false) {
                this._groupContainer.remove();
            }

            return this;
        },

        /**
         * Sets title
         *
         * @param {String} title
         *
         * @private
         */
        _setTitle: function (title) {
            if (title !== undefined) {
                this._groupContainer
                    .find(".category-title")
                    .text(title);
            }

            return this;
        },

        /**
         * Sets update example event
         *
         * @param {String} updateExampleEvent
         *
         * @returns {TestS.Panel.Design.AbstractGroup}
         *
         * @private
         */
        _setUpdateExampleEvent: function (updateExampleEvent) {
            this._updateExampleEvent = updateExampleEvent;
            return this;
        },

        /**
         * Updates the example CSS
         */
        updateExample: function () {
            this._designContainer.trigger(this._updateExampleEvent);
        },

        /**
         * Updates block CSS
         */
        update: function () {
            this._designContainer.trigger("update");
            this.updateExample();
        },

        /**
         * Generates CSS
         *
         * @returns {String}
         */
        generateCss: function () {
            return "";
        },

        /**
         * Flag of animation
         *
         * @returns {boolean}
         */
        hasAnimation: function () {
            return false;
        }
    };
}(window.jQuery, window.TestS);
