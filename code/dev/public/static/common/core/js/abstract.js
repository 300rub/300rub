/**
 * Abstract instance
 */
ss.add(
    ss.constants.ABSTRACT,
    {
        /**
         * Options
         *
         * @var {Object}
         */
        options: {},

        /**
         * Init
         */
        init: function() {
        },

        /**
         * Sets options
         *
         * @param {Object} options
         */
        setOptions: function(options) {
            this.options = $.extend({}, options);
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
        getOption: function(pointer, defaultValue) {
            if (defaultValue === undefined) {
                defaultValue = null;
            }

            if ($.type(pointer) !== "array") {
                if (this.options[pointer] === undefined) {
                    return defaultValue;
                }

                return this.options[pointer];
            }

            var options = this.options;
            var number;
            var last = pointer.length - 1;
            for (number = 0; number <= last; pointer++) {
                if (number === last) {
                    if (options[pointer[number]] === undefined) {
                        return defaultValue;
                    }

                    return options[pointer[number]];
                }

                if ($.type(options[pointer[number]]) !== "object") {
                    return defaultValue;
                }

                options = options[pointer[number]];
            }
        },

        /**
         * Gets all options
         *
         * @returns {Object}
         */
        getOptions: function() {
            return this.options;
        }
    }
);