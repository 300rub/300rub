!function ($, Ss) {
    'use strict';

    /**
     * Abstract group
     *
     * @param {Object} options
     *
     * @type {Ss.Panel.Design.AbstractGroup}
     */
    Ss.Panel.Design.AbstractGroup = function (options) {
        this._set(options);
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    Ss.Panel.Design.AbstractGroup.prototype = {

        /**
         * Constructor
         */
        constructor: Ss.Panel.Design.AbstractGroup,

        /**
         * Options
         *
         * @var {Object}
         */
        _options: {},

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
         * Namespace
         *
         * @var {String}
         */
        _namespace: "",

        /**
         * Fields
         *
         * @var {Array}
         */
        fields: [],

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
                ._setDesignContainer()
                ._setGroupContainer()
                ._setValues()
                ._checkValues()
                ._setLabels()
                ._setTitle()
                ._setNamespace()
                ._setUpdateExampleEvent()
                .updateExample();
        },

        /**
         * Sets design container
         *
         * @returns {Ss.Panel.Design.AbstractGroup}
         *
         * @private
         */
        _setDesignContainer: function () {
            this._designContainer = this._options.designContainer;
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
         * @returns {Ss.Panel.Design.AbstractGroup}
         *
         * @private
         */
        _setGroupContainer: function () {
            this._groupContainer = this._designContainer.find(
                "." + this._options.groupContainerName
            );
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
         * @return {Ss.Panel.Design.AbstractGroup}
         *
         * @private
         */
        _setValues: function () {
            this._hasValues = false;

            $.each(
                this.fields,
                $.proxy(
                    function (index, key) {
                        if (this._options.values[key] !== undefined) {
                            this["_" + key] = this._options.values[key];
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
         * @return {Ss.Panel.Design.AbstractGroup}
         *
         * @private
         */
        _setLabels: function () {
            this._labels = $.extend({}, this._options.labels);
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
         * @returns {Ss.Panel.Design.AbstractGroup}
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
         * @private
         */
        _setTitle: function () {
            if (this._options.title !== undefined) {
                this._groupContainer
                    .find(".category-title")
                    .text(this._options.title);
            }

            return this;
        },

        /**
         * Sets update example event
         *
         * @returns {Ss.Panel.Design.AbstractGroup}
         *
         * @private
         */
        _setUpdateExampleEvent: function () {
            this._updateExampleEvent = this._options.updateExampleEvent;
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
        },

        /**
         * Sets namespace
         *
         * @returns {Ss.Panel.Design.AbstractGroup}
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
         * Gets data
         *
         * @returns {Object}
         */
        getData: function () {
            var data = {};

            $.each(
                this.fields,
                $.proxy(
                    function (key, field) {
                        if (this["_" + field] === undefined
                            || this["_" + field] === null
                        ) {
                            return false;
                        }

                        var name = field;
                        if (this._namespace !== "") {
                            name = this._namespace + "." + field;
                        }

                        data[name] = this["_" + field];
                    },
                    this
                )
            );

            return data;
        }
    };
}(window.jQuery, window.Ss);
