!function ($, ss) {
    "use strict";

    var name = "commonComponentsFormCheckboxButton";

    var parameters = {
        /**
         * Parent
         *
         * @var {String}
         */
        parent: "commonComponentsFormAbstract",

        /**
         * Init
         */
        init: function () {
            this.create("checkbox-button");

            var t = this;

            if (t.getOption("value") === true) {
                t.getInstance().attr("checked", "checked");
            }

            var iconElement = t.getForm().find(".icon");
            var iconValue = t.getOption("icon");
            if (iconValue !== null) {
                iconElement.addClass(iconValue);
            } else {
                iconElement.remove();
            }

            var labelElement = t.getForm().find(".label");
            var labelValue = t.getOption("label");
            if (labelValue !== null) {
                labelElement.text(labelValue);
            } else {
                labelElement.remove();
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
            return this.getInstance().is(":checked");
        },

        /**
         * Sets value
         *
         * @param {boolean} value
         */
        setValue: function(value) {
            if (value === undefined) {
                value = this.getOption("value", false);
            }

            if (value === true) {
                this.getInstance().prop("checked", true);
                return this;
            }

            this.getInstance().prop("checked", false);
            return this;
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
