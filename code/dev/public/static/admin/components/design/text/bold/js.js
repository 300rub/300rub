!function ($, ss) {
    "use strict";

    var name = "adminComponentsDesignTextBold";

    var parameters = {
        /**
         * Parent
         *
         * @var {String}
         */
        parent: "adminComponentsDesignAbstractGroup",

        /**
         * Is bold
         *
         * @var {Boolean|null}
         */
        isBold: null,

        /**
         * Is bold hover
         *
         * @var {Boolean|null}
         */
        isBoldHover: null,

        /**
         * Fields
         *
         * @var {Array}
         */
        fields: [
            "isBold",
            "isBoldHover"
        ],

        /**
         * Init
         */
        init: function () {
            this.align = null;
            this.create();
            this.setBold();
        },

        /**
         * Sets bold
         */
        setBold: function () {
            var hoverForm = null;

            var onCheckHover = $.proxy(
                function () {
                    this.isBoldHover = true;
                    this.update();
                },
                this
            );
            var onUnCheckHover = $.proxy(
                function () {
                    this.isBoldHover = false;
                    this.update();
                },
                this
            );

            if (this.isBoldHover !== null) {
                hoverForm = ss.init(
                    "commonComponentsFormCheckboxButton",
                    {
                        value: this.isBoldHover,
                        icon: "fas fa-bold",
                        css: "bold",
                        appendTo: this.getOption("hoverContainer"),
                        onCheck: onCheckHover,
                        onUnCheck: onUnCheckHover
                    }
                );
            }

            var onCheck = $.proxy(
                function () {
                    if (hoverForm !== null
                        && this.isBold === this.isBoldHover
                    ) {
                        hoverForm.getInstance().attr("checked", true);
                        this.isBoldHover = true;
                    }

                    this.isBold = true;
                    this.update();
                },
                this
            );

            var onUnCheck = $.proxy(
                function () {
                    if (hoverForm !== null
                        && this.isBold === this.isBoldHover
                    ) {
                        hoverForm.getInstance().attr("checked", false);
                        this.isBoldHover = false;
                    }

                    this.isBold = false;
                    this.update();
                },
                this
            );

            if (this.isBold !== null) {
                ss.init(
                    "commonComponentsFormCheckboxButton",
                    {
                        value: this.isBold,
                        icon: "fas fa-bold",
                        css: "bold",
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
            var isBold;
            if (isHover === true) {
                isBold = this.isBoldHover;
            } else {
                isBold = this.isBold;
            }

            if (isBold === true) {
                return "font-weight: bold;";
            }

            return "font-weight: normal;";
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
