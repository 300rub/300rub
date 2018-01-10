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

        this._container = null;
        this._relativeContainer = null;
        this._example = null;
        this._uniqueId = 0;

        this._marginTop = null;
        this._marginRight = null;
        this._marginBottom = null;
        this._marginLeft = null;
        this._marginTopHover = null;
        this._marginRightHover = null;
        this._marginBottomHover = null;
        this._marginLeftHover = null;
        this._hasMarginHover = null;
        this._hasMarginAnimation = null;

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
            this._container = this._object
                .getDesignContainer()
                .find(".margin-container");

            if (this._marginTop === null
                && this._marginRight === null
                && this._marginBottom === null
                && this._marginLeft === null
            ) {
                this._container.remove();
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

        _setValues: function () {
            var values = this._object.getValues();

            if (values.marginTop !== undefined) {
                this._marginTop = values.marginTop;
            }

            if (values.marginRight !== undefined) {
                this._marginRight = values.marginRight;
            }

            if (values.marginBottom !== undefined) {
                this._marginBottom = values.marginBottom;
            }

            if (values.marginLeft !== undefined) {
                this._marginLeft = values.marginLeft;
            }

            if (values.marginTopHover !== undefined) {
                this._marginTopHover = values.marginTopHover;
            }

            if (values.marginRightHover !== undefined) {
                this._marginRightHover = values.marginRightHover;
            }

            if (values.marginBottomHover !== undefined) {
                this._marginBottomHover = values.marginBottomHover;
            }

            if (values.marginLeftHover !== undefined) {
                this._marginLeftHover = values.marginLeftHover;
            }

            if (values.hasMarginHover !== undefined) {
                this._hasMarginHover = values.hasMarginHover;
            }

            if (values.hasMarginAnimation !== undefined) {
                this._hasMarginAnimation = values.hasMarginAnimation;
            }

            return this;
        },

        /**
         * Initial settings
         *
         * @returns {TestS.Panel.Design.Block.Margin}
         *
         * @private
         */
        _setInitialSettings: function () {
            this._example = this._container.find(".styles-example-container");

            this._container
                .find(".category-title")
                .text(this._object.getLabel("margin"));

            this._uniqueId = TestS.Library.getUniqueId();
            this._example = this._container
                .find(".margin-example")
                .addClass("margin-example-" + this._uniqueId);

            this._relativeContainer
                = this._container.find(".relative-container");

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
            if (this._marginTop === null) {
                return this;
            }

            var hover = null;

            if (this._marginTopHover !== null) {
                hover = new TestS.Form(
                    {
                        type: "spinner",
                        value: this._marginTopHover,
                        css: "margin-top-hover",
                        iconBefore: "fa-mouse-pointer",
                        callback: $.proxy(
                            function (value) {
                                this._marginTopHover = value;
                                this._update(false);
                            },
                            this
                        ),
                    appendTo: this._relativeContainer
                    }
                );
            }

            TestS.Form(
                {
                    type: "spinner",
                    value: this._marginTop,
                    css: "margin-top",
                    callback: $.proxy(
                        function (value) {
                            var marginTop = this._marginTop;
                            var marginTopHover
                            = this._marginTopHover;
                            if (marginTop === marginTopHover
                                && hover !== null
                            ) {
                                this._marginTopHover = value;
                                hover.setValue(value);
                            }

                            this._marginTop = value;
                            this._update(false);
                        },
                        this
                    ),
                appendTo: this._relativeContainer
                }
            );

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
            if (this._marginRight === null) {
                return this;
            }

            var hover = null;

            if (this._marginRightHover !== null) {
                hover = new TestS.Form(
                    {
                        type: "spinner",
                        value: this._marginRightHover,
                        css: "margin-right-hover",
                        iconBefore: "fa-mouse-pointer",
                        callback: $.proxy(
                            function (value) {
                                this._marginRightHover = value;
                                this._update(false);
                            },
                            this
                        ),
                    appendTo: this._relativeContainer
                    }
                );
            }

            TestS.Form(
                {
                    type: "spinner",
                    value: this._marginRight,
                    css: "margin-right",
                    callback: $.proxy(
                        function (value) {
                            var marginRight
                                = this._marginRight;
                            var marginRightHover
                            = this._marginRightHover;
                            if (marginRight === marginRightHover
                                && hover !== null
                            ) {
                                this._marginRightHover = value;
                                hover.setValue(value);
                            }

                            this._marginRight = value;
                            this._update(false);
                        },
                        this
                    ),
                appendTo: this._relativeContainer
                }
            );

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
            if (this._marginBottom === null) {
                return this;
            }

            var hover = null;

            if (this._marginBottomHover !== null) {
                hover = new TestS.Form(
                    {
                        type: "spinner",
                        value: this._marginBottomHover,
                        css: "margin-bottom-hover",
                        iconBefore: "fa-mouse-pointer",
                        appendTo: this._relativeContainer,
                        callback: $.proxy(
                            function (value) {
                                this._marginBottomHover = value;
                                this._update(false);
                            },
                            this
                        )
                    }
                );
            }

            TestS.Form(
                {
                    type: "spinner",
                    value: this._marginBottom,
                    css: "margin-bottom",
                    callback: $.proxy(
                        function (value) {
                            var marginBottom
                                = this._marginBottom;
                            var marginBottomHover
                            = this._marginBottomHover;
                            if (marginBottom === marginBottomHover
                                && hover !== null
                            ) {
                                this._marginBottomHover = value;
                                hover.setValue(value);
                            }

                            this._marginBottom = value;
                            this._update(false);
                        },
                        this
                    ),
                appendTo: this._relativeContainer
                }
            );

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
            if (this._marginLeft === null) {
                return this;
            }

            var hover = null;

            if (this._marginLeftHover !== null) {
                hover = new TestS.Form(
                    {
                        type: "spinner",
                        value: this._marginLeftHover,
                        css: "margin-left-hover",
                        iconBefore: "fa-mouse-pointer",
                        callback: $.proxy(
                            function (value) {
                                this._marginLeftHover = value;
                                this._update(false);
                            },
                            this
                        ),
                    appendTo: this._relativeContainer
                    }
                );
            }

            TestS.Form(
                {
                    type: "spinner",
                    value: this._marginLeft,
                    css: "margin-left",
                    callback: $.proxy(
                        function (value) {
                            var marginLeft
                                = this._marginLeft;
                            var marginLeftHover
                            = this._marginLeftHover;
                            if (marginLeft === marginLeftHover
                                && hover !== null
                            ) {
                                this._marginLeftHover = value;
                                hover.setValue(value);
                            }

                            this._marginLeft = value;
                            this._update(false);
                        },
                        this
                    ),
                appendTo: this._relativeContainer
                }
            );

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
            if (this._hasMarginHover === true) {
                this._container.addClass("has-hover");
            }

            if (this._hasMarginHover === null) {
                return this;
            }

            var onCheck = $.proxy(
                function () {
                    this._hasMarginHover = true;
                    this._container.addClass("has-hover");
                    this._update(false);
                },
                this
            );

            var onUnCheck = $.proxy(
                function () {
                    this._hasMarginHover = false;
                    this._container.removeClass("has-hover");
                    this._update(false);
                },
                this
            );

            TestS.Form(
                {
                    type: "checkboxOnOff",
                    value: this._hasMarginHover,
                    label: this._object.getLabel("mouseHoverEffect"),
                    onCheck: onCheck,
                    onUnCheck: onUnCheck,
                    appendTo: this._container
                }
            );

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
            if (this._hasMarginAnimation === null) {
                return this;
            }

            var onCheck = $.proxy(
                function () {
                    this._hasMarginAnimation = true;
                    this._update(false);
                },
                this
            );

            var onUnCheck = $.proxy(
                function () {
                    this._hasMarginAnimation = false;
                    this._update(false);
                },
                this
            );

            TestS.Form(
                {
                    type: "checkboxOnOff",
                    value: this._hasMarginAnimation,
                    label: this._object.getLabel("mouseHoverAnimation"),
                    css: "has-animation",
                    onCheck: onCheck,
                    onUnCheck: onUnCheck,
                    appendTo: this._container
                }
            );

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
            if (isHover === true) {
                if (this._hasMarginHover !== true) {
                    return "";
                }

                return this._getMarginCss(
                    skipAnimation,
                    TestS.Library.getIntVal(
                        this._marginTopHover
                    ),
                    TestS.Library.getIntVal(
                        this._marginRightHover
                    ),
                    TestS.Library.getIntVal(
                        this._marginBottomHover
                    ),
                    TestS.Library.getIntVal(
                        this._marginLeftHover
                    )
                );
            }

            return this._getMarginCss(
                skipAnimation,
                TestS.Library.getIntVal(
                    this._marginTop
                ),
                TestS.Library.getIntVal(
                    this._marginRight
                ),
                TestS.Library.getIntVal(
                    this._marginBottom
                ),
                TestS.Library.getIntVal(
                    this._marginLeft
                )
            );
        },

        /**
         * Gets margin CSS
         *
         * @param {boolean}       skipAnimation
         * @param {Number|String} marginTop
         * @param {Number|String} marginRight
         * @param {Number|String} marginBottom
         * @param {Number|String} marginLeft
         *
         * @returns {String}
         *
         * @private
         */
        _getMarginCss: function (
            skipAnimation,
            marginTop,
            marginRight,
            marginBottom,
            marginLeft
        ) {
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

            var css = "margin:";
            css += marginTop;
            css += " ";
            css += marginRight;
            css += " ";
            css += marginBottom;
            css += " ";
            css += marginLeft;
            css += ";";

            if (skipAnimation !== true
                && this._hasMarginHover === true
                && this._hasMarginAnimation === true
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

            css += ".margin-example-";
            css += this._uniqueId;
            css += "{";
            css += this.generateMarginCss(false, false);
            css += "}";

            css += ".margin-example-";
            css += this._uniqueId;
            css += ":hover{";
            css += this.generateMarginCss(true, false);
            css += "}";

            css += "</style>";

            this._example.html(css);

            if (isOnlyExample !== true) {
                this._object.update();
            }

            return this;
        }
    };
}(window.jQuery, window.TestS);
