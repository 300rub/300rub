!function ($, ss) {
    "use strict";

    var name = "adminComponentsDesignTextSize";

    var parameters = {
        /**
         * Parent
         *
         * @var {String}
         */
        parent: "adminComponentsDesignAbstractGroup",

        /**
         * Size
         *
         * @var {int|null}
         */
        size: null,

        /**
         * Size hover
         *
         * @var {int|null}
         */
        sizeHover: null,

        /**
         * Fields
         *
         * @var {Array}
         */
        fields: [
            "size",
            "sizeHover"
        ],

        /**
         * Init
         */
        init: function () {
            this.size = null;
            this.sizeHover = null;
            this.create();
            this.setSize();
        },

        /**
         * Sets size
         */
        setSize: function () {
            if (this.size === null) {
                return this;
            }

            var sizeHover = null;

            if (this.sizeHover !== null) {
                sizeHover = ss.init(
                    "commonComponentsFormSpinner",
                    {
                        value: this.sizeHover,
                        css: "size-hover",
                        min: 0,
                        appendTo: this.getOption("hoverContainer"),
                        callback: $.proxy(
                            function (value) {
                                this.sizeHover = value;
                                this.update();
                            },
                            this
                        )
                    }
                );
            }

            ss.init(
                "commonComponentsFormSpinner",
                {
                    value: this.size,
                    css: "size",
                    min: 0,
                    appendTo: this.getOption("commonContainer"),
                    callback: $.proxy(
                        function (value) {
                            if (this.size === this.sizeHover
                                && sizeHover !== null
                            ) {
                                this.sizeHover = value;
                                sizeHover.setValue(value);
                            }

                            this.size = value;
                            this.update();
                        },
                        this
                    )
                }
            );

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
                return "font-size:" + this.sizeHover + "px;";
            }

            return "font-size:" + this.size + "px;";
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
