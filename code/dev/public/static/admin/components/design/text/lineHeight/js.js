!function ($, ss) {
    "use strict";

    var name = "adminComponentsDesignTextLineHeight";

    var parameters = {
        /**
         * Parent
         *
         * @var {String}
         */
        parent: "adminComponentsDesignAbstractGroup",

        /**
         * Line height
         *
         * @var {int|null}
         */
        lineHeight: null,

        /**
         * Line height hover
         *
         * @var {int|null}
         */
        lineHeightHover: null,

        /**
         * Fields
         *
         * @var {Array}
         */
        fields: [
            "lineHeight",
            "lineHeightHover"
        ],

        /**
         * Init
         */
        init: function () {
            this.lineHeight = null;
            this.lineHeightHover = null;
            this.create();
            this.setLineHeight();
        },

        /**
         * Sets line-height
         */
        setLineHeight: function () {
            var hoverForm = null;

            if (this.lineHeightHover !== null) {
                hoverForm = ss.init(
                    "commonComponentsFormSpinner",
                    {
                        value: this.lineHeightHover,
                        appendTo: this.getOption("hoverContainer"),
                        callback: $.proxy(
                            function (value) {
                                this.lineHeightHover = value;
                                this.update();
                            },
                            this
                        )

                    }
                );
            }

            if (this.lineHeight !== null) {
                ss.init(
                    "commonComponentsFormSpinner",
                    {
                        value: this.lineHeight,
                        css: "line-height",
                        iconBefore: "fas fa-arrows-alt-v",
                        appendTo: this.getOption("commonContainer"),
                        callback: $.proxy(
                            function (value) {
                                if (hoverForm !== null
                                    && this.lineHeight === this.lineHeightHover
                                ) {
                                    this.lineHeightHover = value;
                                    hoverForm.getInstance().val(value);
                                }

                                this.lineHeight = value;
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
            var lineHeight;

            if (isHover === true) {
                lineHeight = this.lineHeightHover;
            } else {
                lineHeight = this.lineHeight;
            }

            lineHeight = 1.4 + (lineHeight / 100);

            return "line-height:" + lineHeight + ";";
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
