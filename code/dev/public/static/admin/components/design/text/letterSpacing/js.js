!function ($, ss) {
    "use strict";

    var name = "adminComponentsDesignTextLetterSpacing";

    var parameters = {
        /**
         * Parent
         *
         * @var {String}
         */
        parent: "adminComponentsDesignAbstractGroup",

        /**
         * Letter spacing
         *
         * @var {int|null}
         */
        letterSpacing: null,

        /**
         * Letter spacing hover
         *
         * @var {int|null}
         */
        letterSpacingHover: null,

        /**
         * Fields
         *
         * @var {Array}
         */
        fields: [
            "letterSpacing",
            "letterSpacingHover"
        ],

        /**
         * Init
         */
        init: function () {
            this.letterSpacing = null;
            this.letterSpacingHover = null;
            this.create();
            this.setLetterSpacing();
        },

        /**
         * Sets letter-spacing
         */
        setLetterSpacing: function () {
            var hoverForm = null;

            if (this.letterSpacingHover !== null) {
                hoverForm = ss.init(
                    "commonComponentsFormSpinner",
                    {
                        value: this.letterSpacingHover,
                        appendTo: this.getOption("hoverContainer"),
                        callback: $.proxy(
                            function (value) {
                                this.letterSpacingHover = value;
                                this.update();
                            },
                            this
                        )
                    }
                );
            }

            if (this.letterSpacing !== null) {
                ss.init(
                    "commonComponentsFormSpinner",
                    {
                        value: this.letterSpacing,
                        css: "letter-spacing",
                        iconBefore: "fa-arrows-h",
                        appendTo: this.getOption("commonContainer"),
                        callback: $.proxy(
                            function (value) {
                                var hover = this.letterSpacingHover;
                                if (hoverForm !== null
                                    && this.letterSpacing === hover
                                ) {
                                    this.letterSpacingHover = value;
                                    hoverForm.getInstance().val(value);
                                }

                                this.letterSpacing = value;
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
                return "letter-spacing:" + this.letterSpacingHover + "px;";
            }

            return "letter-spacing:" + this.letterSpacing + "px;";
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
