/**
 * Spinner
 */
ss.add(
    "commonComponentsFormSpinner",
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
            template: "form-spinner",
            type: "int"
        },

        /**
         * Init
         */
        init: function() {
            this.set();

            var callback = this.getOption("callback");
            if ($.type(callback) === "function") {
                this.getInstance().on(
                    "keyup",
                    $.proxy(function () {
                        callback(
                            this.getIntValue($(this).val())
                        );
                    }, this)
                );
            }

            var iconBeforeElement = this.getForm().find(".icon-before");
            var iconBeforeOption = this.getOption("iconBefore");
            if (iconBeforeOption !== null) {
                iconBeforeElement.addClass(iconBeforeOption);
            } else {
                iconBeforeElement.remove();
            }

            var min = this.getOption("min");
            if (min === null) {
                min = -999999;
            }

            this.getInstance().spinner(
                {
                    min: min,
                    spin: $.proxy(function (event, ui) {
                        if ($.type(callback) === "function") {
                            callback(
                                this.getIntValue(ui.value)
                            );
                        }
                    }, this),
                    icons: {
                        up: "fa fa-chevron-up gray-blue-link",
                        down: "fa fa-chevron-down gray-blue-link"
                    }
                }
            );
        }
    }
);
