ss.add(
    ss.constants.ABSTRACT,
    {
        options: {},

        init: function() {
        },

        setOptions: function(options) {
            this.options = $.extend({}, options);
            return this;
        },

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

        getOptions: function() {
            return this.options;
        }
    }
);