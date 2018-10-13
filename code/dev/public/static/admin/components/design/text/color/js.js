!function ($, ss) {
    "use strict";

    var name = "adminComponentsDesignTextColor";

    var parameters = {
        /**
         * Parent
         *
         * @var {String}
         */
        parent: "adminComponentsDesignAbstractGroup",

        /**
         * Color
         *
         * @var {String}
         */
        color: null,

        /**
         * Color
         *
         * @var {String}
         */
        colorHover: null,

        /**
         * Fields
         *
         * @var {Array}
         */
        fields: [
            "color",
            "colorHover"
        ],

        /**
         * Init
         */
        init: function () {
            this.color = null;
            this.colorHover = null;

            this.create(
                {
                    updateSampleEvent: "update-text-sample"
                }
            );

            this.setColor();
        },

        /**
         * Sets color
         */
        setColor: function () {
            if (this.color !== null) {
                ss.init(
                    "commonComponentsFormColor",
                    {
                        title: this.getLabel("color"),
                        value: this.color,
                        appendTo: this.getOption("commonContainer"),
                        callback: $.proxy(
                            function (color) {
                                this.color = color;
                                this.update();
                            },
                            this
                        )
                    }
                );
            }

            if (this.colorHover !== null) {
                new ss.forms.Color(
                    {
                        title: this.getLabel("color"),
                        value: this.colorHover,
                        appendTo: this.getOption("hoverContainer"),
                        callback: $.proxy(
                            function (color) {
                                this.colorHover = color;
                                this.update();
                            },
                            this
                        )
                    }
                );
            }

            return this;
        },

        /**
         * Generates styles
         *
         * @param {boolean} isHover
         *
         * @returns {String}
         */
        generateCss: function (isHover) {
            if (isHover === true) {
                return "color:" + this.colorHover + ";";
            }

            return "color:" + this.color + ";";
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
