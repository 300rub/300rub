!function ($, ss) {
    "use strict";

    var name = "adminComponentsDesignTextTransform";

    var parameters = {
        /**
         * Parent
         *
         * @var {String}
         */
        parent: "adminComponentsDesignAbstractGroup",

        /**
         * Transform
         *
         * @var {int|null}
         */
        transform: null,

        /**
         * Transform hover
         *
         * @var {int|null}
         */
        transformHover: null,

        /**
         * Fields
         *
         * @var {Array}
         */
        fields: [
            "transform",
            "transformHover"
        ],

        /**
         * Text transform list
         *
         * @var {Array}
         */
        transformList: [
            {value: 0, css: "none", label: "-"},
            {value: 1, css: "uppercase", label: "AA"},
            {value: 2, css: "lowercase", label: "aa"},
            {value: 3, css: "capitalize", label: "Aa"}
        ],

        /**
         * Init
         */
        init: function () {
            this.transform = null;
            this.transformHover = null;

            this.create(
                {
                    updateSampleEvent: "update-text-sample"
                }
            );

            this.setTransform();
        },

        /**
         * Sets transform
         */
        setTransform: function () {
            var hoverForm = null;
            if (this.transformHover !== null) {
                hoverForm =  ss.init(
                    "commonComponentsFormRadioButtons",
                    {
                        value: this.transformHover,
                        data: this.transformList,
                        appendTo: this.getOption("hoverContainer"),
                        onChange: $.proxy(
                            function (value) {
                                this.transformHover = value;
                                this.update();
                            },
                            this
                        )
                    }
                );
            }

            if (this.transform !== null) {
                ss.init(
                    "commonComponentsFormRadioButtons",
                    {
                        value: this.transform,
                        data: this.transformList,
                        appendTo: this.getOption("commonContainer"),
                        onChange: $.proxy(
                            function (value) {
                                if (hoverForm !== null
                                    && this.transform === this.transformHover
                                ) {
                                    this.transformHover = false;
                                    hoverForm.getInstance().val(value).change();
                                }

                                this.transform = value;
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
            var transform;
            var transformCss;

            if (isHover === true) {
                transform = this.transformHover;
            } else {
                transform = this.transform;
            }

            if (this.transformList[transform] === undefined) {
                transformCss = this.transformList[0].css;
            } else {
                transformCss = this.transformList[transform].css;
            }

            return "text-transform:" + transformCss + ";";
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
