!function ($, ss) {
    "use strict";

    var name = "adminComponentsDesignTextAlign";

    var parameters = {
        /**
         * Parent
         *
         * @var {String}
         */
        parent: "adminComponentsDesignAbstractGroup",

        /**
         * Align
         *
         * @var {int|null}
         */
        align: null,

        /**
         * Fields
         *
         * @var {Array}
         */
        fields: [
            "align"
        ],

        /**
         * Align list
         *
         * @var {Array}
         */
        alignList: [
            {value: 0, css: "left", icon: "fas fa-align-left"},
            {value: 1, css: "center", icon: "fas fa-align-center"},
            {value: 2, css: "right", icon: "fas fa-align-right"},
            {value: 3, css: "justify", icon: "fas fa-align-justify"}
        ],

        /**
         * Init
         */
        init: function () {
            this.align = null;
            this.create();
            this.setAlign();
        },

        /**
         * Sets align
         */
        setAlign: function () {
            if (this.align === null) {
                return this;
            }

            ss.init(
                "commonComponentsFormRadioButtons",
                {
                    value: this.align,
                    data: this.alignList,
                    css: "align",
                    appendTo: this.getOption("commonContainer"),
                    onChange: $.proxy(
                        function (value) {
                            this.align = value;
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
         * @returns {String}
         */
        generateCss: function () {
            var css = "";
            if (this.alignList[this.align] === undefined) {
                css = this.alignList[0].css;
            } else {
                css = this.alignList[this.align].css;
            }

            return "text-align:" + css + ";";
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
