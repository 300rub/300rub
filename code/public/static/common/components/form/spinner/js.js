!function ($, ss) {
    "use strict";

    var name = "commonComponentsFormSpinner";

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
            this
                .addOption("type", "int")
                .create("form-spinner");

            var callback = this.getOption("callback");
            var t = this;

            if ($.type(callback) === "function") {
                this.getInstance().on(
                    "keyup",
                    function () {
                        callback(
                            t.getIntValue($(this).val())
                        );
                    }
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
                    spin: $.proxy(
                        function (event, ui) {
                            if ($.type(callback) === "function") {
                                callback(
                                    this.getIntValue(ui.value)
                                );
                            }
                        },
                        this
                    ),
                icons: {
                    up: "fa fa-chevron-up gray-blue-link",
                    down: "fa fa-chevron-down gray-blue-link"
                    }
                }
            );
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
