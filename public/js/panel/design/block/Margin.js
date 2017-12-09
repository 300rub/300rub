!function ($, TestS) {
    'use strict';

    /**
     * Margin
     *
     * @param {TestS.Panel.Design.Block} object
     *
     * @property {TestS.Panel.Design.Block} object
     *
     * @type {Object}
     */
    TestS.Panel.Design.Block.Margin = function (object) {
        this.object = $.extend({}, object);
        this.$container = null;
        this.$relativeContainer = null;
        this.$example = null;
        this.uniqueId = 0;

        this.init();
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    TestS.Panel.Design.Block.Margin.prototype = {
        /**
         * Init
         */
        init: function () {
            this.$container = this.object.getDesignContainer().find(".margin-container");

            if (this.object.getValue("marginTop") === null &&
                this.object.getValue("marginRight") === null &&
                this.object.getValue("marginBottom") === null &&
                this.object.getValue("marginLeft") === null
            ) {
                this.$container.remove();
                return this;
            }

            this
                .setInitialSettings()
                .setMarginTop()
                .setMarginRight()
                .setMarginBottom()
                .setMarginLeft()
                .setMarginHover()
                .setHasMarginAnimation()
                .update(true);
        },

        /**
         * Initial settings
         *
         * @returns {TestS.Panel.Design.Block.Margin}
         *
         * @private
         */
        setInitialSettings: function () {
            this.$example = this.$container.find(".styles-example-container");

            this.$container
                .find(".category-title")
                .text(this.object.getLabel("margin"));

            this.uniqueId = TestS.Library.getUniqueId();
            this.$example = this.$container
                .find(".margin-example")
                .addClass("margin-example-" + this.uniqueId);

            this.$relativeContainer = this.$container.find(".relative-container");

            return this;
        },

        /**
         * Sets margin-top
         *
         * @returns {TestS.Panel.Design.Block.Margin}
         *
         * @private
         */
        setMarginTop: function () {
            if (this.object.getValue("marginTop") === null) {
                return this;
            }

            var hover = null;

            if (this.object.getValue("marginTopHover") !== null) {
                hover = new TestS.Form({
                    type: "spinner",
                    value: this.object.getValue("marginTopHover"),
                    css: "margin-top-hover",
                    iconBefore: "fa-mouse-pointer",
                    callback: $.proxy(function (value) {
                        this.object.setValue("marginTopHover", value);
                        this.update(false);
                    }, this),
                    appendTo: this.$relativeContainer
                });
            }

            TestS.Form({
                type: "spinner",
                value: this.object.getValue("marginTop"),
                css: "margin-top",
                callback: $.proxy(function (value) {
                    if (this.object.getValue("marginTop") === this.object.getValue("marginTopHover") &&
                        hover !== null
                    ) {
                        this.object.setValue("marginTopHover", value);
                        hover.setValue(value);
                    }

                    this.object.setValue("marginTop", value);
                    this.update(false);
                }, this),
                appendTo: this.$relativeContainer
            });

            return this;
        },

        /**
         * Sets margin-right
         *
         * @returns {TestS.Panel.Design.Block.Margin}
         *
         * @private
         */
        setMarginRight: function () {
            if (this.object.getValue("marginRight") === null) {
                return this;
            }

            var hover = null;

            if (this.object.getValue("marginRightHover") !== null) {
                hover = new TestS.Form({
                    type: "spinner",
                    value: this.object.getValue("marginRightHover"),
                    css: "margin-right-hover",
                    iconBefore: "fa-mouse-pointer",
                    callback: $.proxy(function (value) {
                        this.object.setValue("marginRightHover", value);
                        this.update(false);
                    }, this),
                    appendTo: this.$relativeContainer
                });
            }

            TestS.Form({
                type: "spinner",
                value: this.object.getValue("marginRight"),
                css: "margin-right",
                callback: $.proxy(function (value) {
                    if (this.object.getValue("marginRight") === this.object.getValue("marginRightHover") &&
                        hover !== null
                    ) {
                        this.object.setValue("marginRightHover", value);
                        hover.setValue(value);
                    }

                    this.object.setValue("marginRight", value);
                    this.update(false);
                }, this),
                appendTo: this.$relativeContainer
            });

            return this;
        },

        /**
         * Sets margin-bottom
         *
         * @returns {TestS.Panel.Design.Block.Margin}
         *
         * @private
         */
        setMarginBottom: function () {
            if (this.object.getValue("marginBottom") === null) {
                return this;
            }

            var hover = null;

            if (this.object.getValue("marginBottomHover") !== null) {
                hover = new TestS.Form({
                    type: "spinner",
                    value: this.object.getValue("marginBottomHover"),
                    css: "margin-bottom-hover",
                    iconBefore: "fa-mouse-pointer",
                    callback: $.proxy(function (value) {
                        this.object.setValue("marginBottomHover", value);
                        this.update(false);
                    }, this),
                    appendTo: this.$relativeContainer
                });
            }

            TestS.Form({
                type: "spinner",
                value: this.object.getValue("marginBottom"),
                css: "margin-bottom",
                callback: $.proxy(function (value) {
                    if (this.object.getValue("marginBottom") === this.object.getValue("marginBottomHover") &&
                        hover !== null
                    ) {
                        this.object.setValue("marginBottomHover", value);
                        hover.setValue(value);
                    }

                    this.object.setValue("marginBottom", value);
                    this.update(false);
                }, this),
                appendTo: this.$relativeContainer
            });

            return this;
        },

        /**
         * Sets margin-left
         *
         * @returns {TestS.Panel.Design.Block.Margin}
         *
         * @private
         */
        setMarginLeft: function () {
            if (this.object.getValue("marginLeft") === null) {
                return this;
            }

            var hover = null;

            if (this.object.getValue("marginLeftHover") !== null) {
                hover = new TestS.Form({
                    type: "spinner",
                    value: this.object.getValue("marginLeftHover"),
                    css: "margin-left-hover",
                    iconBefore: "fa-mouse-pointer",
                    callback: $.proxy(function (value) {
                        this.object.setValue("marginLeftHover", value);
                        this.update(false);
                    }, this),
                    appendTo: this.$relativeContainer
                });
            }

            TestS.Form({
                type: "spinner",
                value: this.object.getValue("marginLeft"),
                css: "margin-left",
                callback: $.proxy(function (value) {
                    if (this.object.getValue("marginLeft") === this.object.getValue("marginLeftHover") &&
                        hover !== null
                    ) {
                        this.object.setValue("marginLeftHover", value);
                        hover.setValue(value);
                    }

                    this.object.setValue("marginLeft", value);
                    this.update(false);
                }, this),
                appendTo: this.$relativeContainer
            });

            return this;
        },

        /**
         * Sets margin hover
         *
         * @returns {TestS.Panel.Design.Block.Margin}
         *
         * @private
         */
        setMarginHover: function () {
            if (this.object.getValue("hasMarginHover") === true) {
                this.$container.addClass("has-hover");
            }

            if (this.object.getValue("hasMarginHover") === null) {
                return this;
            }

            TestS.Form({
                type: "checkboxOnOff",
                value: this.object.getValue("hasMarginHover"),
                label: this.object.getLabel("mouseHoverEffect"),
                onCheck: $.proxy(function () {
                    this.object.setValue("hasMarginHover", true);
                    this.$container.addClass("has-hover");
                    this.update(false);
                }, this),
                onUnCheck: $.proxy(function () {
                    this.object.setValue("hasMarginHover", false);
                    this.$container.removeClass("has-hover");
                    this.update(false);
                }, this),
                appendTo: this.$container
            });

            return this;
        },

        /**
         * Sets margin animation
         *
         * @returns {TestS.Panel.Design.Block.Margin}
         *
         * @private
         */
        setHasMarginAnimation: function () {
            if (this.object.getValue("hasMarginAnimation") === null) {
                return this;
            }

            TestS.Form({
                type: "checkboxOnOff",
                value: this.object.getValue("hasMarginAnimation"),
                label: this.object.getLabel("mouseHoverAnimation"),
                css: "has-animation",
                onCheck: $.proxy(function () {
                    this.object.setValue("hasMarginAnimation", true);
                    this.update(false);
                }, this),
                onUnCheck: $.proxy(function () {
                    this.object.setValue("hasMarginAnimation", false);
                    this.update(false);
                }, this),
                appendTo: this.$container
            });

            return this;
        },

        /**
         * Generates margin styles
         *
         * @param {boolean} isHover
         * @param {boolean} skipAnimation
         *
         * @returns {String}
         */
        generateMarginCss: function (isHover, skipAnimation) {
            var marginTop, marginRight, marginBottom, marginLeft;

            if (isHover === true) {
                if (this.object.getValue("hasMarginHover") !== true) {
                    return "";
                }

                marginTop = TestS.Library.getIntVal(
                    this.object.getValue("marginTopHover")
                );
                marginRight = TestS.Library.getIntVal(
                    this.object.getValue("marginRightHover")
                );
                marginBottom = TestS.Library.getIntVal(
                    this.object.getValue("marginBottomHover")
                );
                marginLeft = TestS.Library.getIntVal(
                    this.object.getValue("marginLeftHover")
                );
            } else {
                marginTop = TestS.Library.getIntVal(
                    this.object.getValue("marginTop")
                );
                marginRight = TestS.Library.getIntVal(
                    this.object.getValue("marginRight")
                );
                marginBottom = TestS.Library.getIntVal(
                    this.object.getValue("marginBottom")
                );
                marginLeft = TestS.Library.getIntVal(
                    this.object.getValue("marginLeft")
                );
            }

            if (marginTop !== 0) {
                marginTop += "px";
            }

            if (marginRight !== 0) {
                marginRight += "px";
            }

            if (marginBottom !== 0) {
                marginBottom += "px";
            }

            if (marginLeft !== 0) {
                marginLeft += "px";
            }

            var css = "margin:" + marginTop + " " + marginRight + " " + marginBottom + " " + marginLeft + ";";

            if (skipAnimation !== true &&
                this.object.getValue("hasMarginHover") === true &&
                this.object.getValue("hasMarginAnimation") === true
            ) {
                css += "-webkit-transition:margin .3s;";
                css += "-ms-transition:margin .3s;";
                css += "-o-transition:margin .3s;";
                css += "transition:margin .3s;";
            }

            return css;
        },

        /**
         * Updates CSS
         *
         * @param {boolean} isOnlyExample
         *
         * @private
         */
        update: function (isOnlyExample) {
            var css = "<style>";

            css += ".margin-example-" +
                this.uniqueId +
                "{" +
                this.generateMarginCss(false, false) +
                "}";

            css += ".margin-example-" +
                this.uniqueId +
                ":hover{" +
                this.generateMarginCss(true, false) +
                "}";

            css += "</style>";

            this.$example.html(css);

            if (isOnlyExample !== true) {
                this.object.update();
            }

            return this;
        }
    };
}(window.jQuery, window.TestS);