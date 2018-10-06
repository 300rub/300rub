/**
 * Checkbox
 */
ss.add(
    "commonComponentsFormCheckbox",
    {
        /**
         * Parent
         *
         * @var {String}
         */
        parent: "commonComponentsFormAbstract",

        /**
         * Parent options
         *
         * @var {Object}
         */
        parentOptions: {
            template: "checkbox-button"
        },

        /**
         * Init
         */
        init: function() {
            this.set();

            var t = this;

            if (t.getOption("value") === true) {
                t.getInstance().attr("checked", "checked");
            }

            var onCheck = t.getOption("onCheck");
            if ($.type(onCheck) === "function") {
                t.getInstance().on(
                    "change",
                    function () {
                        if (this.checked === true) {
                            onCheck();
                        }
                    }
                );
            }

            var onUnCheck = t.getOption("onUnCheck");
            if ($.type(onUnCheck) === "function") {
                t.getInstance().on(
                    "change",
                    function () {
                        if (this.checked === false) {
                            onUnCheck();
                        }
                    }
                );
            }
        },

        /**
         * Gets value
         *
         * @returns {Boolean}
         */
        getValue: function () {
            return this.getInstance().is(':checked');
        }
    }
);
