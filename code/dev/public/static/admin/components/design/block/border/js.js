!function ($, ss) {
    "use strict";

    var name = "adminComponentsDesignBlockBorder";

    var parameters = {
        /**
         * Parent
         *
         * @var {String}
         */
        parent: "adminComponentsDesignAbstractGroup",

        /**
         * Border top left radius
         *
         * @var {int|null}
         */
        borderTopLeftRadius: null,

        /**
         * Border top left radius hover
         *
         * @var {int|null}
         */
        borderTopLeftRadiusHover: null,

        /**
         * Border top right radius
         *
         * @var {int|null}
         */
        borderTopRightRadius: null,

        /**
         * Border top right radius hover
         *
         * @var {int|null}
         */
        borderTopRightRadiusHover: null,

        /**
         * Border bottom right radius
         *
         * @var {int|null}
         */
        borderBottomRightRadius: null,

        /**
         * Border bottom right radius hover
         *
         * @var {int|null}
         */
        borderBottomRightRadiusHover: null,

        /**
         * Border bottom left radius
         *
         * @var {int|null}
         */
        borderBottomLeftRadius: null,

        /**
         * Border bottom left radius hover
         *
         * @var {int|null}
         */
        borderBottomLeftRadiusHover: null,

        /**
         * Border top width
         *
         * @var {int|null}
         */
        borderTopWidth: null,

        /**
         * Border top width hover
         *
         * @var {int|null}
         */
        borderTopWidthHover: null,

        /**
         * Border right width
         *
         * @var {int|null}
         */
        borderRightWidth: null,

        /**
         * Border right width hover
         *
         * @var {int|null}
         */
        borderRightWidthHover: null,

        /**
         * Border bottom width
         *
         * @var {int|null}
         */
        borderBottomWidth: null,

        /**
         * Border bottom width hover
         *
         * @var {int|null}
         */
        borderBottomWidthHover: null,

        /**
         * Border left width
         *
         * @var {int|null}
         */
        borderLeftWidth: null,

        /**
         * Border left width hover
         *
         * @var {int|null}
         */
        borderLeftWidthHover: null,

        /**
         * Border style
         *
         * @var {int|null}
         */
        borderStyle: null,

        /**
         * Border style hover
         *
         * @var {int|null}
         */
        borderStyleHover: null,

        /**
         * Border color
         *
         * @var {String}
         */
        borderColor: null,

        /**
         * Border color hover
         *
         * @var {String}
         */
        borderColorHover: null,

        /**
         * Has border hover
         *
         * @var {Boolean}
         */
        hasBorderHover: false,

        /**
         * Has border animation
         *
         * @var {Boolean}
         */
        hasBorderAnimation: false,

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
            "borderTopLeftRadius",
            "borderTopLeftRadiusHover",
            "borderTopRightRadius",
            "borderTopRightRadiusHover",
            "borderBottomRightRadius",
            "borderBottomRightRadiusHover",
            "borderBottomLeftRadius",
            "borderBottomLeftRadiusHover",
            "borderTopWidth",
            "borderTopWidthHover",
            "borderRightWidth",
            "borderRightWidthHover",
            "borderBottomWidth",
            "borderBottomWidthHover",
            "borderLeftWidth",
            "borderLeftWidthHover",
            "borderStyle",
            "borderStyleHover",
            "borderColor",
            "borderColorHover",
            "hasBorderHover",
            "hasBorderAnimation"
        ],

        /**
         * Style list
         *
         * @type {Array}
         */
        styleList: [
            {value: 0, label: "", css: "solid"},
            {value: 1, label: "", css: "dotted"},
            {value: 2, label: "", css: "dashed"}
        ],

        /**
         * List of border styles
         *
         * @type {Object}
         */
        borderStyleList: {
            0: "solid",
            1: "dotted",
            2: "dashed"
        },

        /**
         * Init
         */
        init: function () {
            this.borderTopLeftRadius = null;
            this.borderTopLeftRadiusHover = null;
            this.borderTopRightRadius = null;
            this.borderTopRightRadiusHover = null;
            this.borderBottomRightRadius = null;
            this.borderBottomRightRadiusHover = null;
            this.borderBottomLeftRadius = null;
            this.borderBottomLeftRadiusHover = null;
            this.borderTopWidth = null;
            this.borderTopWidthHover = null;
            this.borderRightWidth = null;
            this.borderRightWidthHover = null;
            this.borderBottomWidth = null;
            this.borderBottomWidthHover = null;
            this.borderLeftWidth = null;
            this.borderLeftWidthHover = null;
            this.borderStyle = null;
            this.borderStyleHover = null;
            this.borderColor = null;
            this.borderColorHover = null;
            this.hasBorderHover = false;
            this.hasBorderAnimation = false;

            this.relativeContainer = null;

            this.create(
                {
                    groupContainerSelector: ".border-container",
                    updateSampleEventName: "update-border-sample",
                    title: this.getOption(["labels", "border"])
                }
            );

            this
                .setRelativeContainer()
                .setTopLeftRadius()
                .setTopRightRadius()
                .setBottomRightRadius()
                .setBottomLeftRadius()
                .setTopWidth()
                .setRightWidth()
                .setBottomWidth()
                .setLeftWidth()
                .setStyle()
                .setColor()
                .setHasHover()
                .setStyleHover()
                .setColorHover();
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
         * Sets top left radius
         */
        setTopLeftRadius: function () {
            if (this.borderTopLeftRadius === null) {
                return this;
            }

            var borderTopLeftRadiusHover = null;

            if (this.borderTopLeftRadiusHover !== null) {
                borderTopLeftRadiusHover = ss.init(
                    "commonComponentsFormSpinner",
                    {
                        value: this.borderTopLeftRadiusHover,
                        css: "border-top-left-radius-hover",
                        min: 0,
                        iconBefore: "fa-mouse-pointer",
                        appendTo: this.relativeContainer,
                        callback: $.proxy(
                            function (value) {
                                this.borderTopLeftRadiusHover = value;
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
                    value: this.borderTopLeftRadius,
                    css: "border-top-left-radius",
                    min: 0,
                    appendTo: this.relativeContainer,
                    callback: $.proxy(
                        function (value) {
                            var hover = this.borderTopLeftRadiusHover;
                            if (this.borderTopLeftRadius === hover
                                && borderTopLeftRadiusHover !== null
                            ) {
                                this.borderTopLeftRadiusHover = value;
                                borderTopLeftRadiusHover.setValue(value);
                            }

                            this.borderTopLeftRadius = value;
                            this.update();
                        },
                        this
                    )
                }
            );

            return this;
        },

        /**
         * Sets top right radius
         */
        setTopRightRadius: function () {
            if (this.borderTopRightRadius === null) {
                return this;
            }

            var borderTopRightRadiusHover = null;

            if (this.borderTopRightRadiusHover !== null) {
                borderTopRightRadiusHover = ss.init(
                    "commonComponentsFormSpinner",
                    {
                        value: this.borderTopRightRadiusHover,
                        css: "border-top-right-radius-hover",
                        iconBefore: "fa-mouse-pointer",
                        min: 0,
                        appendTo: this.relativeContainer,
                        callback: $.proxy(
                            function (value) {
                                this.borderTopRightRadiusHover = value;
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
                    value: this.borderTopRightRadius,
                    css: "border-top-right-radius",
                    min: 0,
                    appendTo: this.relativeContainer,
                    callback: $.proxy(
                        function (value) {
                            var hover = this.borderTopRightRadiusHover;
                            if (this.borderTopRightRadius === hover
                                && borderTopRightRadiusHover !== null
                            ) {
                                this.borderTopRightRadiusHover = value;
                                borderTopRightRadiusHover.setValue(value);
                            }

                            this.borderTopRightRadius = value;
                            this.update();
                        },
                        this
                    )
                }
            );

            return this;
        },

        /**
         * Sets bottom right radius
         */
        setBottomRightRadius: function () {
            if (this.borderBottomRightRadius === null) {
                return this;
            }

            var borderBottomRightRadiusHover = null;

            if (this.borderBottomRightRadiusHover !== null) {
                borderBottomRightRadiusHover = ss.init(
                    "commonComponentsFormSpinner",
                    {
                        value: this.borderBottomRightRadiusHover,
                        css: "border-bottom-right-radius-hover",
                        min: 0,
                        iconBefore: "fa-mouse-pointer",
                        appendTo: this.relativeContainer,
                        callback: $.proxy(
                            function (value) {
                                this.borderBottomRightRadiusHover = value;
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
                    value: this.borderBottomRightRadius,
                    css: "border-bottom-right-radius",
                    min: 0,
                    appendTo: this.relativeContainer,
                    callback: $.proxy(
                        function (value) {
                            var hover = this.borderBottomRightRadiusHover;
                            if (this.borderBottomRightRadius === hover
                                && borderBottomRightRadiusHover !== null
                            ) {
                                this.borderBottomRightRadiusHover = value;
                                borderBottomRightRadiusHover.setValue(value);
                            }

                            this.borderBottomRightRadius = value;
                            this.update();
                        },
                        this
                    )
                }
            );

            return this;
        },

        /**
         * Sets bottom left radius
         */
        setBottomLeftRadius: function () {
            if (this.borderBottomLeftRadius === null) {
                return this;
            }

            var borderBottomLeftRadiusHover = null;

            if (this.borderBottomLeftRadiusHover !== null) {
                borderBottomLeftRadiusHover = ss.init(
                    "commonComponentsFormSpinner",
                    {
                        value: this.borderBottomLeftRadiusHover,
                        css: "border-bottom-left-radius-hover",
                        iconBefore: "fa-mouse-pointer",
                        min: 0,
                        appendTo: this.relativeContainer,
                        callback: $.proxy(
                            function (value) {
                                this.borderBottomLeftRadiusHover = value;
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
                    value: this.borderBottomLeftRadius,
                    css: "border-bottom-left-radius",
                    min: 0,
                    appendTo: this.relativeContainer,
                    callback: $.proxy(
                        function (value) {
                            var hover = this.borderBottomLeftRadiusHover;
                            if (this.borderBottomLeftRadius === hover
                                && borderBottomLeftRadiusHover !== null
                            ) {
                                this.borderBottomLeftRadiusHover = value;
                                borderBottomLeftRadiusHover.setValue(value);
                            }

                            this.borderBottomLeftRadius = value;
                            this.update();
                        },
                        this
                    )
                }
            );

            return this;
        },

        /**
         * Sets top width
         */
        setTopWidth: function () {
            if (this.borderTopWidth === null) {
                return this;
            }

            var borderTopWidthHover = null;

            if (this.borderTopWidthHover !== null) {
                borderTopWidthHover = ss.init(
                    "commonComponentsFormSpinner",
                    {
                        value: this.borderTopWidthHover,
                        css: "border-top-width-hover",
                        min: 0,
                        iconBefore: "fa-mouse-pointer",
                        appendTo: this.relativeContainer,
                        callback: $.proxy(
                            function (value) {
                                this.borderTopWidthHover = value;
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
                    value: this.borderTopWidth,
                    css: "border-top-width",
                    min: 0,
                    appendTo: this.relativeContainer,
                    callback: $.proxy(
                        function (value) {
                            if (this.borderTopWidth === this.borderTopWidthHover
                                && borderTopWidthHover !== null
                            ) {
                                this.borderTopWidthHover = value;
                                borderTopWidthHover.setValue(value);
                            }

                            this.borderTopWidth = value;
                            this.update();
                        },
                        this
                    )
                }
            );

            return this;
        },

        /**
         * Sets right width
         */
        setRightWidth: function () {
            if (this.borderRightWidth === null) {
                return this;
            }

            var borderRightWidthHover = null;

            if (this.borderRightWidthHover !== null) {
                borderRightWidthHover = ss.init(
                    "commonComponentsFormSpinner",
                    {
                        value: this.borderRightWidthHover,
                        css: "border-right-width-hover",
                        min: 0,
                        iconBefore: "fa-mouse-pointer",
                        appendTo: this.relativeContainer,
                        callback: $.proxy(
                            function (value) {
                                this.borderRightWidthHover = value;
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
                    value: this.borderRightWidth,
                    css: "border-right-width",
                    min: 0,
                    appendTo: this.relativeContainer,
                    callback: $.proxy(
                        function (value) {
                            var hover = this.borderRightWidthHover;
                            if (this.borderRightWidth === hover
                                && borderRightWidthHover !== null
                            ) {
                                this.borderRightWidthHover = value;
                                borderRightWidthHover.setValue(value);
                            }

                            this.borderRightWidth = value;
                            this.update();
                        },
                        this
                    )
                }
            );

            return this;
        },

        /**
         * Sets bottom width
         */
        setBottomWidth: function () {
            if (this.borderBottomWidth === null) {
                return this;
            }

            var borderBottomWidthHover = null;

            if (this.borderBottomWidthHover !== null) {
                borderBottomWidthHover = ss.init(
                    "commonComponentsFormSpinner",
                    {
                        value: this.borderBottomWidthHover,
                        css: "border-bottom-width-hover",
                        min: 0,
                        iconBefore: "fa-mouse-pointer",
                        appendTo: this.relativeContainer,
                        callback: $.proxy(
                            function (value) {
                                this.borderBottomWidthHover = value;
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
                    value: this.borderBottomWidth,
                    css: "border-bottom-width",
                    min: 0,
                    appendTo: this.relativeContainer,
                    callback: $.proxy(
                        function (value) {
                            var hover = this.borderBottomWidthHover;
                            if (this.borderBottomWidth === hover
                                && borderBottomWidthHover !== null
                            ) {
                                this.borderBottomWidthHover = value;
                                borderBottomWidthHover.setValue(value);
                            }

                            this.borderBottomWidth = value;
                            this.update();
                        },
                        this
                    )
                }
            );

            return this;
        },

        /**
         * Sets left width
         */
        setLeftWidth: function () {
            if (this.borderLeftWidth === null) {
                return this;
            }

            var borderLeftWidthHover = null;

            if (this.borderLeftWidthHover !== null) {
                borderLeftWidthHover = ss.init(
                    "commonComponentsFormSpinner",
                    {
                        value: this.borderLeftWidthHover,
                        css: "border-left-width-hover",
                        min: 0,
                        iconBefore: "fa-mouse-pointer",
                        appendTo: this.relativeContainer,
                        callback: $.proxy(
                            function (value) {
                                this.borderLeftWidthHover = value;
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
                    value: this.borderLeftWidth,
                    css: "border-left-width",
                    min: 0,
                    appendTo: this.relativeContainer,
                    callback: $.proxy(
                        function (value) {
                            var width = this.borderLeftWidth;
                            var widthHover = this.borderLeftWidthHover;

                            if (width === widthHover
                                && borderLeftWidthHover !== null
                            ) {
                                this.borderLeftWidthHover = value;
                                borderLeftWidthHover.setValue(value);
                            }

                            this.borderLeftWidth = value;
                            this.update();
                        },
                        this
                    )
                }
            );

            return this;
        },

        /**
         * Sets style
         */
        setStyle: function () {
            if (this.borderStyle === null) {
                return this;
            }

            ss.init(
                "commonComponentsFormRadioButtons",
                {
                    label: this.getLabel("borderStyle"),
                    value: this.borderStyle,
                    data: this.styleList,
                    appendTo: this.getGroupContainer(),
                    onChange: $.proxy(
                        function (value) {
                            this.borderStyle = value;
                            this.update();
                        },
                        this
                    )
                }
            );

            return this;
        },

        /**
         * Sets color
         */
        setColor: function () {
            if (this.borderColor === null) {
                return this;
            }

            ss.init(
                "commonComponentsFormColor",
                {
                    label: this.getLabel("borderColor"),
                    title: this.getLabel("borderColor"),
                    value: this.borderColor,
                    appendTo: this.getGroupContainer(),
                    callback: $.proxy(
                        function (color) {
                            this.borderColor = color;
                            this.update();
                        },
                        this
                    )
                }
            );

            return this;
        },

        /**
         * Sets has hover
         */
        setHasHover: function () {
            if (this.hasBorderHover === null) {
                return this;
            }

            if (this.hasBorderHover === true) {
                this.getGroupContainer().addClass("has-hover");
            }

            var onCheck = $.proxy(
                function () {
                    this.hasBorderHover = true;
                    this.getGroupContainer().addClass("has-hover");
                    this.update();
                },
                this
            );

            var onUnCheck = $.proxy(
                function () {
                    this.hasBorderHover = false;
                    this.getGroupContainer().removeClass("has-hover");
                    this.update();
                },
                this
            );

            ss.init(
                "commonComponentsFormCheckboxOnOff",
                {
                    value: this.hasBorderHover,
                    label: this.getLabel("mouseHoverEffect"),
                    appendTo: this.getGroupContainer(),
                    onCheck: onCheck,
                    onUnCheck: onUnCheck
                }
            );

            return this;
        },

        /**
         * Sets style hover
         */
        setStyleHover: function () {
            if (this.borderStyleHover === null) {
                return this;
            }

            ss.init(
                "commonComponentsFormRadioButtons",
                {
                    label: this.getLabel("borderStyleHover"),
                    value: this.borderStyleHover,
                    css: "border-style-hover",
                    data: this.styleList,
                    appendTo: this.getGroupContainer(),
                    onChange: $.proxy(
                        function (value) {
                            this.borderStyleHover = value;
                            this.update();
                        },
                        this
                    )
                }
            );

            return this;
        },

        /**
         * Sets color hover
         */
        setColorHover: function () {
            if (this.borderColorHover === null) {
                return this;
            }

            ss.init(
                "commonComponentsFormColor",
                {
                    label: this.getLabel("borderColorHover"),
                    title: this.getLabel("borderColor"),
                    value: this.borderColorHover,
                    css: "border-color-hover",
                    appendTo: this.getGroupContainer(),
                    callback: $.proxy(
                        function (color) {
                            this.borderColorHover = color;
                            this.update();
                        },
                        this
                    )
                }
            );

            return this;
        },

        /**
         * Sets has animation
         */
        setHasAnimation: function () {
            if (this.hasBorderAnimation === null) {
                return this;
            }

            var onCheck = $.proxy(
                function () {
                    this.hasBorderAnimation = true;
                    this.update();
                },
                this
            );

            var onUnCheck = $.proxy(
                function () {
                    this.hasBorderAnimation = false;
                    this.update();
                },
                this
            );

            ss.init(
                "commonComponentsFormCheckboxOnOff",
                {
                    value: this.hasBorderAnimation,
                    label: this.getLabel("mouseHoverAnimation"),
                    css: "has-border-animation",
                    appendTo: this.getGroupContainer(),
                    onCheck: onCheck,
                    onUnCheck: onUnCheck
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
            var borderTopLeftRadius,
                borderTopRightRadius,
                borderBottomRightRadius,
                borderBottomLeftRadius,
                borderTopWidth,
                borderRightWidth,
                borderBottomWidth,
                borderLeftWidth,
                borderColor;

            if (isHover === true) {
                if (this.hasBorderHover !== true) {
                    return "";
                }

                borderTopLeftRadius = this.getIntValue(
                    this.borderTopLeftRadiusHover
                );
                borderTopRightRadius = this.getIntValue(
                    this.borderTopRightRadiusHover
                );
                borderBottomRightRadius = this.getIntValue(
                    this.borderBottomRightRadiusHover
                );
                borderBottomLeftRadius = this.getIntValue(
                    this.borderBottomLeftRadiusHover
                );

                borderTopWidth = this.getIntValue(
                    this.borderTopWidthHover
                );
                borderRightWidth = this.getIntValue(
                    this.borderRightWidthHover
                );
                borderBottomWidth = this.getIntValue(
                    this.borderBottomWidthHover
                );
                borderLeftWidth = this.getIntValue(
                    this.borderLeftWidthHover
                );

                borderColor = this.borderColorHover;
            } else {
                borderTopLeftRadius = this.getIntValue(
                    this.borderTopLeftRadius
                );
                borderTopRightRadius = this.getIntValue(
                    this.borderTopRightRadius
                );
                borderBottomRightRadius = this.getIntValue(
                    this.borderBottomRightRadius
                );
                borderBottomLeftRadius = this.getIntValue(
                    this.borderBottomLeftRadius
                );

                borderTopWidth = this.getIntValue(
                    this.borderTopWidth
                );
                borderRightWidth = this.getIntValue(
                    this.borderRightWidth
                );
                borderBottomWidth = this.getIntValue(
                    this.borderBottomWidth
                );
                borderLeftWidth = this.getIntValue(
                    this.borderLeftWidth
                );

                borderColor = this.borderColor;
            }

            var css = this.generateBorderRadius(
                borderTopLeftRadius,
                borderTopRightRadius,
                borderBottomRightRadius,
                borderBottomLeftRadius
            );

            css += this.generateBorderWidth(
                borderTopWidth,
                borderRightWidth,
                borderBottomWidth,
                borderLeftWidth
            );

            css += this.generateBorderColor(borderColor);

            css += "border-style:" + this.getBorderStyle(isHover) + ";";

            return css;
        },

        /**
         * Generates styles
         *
         * @param {String} borderColor
         *
         * @returns {String}
         */
        generateBorderColor: function (borderColor) {
            if (borderColor === null) {
                borderColor = "";
            }

            if (borderColor === "") {
                borderColor = "transparent";
            }

            return "border-color:" + borderColor + ";";
        },

        /**
         * Generates styles
         *
         * @param {String|int} top
         * @param {String|int} right
         * @param {String|int} bottom
         * @param {String|int} left
         *
         * @returns {String}
         */
        generateBorderWidth: function (top, right, bottom, left) {
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

            var css = "";

            css += "border-width:";
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
         * Generates styles
         *
         * @param {String|int} topL
         * @param {String|int} topR
         * @param {String|int} bottomR
         * @param {String|int} bottomL
         *
         * @returns {String}
         */
        generateBorderRadius: function (topL, topR, bottomR, bottomL) {
            if (topL !== 0) {
                topL += "px";
            }

            if (topR !== 0) {
                topR += "px";
            }

            if (bottomR !== 0) {
                bottomR += "px";
            }

            if (bottomL !== 0) {
                bottomL += "px";
            }

            var css = "";

            css += "-webkit-border-radius:";
            css += topL + " ";
            css += topR + " ";
            css += bottomR + " ";
            css += bottomL + ";";

            css += "-moz-border-radius:";
            css += topL + " ";
            css += topR + " ";
            css += bottomR + " ";
            css += bottomL + ";";

            css += "border-radius:";
            css += topL + " ";
            css += topR + " ";
            css += bottomR + " ";
            css += bottomL + ";";

            return css;
        },

        /**
         * Has animation
         *
         * @return {boolean}
         */
        hasAnimation: function () {
            return this.hasBorderHover === true
                && this.hasBorderAnimation === true;
        },

        /**
         * Gets border style
         *
         * @param {boolean} isHover
         *
         * @return {String}
         */
        getBorderStyle: function (isHover) {
            var borderStyle;

            if (isHover === true) {
                borderStyle = this.borderStyleHover;
            } else {
                borderStyle = this.borderStyle;
            }

            if (this.borderStyleList[borderStyle] !== undefined) {
                return this.borderStyleList[borderStyle];
            }

            return this.borderStyleList[0];
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
