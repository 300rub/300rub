!function ($, TestS) {
    'use strict';

    /**
     * Padding
     *
     * @property {TestS.Panel.Design.Block} _object
     *
     * @type {Object}
     */
    TestS.Panel.Design.Block.Padding = function () {
        this._object = null;

        this._container = null;
        this._relativeContainer = null;
        this._example = null;

        this._uniqueId = 0;

        this._paddingTop = null;
        this._paddingRight = null;
        this._paddingBottom = null;
        this._paddingLeft = null;
        this._paddingTopHover = null;
        this._paddingRightHover = null;
        this._paddingBottomHover = null;
        this._paddingLeftHover = null;
        this._hasPaddingHover = null;
        this._hasPaddingAnimation = null;
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    TestS.Panel.Design.Block.Padding.prototype = {

        /**
         * Init
         *
         * @param {TestS.Panel.Design.Block} object
         */
        init: function (object) {
            this._object = $.extend({}, object);

            this._container = this._object
                .getDesignContainer()
                .find(".padding-container");

            this._setValues();

            if (this._paddingTop === null
                && this._paddingRight === null
                && this._paddingBottom === null
                && this._paddingLeft === null
            ) {
                this._container.remove();
                return this;
            }

            this
                ._setInitialSettings()
                ._setPaddingTop()
                ._setPaddingRight()
                ._setPaddingBottom()
                ._setPaddingLeft()
                ._setPaddingHover()
                ._setHasPaddingAnimation()
                ._update(true);
        },

        /**
         * Sets values
         *
         * @return {TestS.Panel.Design.Block.Padding}
         *
         * @private
         */
        _setValues: function () {
            var values = this._object.getValues();

            var keys = [
                "paddingTop",
                "paddingRight",
                "paddingBottom",
                "paddingLeft",
                "paddingTopHover",
                "paddingRightHover",
                "paddingBottomHover",
                "paddingLeftHover",
                "hasPaddingHover",
                "hasPaddingAnimation"
            ];

            $.each(
                keys,
                $.proxy(
                    function (index, key) {
                        if (values[key] !== undefined) {
                            this["_" + key] = values[key];
                        }
                    },
                    this
                )
            );

            return this;
        },

        /**
         * Initial settings
         *
         * @returns {TestS.Panel.Design.Block.Padding}
         *
         * @private
         */
        _setInitialSettings: function () {
            this._example = this._container.find(".styles-example-container");

            this._container
                .find(".category-title")
                .text(this._object.getLabel("padding"));

            this._uniqueId = TestS.Library.getUniqueId();
            this._example = this._container
                .find(".padding-example")
                .addClass("padding-example-" + this._uniqueId);

            this._relativeContainer
                = this._container.find(".relative-container");

            return this;
        },

        /**
         * Sets padding-top
         *
         * @returns {TestS.Panel.Design.Block.Padding}
         *
         * @private
         */
        _setPaddingTop: function () {
            if (this._paddingTop === null) {
                return this;
            }

            var hover = null;

            if (this._paddingTopHover !== null) {
                hover = new TestS.Form.Spinner(
                    {
                        value: this._paddingTopHover,
                        css: "padding-top-hover",
                        iconBefore: "fa-mouse-pointer",
                        appendTo: this._relativeContainer,
                        callback: $.proxy(
                            function (value) {
                                this._paddingTopHover = value;
                                this._update(false);
                            },
                            this
                        )
                    }
                );
            }

            new TestS.Form.Spinner(
                {
                    value: this._paddingTop,
                    css: "padding-top",
                    appendTo: this._relativeContainer,
                    callback: $.proxy(
                        function (value) {
                            var paddingTop = this._paddingTop;
                            var paddingTopHover
                            = this._paddingTopHover;
                            if (paddingTop === paddingTopHover
                                && hover !== null
                            ) {
                                this._paddingTopHover = value;
                                hover.setValue(value);
                            }

                            this._paddingTop = value;
                            this._update(false);
                        },
                        this
                    )
                }
            );

            return this;
        },

        /**
         * Sets padding-right
         *
         * @returns {TestS.Panel.Design.Block.Padding}
         *
         * @private
         */
        _setPaddingRight: function () {
            if (this._paddingRight === null) {
                return this;
            }

            var hover = null;

            if (this._paddingRightHover !== null) {
                hover = new TestS.Form.Spinner(
                    {
                        value: this._paddingRightHover,
                        css: "padding-right-hover",
                        iconBefore: "fa-mouse-pointer",
                        appendTo: this._relativeContainer,
                        callback: $.proxy(
                            function (value) {
                                this._paddingRightHover = value;
                                this._update(false);
                            },
                            this
                        )
                    }
                );
            }

            new TestS.Form.Spinner(
                {
                    value: this._paddingRight,
                    css: "padding-right",
                    appendTo: this._relativeContainer,
                    callback: $.proxy(
                        function (value) {
                            var paddingRight
                                = this._paddingRight;
                            var paddingRightHover
                            = this._paddingRightHover;
                            if (paddingRight === paddingRightHover
                                && hover !== null
                            ) {
                                this._paddingRightHover = value;
                                hover.setValue(value);
                            }

                            this._paddingRight = value;
                            this._update(false);
                        },
                        this
                    )
                }
            );

            return this;
        },

        /**
         * Sets padding-bottom
         *
         * @returns {TestS.Panel.Design.Block.Padding}
         *
         * @private
         */
        _setPaddingBottom: function () {
            if (this._paddingBottom === null) {
                return this;
            }

            var hover = null;

            if (this._paddingBottomHover !== null) {
                hover = new TestS.Form.Spinner(
                    {
                        value: this._paddingBottomHover,
                        css: "padding-bottom-hover",
                        iconBefore: "fa-mouse-pointer",
                        appendTo: this._relativeContainer,
                        callback: $.proxy(
                            function (value) {
                                this._paddingBottomHover = value;
                                this._update(false);
                            },
                            this
                        )
                    }
                );
            }

            new TestS.Form.Spinner(
                {
                    value: this._paddingBottom,
                    css: "padding-bottom",
                    appendTo: this._relativeContainer,
                    callback: $.proxy(
                        function (value) {
                            var paddingBottom
                                = this._paddingBottom;
                            var paddingBottomHover
                            = this._paddingBottomHover;
                            if (paddingBottom === paddingBottomHover
                                && hover !== null
                            ) {
                                this._paddingBottomHover = value;
                                hover.setValue(value);
                            }

                            this._paddingBottom = value;
                            this._update(false);
                        },
                        this
                    )
                }
            );

            return this;
        },

        /**
         * Sets padding-left
         *
         * @returns {TestS.Panel.Design.Block.Padding}
         *
         * @private
         */
        _setPaddingLeft: function () {
            if (this._paddingLeft === null) {
                return this;
            }

            var hover = null;

            if (this._paddingLeftHover !== null) {
                hover = new TestS.Form.Spinner(
                    {
                        value: this._paddingLeftHover,
                        css: "padding-left-hover",
                        iconBefore: "fa-mouse-pointer",
                        appendTo: this._relativeContainer,
                        callback: $.proxy(
                            function (value) {
                                this._paddingLeftHover = value;
                                this._update(false);
                            },
                            this
                        )
                    }
                );
            }

            new TestS.Form.Spinner(
                {
                    value: this._paddingLeft,
                    css: "padding-left",
                    appendTo: this._relativeContainer,
                    callback: $.proxy(
                        function (value) {
                            var paddingLeft
                                = this._paddingLeft;
                            var paddingLeftHover
                            = this._paddingLeftHover;
                            if (paddingLeft === paddingLeftHover
                                && hover !== null
                            ) {
                                this._paddingLeftHover = value;
                                hover.setValue(value);
                            }

                            this._paddingLeft = value;
                            this._update(false);
                        },
                        this
                    )
                }
            );

            return this;
        },

        /**
         * Sets padding hover
         *
         * @returns {TestS.Panel.Design.Block.Padding}
         *
         * @private
         */
        _setPaddingHover: function () {
            if (this._hasPaddingHover === true) {
                this._container.addClass("has-hover");
            }

            if (this._hasPaddingHover === null) {
                return this;
            }

            var onCheck = $.proxy(
                function () {
                    this._hasPaddingHover = true;
                    this._container.addClass("has-hover");
                    this._update(false);
                },
                this
            );

            var onUnCheck = $.proxy(
                function () {
                    this._hasPaddingHover = false;
                    this._container.removeClass("has-hover");
                    this._update(false);
                },
                this
            );

            new TestS.Form.CheckboxOnOff(
                {
                    value: this._hasPaddingHover,
                    label: this._object.getLabel("mouseHoverEffect"),
                    onCheck: onCheck,
                    onUnCheck: onUnCheck,
                    appendTo: this._container
                }
            );

            return this;
        },

        /**
         * Sets padding animation
         *
         * @returns {TestS.Panel.Design.Block.Padding}
         *
         * @private
         */
        _setHasPaddingAnimation: function () {
            if (this._hasPaddingAnimation === null) {
                return this;
            }

            var onCheck = $.proxy(
                function () {
                    this._hasPaddingAnimation = true;
                    this._update(false);
                },
                this
            );

            var onUnCheck = $.proxy(
                function () {
                    this._hasPaddingAnimation = false;
                    this._update(false);
                },
                this
            );

            new TestS.Form.CheckboxOnOff(
                {
                    value: this._hasPaddingAnimation,
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
         * Generates padding styles
         *
         * @param {boolean} isHover
         * @param {boolean} skipAnimation
         *
         * @returns {String}
         */
        generateCss: function (isHover, skipAnimation) {
            if (isHover === true) {
                if (this._hasPaddingHover !== true) {
                    return "";
                }

                return this._getCss(
                    skipAnimation,
                    TestS.Library.getIntVal(
                        this._paddingTopHover
                    ),
                    TestS.Library.getIntVal(
                        this._paddingRightHover
                    ),
                    TestS.Library.getIntVal(
                        this._paddingBottomHover
                    ),
                    TestS.Library.getIntVal(
                        this._paddingLeftHover
                    )
                );
            }

            return this._getCss(
                skipAnimation,
                TestS.Library.getIntVal(
                    this._paddingTop
                ),
                TestS.Library.getIntVal(
                    this._paddingRight
                ),
                TestS.Library.getIntVal(
                    this._paddingBottom
                ),
                TestS.Library.getIntVal(
                    this._paddingLeft
                )
            );
        },

        /**
         * Gets padding CSS
         *
         * @param {boolean}       skipAnimation
         * @param {Number|String} paddingTop
         * @param {Number|String} paddingRight
         * @param {Number|String} paddingBottom
         * @param {Number|String} paddingLeft
         *
         * @returns {String}
         *
         * @private
         */
        _getCss: function (
            skipAnimation,
            paddingTop,
            paddingRight,
            paddingBottom,
            paddingLeft
        ) {
            if (paddingTop !== 0) {
                paddingTop += "px";
            }

            if (paddingRight !== 0) {
                paddingRight += "px";
            }

            if (paddingBottom !== 0) {
                paddingBottom += "px";
            }

            if (paddingLeft !== 0) {
                paddingLeft += "px";
            }

            var css = "padding:";
            css += paddingTop;
            css += " ";
            css += paddingRight;
            css += " ";
            css += paddingBottom;
            css += " ";
            css += paddingLeft;
            css += ";";

            if (skipAnimation !== true
                && this._hasPaddingHover === true
                && this._hasPaddingAnimation === true
            ) {
                css += "-webkit-transition:padding .3s;";
                css += "-ms-transition:padding .3s;";
                css += "-o-transition:padding .3s;";
                css += "transition:padding .3s;";
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

            css += ".padding-example-";
            css += this._uniqueId;
            css += "{";
            css += this.generateCss(false, false);
            css += "}";

            css += ".padding-example-";
            css += this._uniqueId;
            css += ":hover{";
            css += this.generateCss(true, false);
            css += "}";

            css += "</style>";

            this._example.html(css);

            if (isOnlyExample !== true) {
                this._object.update();
            }

            return this;
        },

        /**
         * Has animation
         *
         * @return {boolean}
         */
        hasAnimation: function () {
            return this._hasPaddingHover === true
                && this._hasPaddingAnimation === true;
        }
    };
}(window.jQuery, window.TestS);
