!function ($, ss) {
    "use strict";

    var name = "adminComponentsDesignBlockImage";

    var parameters = {
        /**
         * Parent
         *
         * @var {String}
         */
        parent: "adminComponentsDesignAbstractGroup",

        /**
         * Relative container
         *
         * @var {Object}
         */
        relativeContainer: null,

        /**
         * Fields
         *
         * @var {Array}
         */
        fields: [
        ],

        /**
         * Init
         */
        init: function () {
            this.relativeContainer = null;

            this
                .setRelativeContainer();
        },

        /**
         * Generates styles
         */
        generateCss: function () {
            if (this.imageInstanceId === null) {
                return "";
            }

            var css = "";

            css += "background-image:url(";
            css += this.url;
            css += ");";

            if (this.isBackgroundCover === true) {
                css += "background-size:cover;";
                return css;
            }

            css += "background-position:";
            css += this.getBackgroundPositionCss();
            css += ";";

            css += "background-repeat:";
            css += this.getBackgroundRepeatCss();
            css += ";";

            return css;
        },

        /**
         * Gets background position CSS
         *
         * @returns {String}
         */
        getBackgroundPositionCss: function() {
            var value
                = this.backgroundPositionCssList[this.backgroundPosition];
            if (value === undefined) {
                return this.backgroundPositionCssList[0];
            }

            return value;
        },

        /**
         * Gets background repeat CSS
         *
         * @returns {String}
         */
        getBackgroundRepeatCss: function() {
            var value = this.backgroundRepeatCssList[this.backgroundRepeat];
            if (value === undefined) {
                return this.backgroundRepeatCssList[0];
            }

            return value;
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
