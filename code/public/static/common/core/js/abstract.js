!function ($, ss) {
    "use strict";

    var name = ss.constants.ABSTRACT;

    var parameters = {
        /**
         * Options
         *
         * @var {Object}
         */
        options: {},

        /**
         * Data
         *
         * @var {Object}
         */
        data: {},

        /**
         * Labels
         *
         * @var {Object}
         */
        labels: {},

        /**
         * Init
         */
        init: function () {
            this.options = {};
            this.data = {};
            this.labels = {};
        },

        /**
         * Sets options
         *
         * @param {Object} options
         */
        setOptions: function (options) {
            this.options = $.extend({}, options);
            return this;
        },

        /**
         * Extends options
         *
         * @param {Object} options
         */
        extendOptions: function (options) {
            this.options = $.extend({}, this.options, options);
            return this;
        },

        /**
         * Extends default options
         *
         * @param {Object} options
         */
        extendDefaultOptions: function (options) {
            this.options = $.extend({}, options, this.options);
            return this;
        },

        /**
         * Adds option
         *
         * @param {String} key
         * @param {*}      value
         */
        addOption: function (key, value) {
            this.options[key] = value;
            return this;
        },

        /**
         * Gets option
         *
         * @param {String|Array} pointer
         * @param {*}            defaultValue
         *
         * @returns {*}
         */
        getOption: function (pointer, defaultValue) {
            return this.findInObject(this.options, pointer, defaultValue);
        },

        /**
         * Gets all options
         *
         * @returns {Object}
         */
        getOptions: function () {
            return this.options;
        },

        /**
         * Sets labels
         *
         * @param {Object} labels
         */
        setLabels: function (labels) {
            this.labels = $.extend({}, labels);
            return this;
        },

        /**
         * Gets label
         *
         * @param {String} pointer
         * @param {*}      defaultValue
         *
         * @returns {String}
         */
        getLabel: function (pointer, defaultValue) {
            return this.findInObject(this.labels, pointer, defaultValue);
        },

        /**
         * Gets all labels
         *
         * @returns {Object}
         */
        getLabels: function () {
            return this.labels;
        },

        /**
         * Sets data
         *
         * @param {Object} data
         */
        setData: function (data) {
            this.data = $.extend({}, data);

            if (this.data.labels !== undefined) {
                this.setLabels(this.data.labels);
            }

            return this;
        },

        /**
         * Gets data
         *
         * @param {String|Array} pointer
         * @param {*}            defaultValue
         *
         * @returns {*}
         */
        getData: function (pointer, defaultValue) {
            return this.findInObject(this.data, pointer, defaultValue);
        },

        /**
         * Finds in object
         *
         * @param {Object}       dataObject
         * @param {String|Array} pointer
         * @param {*}            defaultValue
         *
         * @returns {*}
         */
        findInObject: function(dataObject, pointer, defaultValue) {
            if (pointer === undefined) {
                return dataObject;
            }

            if (defaultValue === undefined) {
                defaultValue = null;
            }

            if ($.type(pointer) !== "array") {
                if (dataObject[pointer] === undefined) {
                    return defaultValue;
                }

                return dataObject[pointer];
            }

            var data = dataObject;

            var number;
            var last = (pointer.length - 1);
            for (number = 0; number <= last; number++) {
                if (number === last) {
                    if (data[pointer[number]] === undefined) {
                        return defaultValue;
                    }

                    return data[pointer[number]];
                }

                if ($.type(data[pointer[number]]) !== "object") {
                    return defaultValue;
                }

                data = data[pointer[number]];
            }

            return data;
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
