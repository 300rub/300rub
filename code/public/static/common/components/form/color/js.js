!function ($, ss) {
    "use strict";

    var name = "commonComponentsFormColor";

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
            this.create("color-picker-container");

            this.getInstance().val(this.getOption("value"));

            var iconBeforeElement = this.getForm().find(".icon-before");
            var iconBeforeOption = this.getOption("iconBefore");
            if (iconBeforeOption !== null) {
                iconBeforeElement.addClass(iconBeforeOption);
            } else {
                iconBeforeElement.remove();
            }

            var labelElement = this.getForm().find(".label-text");
            var labelOption = this.getOption("label");
            if (labelOption !== null) {
                labelElement.text(labelOption);
            } else {
                labelElement.remove();
            }

            var imageBase64 = "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP";
            imageBase64 += "///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7";

            var callback = this.getOption("callback");

            this.getInstance().colorpicker(
                {
                    parts: 'full',
                    alpha: true,
                    showOn: 'button',
                    buttonColorize: true,
                    buttonClass: "color-button",
                    buttonImage: imageBase64,
                    buttonImageOnly: true,
                    showNoneButton: true,
                    title: this.getOption("title"),
                    colorFormat: "RGBA",
                    select: $.proxy(
                        function (event, data) {
                            if ($.type(callback) === "function") {
                                callback(data.formatted);
                            }
                        },
                        this
                    )
                }
            );
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
