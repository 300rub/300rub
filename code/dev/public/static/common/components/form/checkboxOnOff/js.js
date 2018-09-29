/**
 * Checkbox On Off
 */
ss.add(
    "commonComponentsFormCheckboxOnOff",
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
            template: "form-container-checkbox-on-off"
        },

        /**
         * Init
         */
        init: function() {
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
