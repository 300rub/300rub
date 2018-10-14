!function ($, ss) {
    "use strict";

    var name = "adminComponentsDesignBlockPadding";

    var parameters = {
        /**
         * Parent
         *
         * @var {String}
         */
        parent: "adminComponentsDesignAbstractGroup",

        /**
         * Padding top
         *
         * @var {int|null}
         */
        paddingTop: null,

        /**
         * Padding right
         *
         * @var {int|null}
         */
        paddingRight: null,

        /**
         * Padding bottom
         *
         * @var {int|null}
         */
        paddingBottom: null,

        /**
         * Padding left
         *
         * @var {int|null}
         */
        paddingLeft: null,

        /**
         * Padding top hover
         *
         * @var {int|null}
         */
        paddingTopHover: null,

        /**
         * Padding right hover
         *
         * @var {int|null}
         */
        paddingRightHover: null,

        /**
         * Padding bottom hover
         *
         * @var {int|null}
         */
        paddingBottomHover: null,

        /**
         * Padding left hover
         *
         * @var {int|null}
         */
        paddingLeftHover: null,

        /**
         * Has padding hover
         *
         * @var {boolean}
         */
        hasPaddingHover: false,

        /**
         * Has padding animation
         *
         * @var {boolean}
         */
        hasPaddingAnimation: false,

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
        ],

        /**
         * Init
         */
        init: function () {
            this.paddingTop = null;
            this.paddingRight = null;
            this.paddingBottom = null;
            this.paddingLeft = null;
            this.paddingTopHover = null;
            this.paddingRightHover = null;
            this.paddingBottomHover = null;
            this.paddingLeftHover = null;
            this.hasPaddingHover = false;
            this.hasPaddingAnimation = false;

            this.relativeContainer = null;

            this.create(
                {
                    groupContainerSelector: ".padding-container",
                    updateSampleEventName: "update-padding-sample"
                }
            );

            this
                .setRelativeContainer()
                .setPaddingTop()
                .setPaddingRight()
                .setPaddingBottom()
                .setPaddingLeft()
                .setPaddingHover()
                .setHasAnimation();
        },

        /**
         * Sets relative container
         */
        setRelativeContainer: function () {
            this.relativeContainer
                = this.getGroupContainer().find(".relative-container");
            return this;
        },

        /**
         * Sets padding-top
         */
        setPaddingTop: function () {
            if (this.paddingTop === null) {
                return this;
            }

            var hover = null;

            if (this.paddingTopHover !== null) {
                hover = ss.init(
                    "commonComponentsFormSpinner",
                    {
                        value: this.paddingTopHover,
                        css: "padding-top-hover",
                        iconBefore: "fa-mouse-pointer",
                        appendTo: this.relativeContainer,
                        callback: $.proxy(
                            function (value) {
                                this.paddingTopHover = value;
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
                    value: this.paddingTop,
                    css: "padding-top",
                    appendTo: this.relativeContainer,
                    callback: $.proxy(
                        function (value) {
                            var paddingTop = this.paddingTop;
                            var paddingTopHover
                                = this.paddingTopHover;
                            if (paddingTop === paddingTopHover
                                && hover !== null
                            ) {
                                this.paddingTopHover = value;
                                hover.setValue(value);
                            }

                            this.paddingTop = value;
                            this.update();
                        },
                        this
                    )
                }
            );

            return this;
        },

        /**
         * Sets padding-right
         */
        setPaddingRight: function () {
            if (this.paddingRight === null) {
                return this;
            }

            var hover = null;

            if (this.paddingRightHover !== null) {
                hover = ss.init(
                    "commonComponentsFormSpinner",
                    {
                        value: this.paddingRightHover,
                        css: "padding-right-hover",
                        iconBefore: "fa-mouse-pointer",
                        appendTo: this.relativeContainer,
                        callback: $.proxy(
                            function (value) {
                                this.paddingRightHover = value;
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
                    value: this.paddingRight,
                    css: "padding-right",
                    appendTo: this.relativeContainer,
                    callback: $.proxy(
                        function (value) {
                            var paddingRight
                                = this.paddingRight;
                            var paddingRightHover
                                = this.paddingRightHover;
                            if (paddingRight === paddingRightHover
                                && hover !== null
                            ) {
                                this.paddingRightHover = value;
                                hover.setValue(value);
                            }

                            this.paddingRight = value;
                            this.update();
                        },
                        this
                    )
                }
            );

            return this;
        },

        /**
         * Sets padding-bottom
         */
        setPaddingBottom: function () {
            if (this.paddingBottom === null) {
                return this;
            }

            var hover = null;

            if (this.paddingBottomHover !== null) {
                hover = ss.init(
                    "commonComponentsFormSpinner",
                    {
                        value: this.paddingBottomHover,
                        css: "padding-bottom-hover",
                        iconBefore: "fa-mouse-pointer",
                        appendTo: this.relativeContainer,
                        callback: $.proxy(
                            function (value) {
                                this.paddingBottomHover = value;
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
                    value: this.paddingBottom,
                    css: "padding-bottom",
                    appendTo: this.relativeContainer,
                    callback: $.proxy(
                        function (value) {
                            var paddingBottom
                                = this.paddingBottom;
                            var paddingBottomHover
                                = this.paddingBottomHover;
                            if (paddingBottom === paddingBottomHover
                                && hover !== null
                            ) {
                                this.paddingBottomHover = value;
                                hover.setValue(value);
                            }

                            this.paddingBottom = value;
                            this.update();
                        },
                        this
                    )
                }
            );

            return this;
        },

        /**
         * Sets padding-left
         */
        setPaddingLeft: function () {
            if (this.paddingLeft === null) {
                return this;
            }

            var hover = null;

            if (this.paddingLeftHover !== null) {
                hover = ss.init(
                    "commonComponentsFormSpinner",
                    {
                        value: this.paddingLeftHover,
                        css: "padding-left-hover",
                        iconBefore: "fa-mouse-pointer",
                        appendTo: this.relativeContainer,
                        callback: $.proxy(
                            function (value) {
                                this.paddingLeftHover = value;
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
                    value: this.paddingLeft,
                    css: "padding-left",
                    appendTo: this.relativeContainer,
                    callback: $.proxy(
                        function (value) {
                            var paddingLeft
                                = this.paddingLeft;
                            var paddingLeftHover
                                = this.paddingLeftHover;
                            if (paddingLeft === paddingLeftHover
                                && hover !== null
                            ) {
                                this.paddingLeftHover = value;
                                hover.setValue(value);
                            }

                            this.paddingLeft = value;
                            this.update();
                        },
                        this
                    )
                }
            );

            return this;
        },

        /**
         * Sets padding hover
         */
        setPaddingHover: function () {
            if (this.hasPaddingHover === true) {
                this.getGroupContainer().addClass("has-hover");
            }

            if (this.hasPaddingHover === false) {
                return this;
            }

            var onCheck = $.proxy(
                function () {
                    this.hasPaddingHover = true;
                    this.getGroupContainer().addClass("has-hover");
                    this.update();
                },
                this
            );

            var onUnCheck = $.proxy(
                function () {
                    this.hasPaddingHover = false;
                    this.getGroupContainer().removeClass("has-hover");
                    this.update();
                },
                this
            );

            ss.init(
                "commonComponentsFormCheckboxOnOff",
                {
                    value: this.hasPaddingHover,
                    label: this.getLabel("mouseHoverEffect"),
                    onCheck: onCheck,
                    onUnCheck: onUnCheck,
                    appendTo: this.getGroupContainer()
                }
            );

            return this;
        },

        /**
         * Sets padding animation
         */
        setHasAnimation: function () {
            if (this.hasPaddingAnimation === false) {
                return this;
            }

            var onCheck = $.proxy(
                function () {
                    this.hasPaddingAnimation = true;
                    this.update();
                },
                this
            );

            var onUnCheck = $.proxy(
                function () {
                    this.hasPaddingAnimation = false;
                    this.update();
                },
                this
            );

            ss.init(
                "commonComponentsFormCheckboxOnOff",
                {
                    value: this.hasPaddingAnimation,
                    label: this.getLabel("mouseHoverAnimation"),
                    css: "has-animation",
                    onCheck: onCheck,
                    onUnCheck: onUnCheck,
                    appendTo: this.getGroupContainer()
                }
            );

            return this;
        },

        /**
         * Generates padding styles
         */
        generateCss: function (isHover) {
            if (isHover === true) {
                if (this.hasPaddingHover !== true) {
                    return "";
                }

                return this.getCss(
                    this.getIntValue(
                        this.paddingTopHover
                    ),
                    this.getIntValue(
                        this.paddingRightHover
                    ),
                    this.getIntValue(
                        this.paddingBottomHover
                    ),
                    this.getIntValue(
                        this.paddingLeftHover
                    )
                );
            }

            return this.getCss(
                this.getIntValue(
                    this.paddingTop
                ),
                this.getIntValue(
                    this.paddingRight
                ),
                this.getIntValue(
                    this.paddingBottom
                ),
                this.getIntValue(
                    this.paddingLeft
                )
            );
        },

        /**
         * Gets padding CSS
         *
         * @param {Number|String} top
         * @param {Number|String} right
         * @param {Number|String} bottom
         * @param {Number|String} left
         *
         * @returns {String}
         */
        getCss: function (top, right, bottom, left) {
            if (top !== 0) {
                top += "px";
            }

            if (right !== 0) {
                right += "px";
            }

            if (bottom !== 0) {
                bottom += "px";
            }

            if (left !== 0) {
                left += "px";
            }

            var css = "padding:";
            css += top;
            css += " ";
            css += right;
            css += " ";
            css += bottom;
            css += " ";
            css += left;
            css += ";";

            return css;
        },

        /**
         * Has animation
         *
         * @return {boolean}
         */
        hasAnimation: function () {
            return this.hasPaddingHover === true
                && this.hasPaddingAnimation === true;
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
