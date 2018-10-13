!function ($, ss) {
    "use strict";

    var name = "adminComponentsDesignTextEditor";

    var parameters = {
        /**
         * Parent
         *
         * @var {String}
         */
        parent: "adminComponentsDesignAbstractEditor",

        /**
         * Size
         *
         * @var {Object}
         */
        size: null,

        /**
         * Family
         *
         * @var {Object}
         */
        family: null,

        /**
         * Color
         *
         * @var {Object}
         */
        color: null,

        /**
         * Align
         *
         * @var {Object}
         */
        align: null,

        /**
         * Italic
         *
         * @var {Object}
         */
        italic: null,

        /**
         * bold
         *
         * @var {Object}
         */
        bold: null,

        /**
         * Line height
         *
         * @var {Object}
         */
        lineHeight: null,

        /**
         * Decoration
         *
         * @var {Object}
         */
        decoration: null,

        /**
         * Letter spacing
         *
         * @var {Object}
         */
        letterSpacing: null,

        /**
         * Transform
         *
         * @var {Object}
         */
        transform: null,

        /**
         * Hover
         *
         * @var {Object}
         */
        hover: null,

        /**
         * Sample
         *
         * @var {Object}
         */
        sample: null,

        /**
         * Init
         */
        init: function () {
            this.size = null;
            this.family = null;
            this.color = null;
            this.align = null;
            this.italic = null;
            this.bold = null;
            this.lineHeight = null;
            this.decoration = null;
            this.letterSpacing = null;
            this.transform = null;
            this.hover = null;

            this.sample = null;

            this.create();

            this
                .setSample()
                .setEditors()
                .setUpdateEvents();
        },


    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
