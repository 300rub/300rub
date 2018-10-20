!function ($, ss) {
    "use strict";

    var name = "adminComponentsDesignTextItalic";

    var parameters = {
        /**
         * Parent
         *
         * @var {String}
         */
        parent: "adminComponentsDesignAbstractGroup",

        /**
         * Is italic
         *
         * @var {boolean|null}
         */
        isItalic: null,

        /**
         * Is italic hover
         *
         * @var {boolean|null}
         */
        isItalicHover: null,

        /**
         * Fields
         *
         * @var {Array}
         */
        fields: [
            "isItalic",
            "isItalicHover"
        ],

        /**
         * Init
         */
        init: function () {
            this.isItalic = null;
            this.isItalicHover = null;
            this.create();
            this.setItalic();
        },

        /**
         * Sets italic
         */
        setItalic: function () {
            var hoverForm = null;

            var onCheckHover = $.proxy(
                function () {
                    this.isItalicHover = true;
                    this.update();
                },
                this
            );
            var onUnCheckHover = $.proxy(
                function () {
                    this.isItalicHover = false;
                    this.update();
                },
                this
            );

            if (this.isItalicHover !== null) {
                hoverForm = ss.init(
                    "commonComponentsFormCheckboxButton",
                    {
                        value: this.isItalicHover,
                        icon: "fas fa-italic",
                        css: "italic",
                        appendTo: this.getOption("hoverContainer"),
                        onCheck: onCheckHover,
                        onUnCheck: onUnCheckHover
                    }
                );
            }

            var onCheck = $.proxy(
                function () {
                    if (hoverForm !== null
                        && this.isItalic === this.isItalicHover
                    ) {
                        hoverForm.setValue(true);
                        this.isItalicHover = true;
                    }

                    this.isItalic = true;
                    this.update();
                },
                this
            );

            var onUnCheck = $.proxy(
                function () {
                    if (hoverForm !== null
                        && this.isItalic === this.isItalicHover
                    ) {
                        hoverForm.setValue(false);
                        this.isItalicHover = false;
                    }

                    this.isItalic = false;
                    this.update();
                },
                this
            );

            if (this.isItalic !== null) {
                ss.init(
                    "commonComponentsFormCheckboxButton",
                    {
                        value: this.isItalic,
                        icon: "fas fa-italic",
                        css: "italic",
                        appendTo: this.getOption("commonContainer"),
                        onCheck: onCheck,
                        onUnCheck: onUnCheck
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
            var isItalic;
            if (isHover === true) {
                isItalic = this.isItalicHover;
            } else {
                isItalic = this.isItalic;
            }

            if (isItalic === true) {
                return "font-style: italic;";
            }

            return "font-style: normal;";
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
