!function ($, TestS) {
    'use strict';

    /**
     * Design block
     *
     * @param {Object} data
     * @param {Object} $cssContainer
     * @param {String} cssSelector
     *
     * @type {Object}
     */
    TestS.Panel.Design.Block = function (data, $cssContainer, cssSelector) {
        this._data = $.extend({}, data);
        this.$_cssContainer = $cssContainer;
        this._cssSelector = cssSelector;
        this.$_designContainer = null;
        this.$_marginExample = null;

        this.init();
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    TestS.Panel.Design.Block.prototype = {
        /**
         * Init
         */
        init: function () {
            this.$_designContainer = TestS.Template.get("design-block-container");
            this._setMargin();
        },

        /**
         * Sets margin
         *
         * @returns {TestS.Panel.Design.Block}
         *
         * @private
         */
        _setMargin: function() {
            this.$_marginExample = this.$_designContainer.find(".margin-example-inside");

            this
                ._updateMarginExample()
                ._setMarginTop();

            return this;
        },

        /**
         * Sets margin-top
         *
         * @returns {TestS.Panel.Design.Block}
         *
         * @private
         */
        _setMarginTop: function() {
            var t = this;

            this.$_designContainer
                .find("margin-top")
                .val(this._options.data.marginTop)
                .attr("name", this._options.namespace + "." + "marginTop")
                .on("keyup", function() {
                    t._data["marginTop"] = parseInt($(this).val());
                    t._updateMarginExample();
                    t._update();
                })
                .spinner({
                    min: -300,
                    spin: $.proxy(function (event, ui) {
                        t._data["marginTop"] = parseInt(ui.value);
                        t._updateMarginExample();
                        t._update();
                    }, this)
                });

            return this;
        },

        /**
         * Updates margin example
         *
         * @returns {TestS.Panel.Design.Block}
         *
         * @private
         */
        _updateMarginExample: function() {
            return this;
        },

        /**
         * Generates CSS
         *
         * @returns {String}
         *
         * @private
         */
        _generateCss: function() {
            var css = "<style> ";

            // Standard

            css += this._cssSelector + " { ";

            css += "margin: "
                + this._data["marginTop"] + "px "
                + this._data["marginRight"] + "px "
                + this._data["marginBottom"] + "px "
                + this._data["marginLeft"] + "px !important; ";

            css += "padding: "
                + this._data["paddingTop"] + "px "
                + this._data["paddingRight"] + "px "
                + this._data["paddingBottom"] + "px "
                + this._data["paddingLeft"] + "px !important; ";

            css += "} ";

            // Hover

            css += this._cssSelector + ":hover { ";

            if (this._data["hasMarginHover"]) {
                css += "margin: "
                    + this._data["marginTopHover"] + "px "
                    + this._data["marginRightHover"] + "px "
                    + this._data["marginBottomHover"] + "px "
                    + this._data["marginLeftHover"] + "px !important; ";
            }

            if (this._data["hasPaddingHover"]) {
                css += "padding: "
                    + this._data["paddingTopHover"] + "px "
                    + this._data["paddingRightHover"] + "px "
                    + this._data["paddingBottomHover"] + "px "
                    + this._data["paddingLeftHover"] + "px !important; ";
            }

            css += "} ";

            css += "</style>";
            return css;
        },

        /**
         * Updates design
         *
         * @returns {TestS.Panel.Design.Block}
         *
         * @private
         */
        _update: function() {
            this.$_cssContainer.html(
                this._generateCss()
            );

            return this;
        },

        /**
         * Gets design container
         *
         * @returns {Object}
         */
        get: function() {
            return this.$_designContainer;
        }
    };
}(window.jQuery, window.TestS);