!function ($, ss) {
    "use strict";

    var name = "adminComponentsDesignTextDecoration";

    var parameters = {
        /**
         * Parent
         *
         * @var {String}
         */
        parent: "adminComponentsDesignAbstractGroup",

        /**
         * Decoration
         *
         * @var {int|null}
         */
        decoration: null,

        /**
         * Decoration hover
         *
         * @var {int|null}
         */
        decorationHover: null,

        /**
         * Fields
         *
         * @var {Array}
         */
        fields: [
            "decoration",
            "decorationHover"
        ],

        /**
         * Text decoration list
         *
         * @var {Array}
         */
        decorationList: [
            {value: 0, css: "none", label: "N"},
            {value: 1, css: "underline", label: "U"},
            {value: 2, css: "line-through", label: "T"},
            {value: 3, css: "overline", label: "O"}
        ],


        /**
         * Init
         */
        init: function () {
            this.decoration = null;
            this.decorationHover = null;
            this.create();
            this.setDecoration();
        },

        /**
         * Sets text-decoration
         */
        setDecoration: function () {
            var hoverForm = null;
            if (this.decorationHover !== null) {
                hoverForm = ss.init(
                    "commonComponentsFormRadioButtons",
                    {
                        value: this.decorationHover,
                        data: this.decorationList,
                        appendTo: this.getOption("hoverContainer"),
                        onChange: $.proxy(
                            function (value) {
                                this.decorationHover = value;
                                this.update();
                            },
                            this
                        )
                    }
                );
            }

            if (this.decoration !== null) {
                ss.init(
                    "commonComponentsFormRadioButtons",
                    {
                        value: this.decoration,
                        data: this.decorationList,
                        css: "decoration",
                        appendTo: this.getOption("commonContainer"),
                        onChange: $.proxy(
                            function (value) {
                                if (hoverForm !== null
                                    && this.decoration === this.decorationHover
                                ) {
                                    this.decorationHover = value;
                                    hoverForm.getInstance().val(value).change();
                                }

                                this.decoration = value;
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
            var decoration;
            var decorationCss;
            if (isHover === true) {
                decoration = this.decorationHover;
            } else {
                decoration = this.decoration;
            }

            if (this.decorationList[decoration] === undefined) {
                decorationCss = this.decorationList[0].css;
            } else {
                decorationCss = this.decorationList[decoration].css;
            }

            return "text-decoration:" + decorationCss + ";";
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
