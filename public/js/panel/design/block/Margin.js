!function ($, TestS) {
    'use strict';

    /**
     * Margin
     *
     * @param {TestS.Panel.Design.Block} object
     *
     * @property {TestS.Panel.Design.Block} _object
     *
     * @type {Object}
     */
    TestS.Panel.Design.Block.Margin = function (object) {
        this._object = $.extend({}, object);
        this.$_container = null;
        this.$_relativeContainer = null;
        this.$_example = null;
        this._uniqueId = 0;

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
            this.$_container = this._object.getDesignContainer().find(".margin-container");

            if (this._object.getValue("marginTop") === null &&
                this._object.getValue("marginRight") === null &&
                this._object.getValue("marginBottom") === null &&
                this._object.getValue("marginLeft") === null
            ) {
                this.$_container.remove();
                return this;
            }

            this
                ._setInitialSettings()
                ._setMarginTop()
                ._setMarginRight()
                ._setMarginBottom()
                ._setMarginLeft()
                ._setMarginHover()
                ._setHasMarginAnimation()
                ._update(true);
        },

        /**
         * Initial settings
         *
         * @returns {TestS.Panel.Design.Block.Margin}
         *
         * @private
         */
        _setInitialSettings: function () {
            this.$_example = this.$_container.find(".styles-example-container");

            this.$_container
                .find(".category-title")
                .text(this._object.getLabel("margin"));

            this._uniqueId = TestS.Library.getUniqueId();
            this.$_example = this.$_container
                .find(".margin-example")
                .addClass("margin-example-" + this._uniqueId);

            this.$_relativeContainer = this.$_container.find(".relative-container");

            return this;
        },

        /**
         * Sets margin-top
         *
         * @returns {TestS.Panel.Design.Block.Margin}
         *
         * @private
         */
        _setMarginTop: function () {
            if (this._object.getValue("marginTop") === null) {
                return this;
            }

            var hover = null;

            if (this._object.getValue("marginTopHover") !== null) {
                hover = new TestS.Form({
                    type: "spinner",
                    value: this._object.getValue("marginTopHover"),
                    class: "margin-top-hover",
                    iconBefore: "fa-mouse-pointer",
                    callback: $.proxy(function (value) {
                        this._object.setValue("marginTopHover", value);
                        this._update(false);
                    }, this),
                    appendTo: this.$_relativeContainer
                });
            }

            TestS.Form({
                type: "spinner",
                value: this._object.getValue("marginTop"),
                class: "margin-top",
                callback: $.proxy(function (value) {
                    if (this._object.getValue("marginTop") === this._object.getValue("marginTopHover") &&
                        hover !== null
                    ) {
                        this._object.setValue("marginTopHover", value);
                        hover.setValue(value);
                    }

                    this._object.setValue("marginTop", value);
                    this._update(false);
                }, this),
                appendTo: this.$_relativeContainer
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
        _setMarginRight: function () {
            if (this._object.getValue("marginRight") === null) {
                return this;
            }

            var hover = null;

            if (this._object.getValue("marginRightHover") !== null) {
                hover = new TestS.Form({
                    type: "spinner",
                    value: this._object.getValue("marginRightHover"),
                    class: "margin-right-hover",
                    iconBefore: "fa-mouse-pointer",
                    callback: $.proxy(function (value) {
                        this._object.setValue("marginRightHover", value);
                        this._update(false);
                    }, this),
                    appendTo: this.$_relativeContainer
                });
            }

            TestS.Form({
                type: "spinner",
                value: this._object.getValue("marginRight"),
                class: "margin-right",
                callback: $.proxy(function (value) {
                    if (this._object.getValue("marginRight") === this._object.getValue("marginRightHover") &&
                        hover !== null
                    ) {
                        this._object.setValue("marginRightHover", value);
                        hover.setValue(value);
                    }

                    this._object.setValue("marginRight", value);
                    this._update(false);
                }, this),
                appendTo: this.$_relativeContainer
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
        _setMarginBottom: function () {
            if (this._object.getValue("marginBottom") === null) {
                return this;
            }

            var hover = null;

            if (this._object.getValue("marginBottomHover") !== null) {
                hover = new TestS.Form({
                    type: "spinner",
                    value: this._object.getValue("marginBottomHover"),
                    class: "margin-bottom-hover",
                    iconBefore: "fa-mouse-pointer",
                    callback: $.proxy(function (value) {
                        this._object.setValue("marginBottomHover", value);
                        this._update(false);
                    }, this),
                    appendTo: this.$_relativeContainer
                });
            }

            TestS.Form({
                type: "spinner",
                value: this._object.getValue("marginBottom"),
                class: "margin-bottom",
                callback: $.proxy(function (value) {
                    if (this._object.getValue("marginBottom") === this._object.getValue("marginBottomHover") &&
                        hover !== null
                    ) {
                        this._object.setValue("marginBottomHover", value);
                        hover.setValue(value);
                    }

                    this._object.setValue("marginBottom", value);
                    this._update(false);
                }, this),
                appendTo: this.$_relativeContainer
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
        _setMarginLeft: function () {
            if (this._object.getValue("marginLeft") === null) {
                return this;
            }

            var hover = null;

            if (this._object.getValue("marginLeftHover") !== null) {
                hover = new TestS.Form({
                    type: "spinner",
                    value: this._object.getValue("marginLeftHover"),
                    class: "margin-left-hover",
                    iconBefore: "fa-mouse-pointer",
                    callback: $.proxy(function (value) {
                        this._object.setValue("marginLeftHover", value);
                        this._update(false);
                    }, this),
                    appendTo: this.$_relativeContainer
                });
            }

            TestS.Form({
                type: "spinner",
                value: this._object.getValue("marginLeft"),
                class: "margin-left",
                callback: $.proxy(function (value) {
                    if (this._object.getValue("marginLeft") === this._object.getValue("marginLeftHover") &&
                        hover !== null
                    ) {
                        this._object.setValue("marginLeftHover", value);
                        hover.setValue(value);
                    }

                    this._object.setValue("marginLeft", value);
                    this._update(false);
                }, this),
                appendTo: this.$_relativeContainer
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
        _setMarginHover: function () {
            if (this.$_object.getValue("hasMarginHover") === true) {
                this.$_container.addClass("has-hover");
            }

            if (this.$_object.getValue("hasMarginHover") === null) {
                return this;
            }

            TestS.Form({
                type: "checkboxOnOff",
                value: this.$_object.getValue("hasMarginHover"),
                label: this.$_object.getLabel("mouseHoverEffect"),
                onCheck: $.proxy(function () {
                    this.$_object.setValue("hasMarginHover", true);
                    this.$_container.addClass("has-hover");
                    this._update(false);
                }, this),
                onUnCheck: $.proxy(function () {
                    this.$_object.setValue("hasMarginHover", false);
                    this.$_container.removeClass("has-hover");
                    this._update(false);
                }, this),
                appendTo: this.$_container
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
        _setHasMarginAnimation: function () {
            if (this.$_object.getValue("hasMarginAnimation") === null) {
                return this;
            }

            TestS.Form({
                type: "checkboxOnOff",
                value: this.$_object.getValue("hasMarginAnimation"),
                label: this.$_object.getLabel("mouseHoverAnimation"),
                class: "has-animation",
                onCheck: $.proxy(function () {
                    this.$_object.setValue("hasMarginAnimation", true);
                    this._update(false);
                }, this),
                onUnCheck: $.proxy(function () {
                    this.$_object.setValue("hasMarginAnimation", false);
                    this._update(false);
                }, this),
                appendTo: this.$_container
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
                if (this.$_object.getValue("hasMarginHover") !== true) {
                    return "";
                }

                marginTop = TestS.Library.getIntVal(this.$_object.getValue("marginTopHover"));
                marginRight = TestS.Library.getIntVal(this.$_object.getValue("marginRightHover"));
                marginBottom = TestS.Library.getIntVal(this.$_object.getValue("marginBottomHover"));
                marginLeft = TestS.Library.getIntVal(this.$_object.getValue("marginLeftHover"));
            } else {
                marginTop = TestS.Library.getIntVal(this.$_object.getValue("marginTop"));
                marginRight = TestS.Library.getIntVal(this.$_object.getValue("marginRight"));
                marginBottom = TestS.Library.getIntVal(this.$_object.getValue("marginBottom"));
                marginLeft = TestS.Library.getIntVal(this.$_object.getValue("marginLeft"));
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
                this._object.getValue("hasMarginHover") === true &&
                this._object.getValue("hasMarginAnimation") === true
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
        _update: function (isOnlyExample) {
            var css = "<style>";

            css += ".margin-example-" +
                this._uniqueId +
                "{" +
                this.generateMarginCss(false, false) +
                "}";

            css += ".margin-example-" +
                this._uniqueId +
                ":hover{" +
                this.generateMarginCss(true, false) +
                "}";

            css += "</style>";

            this.$_example.html(css);

            if (isOnlyExample !== true) {
                this._object.update();
            }

            return this;
        }
    };
}(window.jQuery, window.TestS);