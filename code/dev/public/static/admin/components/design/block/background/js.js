!function ($, ss) {
    "use strict";

    var name = "adminComponentsDesignBlockBackground";

    var parameters = {
        /**
         * Parent
         *
         * @var {String}
         */
        parent: "adminComponentsDesignAbstractGroup",

        /**
         * Background color from
         *
         * @var {String}
         */
        backgroundColorFrom: null,

        /**
         * Background color from hover
         *
         * @var {String}
         */
        backgroundColorFromHover: null,

        /**
         * Background color to
         *
         * @var {String}
         */
        backgroundColorTo: null,

        /**
         * Background color to hover
         *
         * @var {String}
         */
        backgroundColorToHover: null,

        /**
         * Background direction
         *
         * @var {int|null}
         */
        gradientDirection: null,

        /**
         * Background direction hover
         *
         * @var {int|null}
         */
        gradientDirectionHover: null,

        /**
         * Has Background Gradient
         *
         * @var {Boolean}
         */
        hasBackgroundGradient: false,

        /**
         * Has Background hover
         *
         * @var {Boolean}
         */
        hasBackgroundHover: false,

        /**
         * Has Background animation
         *
         * @var {Boolean}
         */
        hasBackgroundAnimation: false,

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
            "backgroundColorFrom",
            "backgroundColorFromHover",
            "backgroundColorTo",
            "backgroundColorToHover",
            "gradientDirection",
            "gradientDirectionHover",
            "hasBackgroundGradient",
            "hasBackgroundHover",
            "hasBackgroundAnimation"
        ],

        /**
         * Gradient directions
         *
         * @type {Array}
         */
        gradientDirections: [
            {value: 0, icon: "fa-long-arrow-right"},
            {value: 1, icon: "fa-long-arrow-down"},
            {value: 2, icon: "fa-long-arrow-right", css: "deg-45"},
            {value: 3, icon: "fa-long-arrow-up", css: "deg-45"}
        ],

        /**
         * List of gradient directions options
         *
         * @var {Object}
         */
        gradientDirectionList: {
            0: {
                "mozLinear": "left",
                "webkit": "linear, left top, right top",
                "webkitLinear": "left",
                "oLinear": "left",
                "msLinear": "left",
                "linear": "to right",
                "ie": 1
            },
            1: {
                "mozLinear": "top",
                "webkit": "linear, left top, left bottom",
                "webkitLinear": "top",
                "oLinear": "top",
                "msLinear": "top",
                "linear": "to bottom",
                "ie": 0
            },
            2: {
                "mozLinear": "-45deg",
                "webkit": "linear, left top, right bottom",
                "webkitLinear": "-45deg",
                "oLinear": "-45deg",
                "msLinear": "-45deg",
                "linear": "135deg",
                "ie": 1
            },
            3: {
                "mozLinear": "45deg",
                "webkit": "linear, left bottom, right top",
                "webkitLinear": "45deg",
                "oLinear": "45deg",
                "msLinear": "45deg",
                "linear": "45deg",
                "ie": 1
            }
        },

        /**
         * Init
         */
        init: function () {
            this.backgroundColorFrom = null;
            this.backgroundColorFromHover = null;
            this.backgroundColorTo = null;
            this.backgroundColorToHover = null;
            this.gradientDirection = null;
            this.gradientDirectionHover = null;
            this.hasBackgroundGradient = false;
            this.hasBackgroundHover = false;
            this.hasBackgroundAnimation = false;

            this.relativeContainer = null;

            this.create(
                {
                    groupContainerSelector: ".background-container",
                    updateSampleEventName: "update-background-sample"
                }
            );

            this
                .setRelativeContainer()
                .setColorPicker()
                .setColorFrom()
                .setColorTo()
                .setHasGradient()
                .setGradientDirection()
                .setHasHover()
                .setHasAnimation()
                .setGradientDirectionHover();
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
         * Sets color picker
         */
        setColorPicker: function () {
            var region = "";

            $.colorpicker.regional[region].none = this.getLabel("clear");
            $.colorpicker.regional[region].ok = this.getLabel("save");
            $.colorpicker.regional[region].cancel = this.getLabel("cancel");

            return this;
        },

        /**
         * Sets background-color from
         */
        setColorFrom: function () {
            if (this.backgroundColorFrom === null) {
                return this;
            }

            ss.init(
                "commonComponentsFormColor",
                {
                    title: this.getLabel("backgroundColor"),
                    value: this.backgroundColorFrom,
                    css: "background-color-from",
                    appendTo: this.relativeContainer,
                    callback: $.proxy(
                        function (color) {
                            this.backgroundColorFrom = color;
                            this.update();
                        },
                        this
                    )
                }
            );

            if (this.backgroundColorFromHover === null) {
                return this;
            }

            ss.init(
                "commonComponentsFormColor",
                {
                    title: this.getLabel("backgroundColor"),
                    value: this.backgroundColorFromHover,
                    css: "background-color-from-hover",
                    iconBefore: "fa-mouse-pointer",
                    appendTo: this.relativeContainer,
                    callback: $.proxy(
                        function (color) {
                            this.backgroundColorFromHover = color;
                            this.update();
                        },
                        this
                    )
                }
            );

            return this;
        },

        /**
         * Sets background-color to
         */
        setColorTo: function () {
            if (this.backgroundColorTo === null) {
                return this;
            }

            ss.init(
                "commonComponentsFormColor",
                {
                    title: this.getLabel("backgroundColor"),
                    value: this.backgroundColorTo,
                    css: "background-color-to",
                    appendTo: this.relativeContainer,
                    callback: $.proxy(
                        function (color) {
                            this.backgroundColorTo = color;
                            this.update();
                        },
                        this
                    )
                }
            );

            if (this.backgroundColorToHover === null) {
                return this;
            }

            ss.init(
                "commonComponentsFormColor",
                {
                    title: this.getLabel("backgroundColor"),
                    value: this.backgroundColorToHover,
                    css: "background-color-to-hover",
                    iconBefore: "fa-mouse-pointer",
                    appendTo: this.relativeContainer,
                    callback: $.proxy(
                        function (color) {
                            this.backgroundColorToHover = color;
                            this.update();
                        },
                        this
                    )
                }
            );

            return this;
        },

        /**
         * Sets has gradient
         */
        setHasGradient: function () {
            if (this.hasBackgroundGradient === true) {
                this.getGroupContainer().addClass("has-gradient");
            }

            var onCheck = $.proxy(
                function () {
                    this.getGroupContainer().addClass("has-gradient");
                    this.hasBackgroundGradient = true;
                    this.update();
                },
                this
            );

            var onUnCheck = $.proxy(
                function () {
                    this.getGroupContainer().removeClass("has-gradient");
                    this.hasBackgroundGradient = false;
                    this.update();
                },
                this
            );

            ss.init(
                "commonComponentsFormCheckboxOnOff",
                {
                    value: this.hasBackgroundGradient,
                    label: this.getLabel("useGradient"),
                    appendTo: this.getGroupContainer(),
                    onCheck: onCheck,
                    onUnCheck: onUnCheck
                }
            );

            return this;
        },

        /**
         * Sets gradient direction
         */
        setGradientDirection: function () {
            if (this.gradientDirection === null) {
                return this;
            }

            ss.init(
                "commonComponentsFormRadioButtons",
                {
                    value: this.gradientDirection,
                    label: this.getLabel("gradientDirection"),
                    css: "gradient-direction",
                    data: this.gradientDirections,
                    appendTo: this.getGroupContainer(),
                    onChange: $.proxy(
                        function (value) {
                            this.gradientDirection = value;
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
            if (this.hasBackgroundHover === true) {
                this.getGroupContainer().addClass("has-hover");
            }

            var onCheck = $.proxy(
                function () {
                    this.getGroupContainer().addClass("has-hover");
                    this.hasBackgroundHover = true;
                    this.update();
                },
                this
            );

            var onUnCheck = $.proxy(
                function () {
                    this.getGroupContainer().removeClass("has-hover");
                    this.hasBackgroundHover = false;
                    this.update();
                },
                this
            );

            ss.init(
                "commonComponentsFormCheckboxOnOff",
                {
                    value: this.hasBackgroundHover,
                    label: this.getLabel("mouseHoverEffect"),
                    appendTo: this.getGroupContainer(),
                    onCheck: onCheck,
                    onUnCheck: onUnCheck
                }
            );

            return this;
        },

        /**
         * Sets has hover
         */
        setHasAnimation: function () {
            if (this.hasBackgroundAnimation === null) {
                return this;
            }

            var onCheck = $.proxy(
                function () {
                    this.hasBackgroundAnimation = true;
                    this.update();
                },
                this
            );

            var onUnCheck = $.proxy(
                function () {
                    this.hasBackgroundAnimation = false;
                    this.update();
                },
                this
            );

            ss.init(
                "commonComponentsFormCheckboxOnOff",
                {
                    value: this.hasBackgroundAnimation,
                    label: this.getLabel("mouseHoverAnimation"),
                    css: "has-animation",
                    appendTo: this.getGroupContainer(),
                    onCheck: onCheck,
                    onUnCheck: onUnCheck
                }
            );

            return this;
        },

        /**
         * Sets gradient direction hover
         */
        setGradientDirectionHover: function () {
            if (this.gradientDirectionHover === null) {
                return this;
            }

            ss.init(
                "commonComponentsFormRadioButtons",
                {
                    value: this.gradientDirectionHover,
                    label: this.getLabel("gradientDirectionHover"),
                    css: "gradient-direction-hover",
                    data: this.gradientDirections,
                    appendTo: this.getGroupContainer(),
                    onChange: $.proxy(
                        function (value) {
                            this.gradientDirectionHover = value;
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
         * @param {boolean} isHover
         *
         * @returns {String}
         */
        generateCss: function (isHover) {
            var backgroundColorFrom = "", backgroundColorTo = "";

            if (isHover === true) {
                if (this.hasBackgroundHover !== true) {
                    return "";
                }

                backgroundColorFrom = this.backgroundColorFromHover;
                backgroundColorTo = this.backgroundColorToHover;
            } else {
                backgroundColorFrom = this.backgroundColorFrom;
                backgroundColorTo = this.backgroundColorTo;
            }

            if (backgroundColorFrom === null) {
                backgroundColorFrom = "";
            }

            if (backgroundColorTo === null) {
                backgroundColorTo = "";
            }

            if (this.hasBackgroundGradient !== true) {
                backgroundColorTo = "";
            } else if (isHover === true) {
                if (backgroundColorFrom !== ""
                    && backgroundColorTo === ""
                ) {
                    backgroundColorTo = backgroundColorFrom;
                } else if (backgroundColorFrom === ""
                    && backgroundColorTo !== ""
                ) {
                    backgroundColorFrom = backgroundColorTo;
                }
            }

            return this.generateBackgroundCss(
                isHover,
                backgroundColorFrom,
                backgroundColorTo
            );
        },

        /**
         * Generates styles
         *
         * @param {boolean} isHover
         * @param {String}  colorFrom
         * @param {String}  colorTo
         *
         * @returns {String}
         */
        generateBackgroundCss: function (isHover, colorFrom, colorTo) {
            if (colorFrom !== ""
                && colorTo === ""
            ) {
                return "background-color: " + colorFrom + ";";
            }

            if (colorFrom === ""
                && colorTo !== ""
            ) {
                return "background-color: " + colorTo + ";";
            }

            if (colorFrom !== ""
                && colorTo !== ""
                && this.hasBackgroundGradient !== true
            ) {
                return "background-color: " + colorFrom + ";";
            }

            if (colorFrom === ""
                || colorTo === ""
            ) {
                return "";
            }

            return this.generateGradientCss(
                isHover,
                colorFrom,
                colorTo
            );
        },

        /**
         * Generates styles
         *
         * @param {boolean} isHover
         * @param {String}  colorFrom
         * @param {String}  colorTo
         *
         * @returns {String}
         */
        generateGradientCss: function (isHover, colorFrom, colorTo) {
            var css = "";
            var gradientDirection = this.getGradientDirection(isHover);

            css += "background: " + colorFrom + ";";
            css += "background: -moz-linear-gradient(";
            css += gradientDirection.mozLinear;
            css += ", " + colorFrom + " 0%, ";
            css += colorTo + " 100%);";

            css += "background: -webkit-gradient(";
            css += gradientDirection.webkit;
            css += ", color-stop(0%, " + colorFrom;
            css += "), color-stop(100%, " + colorTo + "));";

            css += "background: -webkit-linear-gradient(";
            css += gradientDirection.webkitLinear;
            css += ", " + colorFrom + " 0%, ";
            css += colorTo + " 100%);";

            css += "background: -o-linear-gradient(";
            css += gradientDirection.oLinear + ", ";
            css += colorFrom + " 0%, " + colorTo + " 100%);";

            css += "background: -ms-linear-gradient(";
            css += gradientDirection.msLinear + ", ";
            css += colorFrom + " 0%, " + colorTo + " 100%);";

            css += "background: linear-gradient(";
            css += gradientDirection.linear + ", ";
            css += colorFrom + " 0%, " + colorTo + " 100%);";

            css += "filter: progid:DXImageTransform.";
            css += "Microsoft.gradient( startColorstr='";
            css += colorFrom + "', endColorstr='";
            css += colorTo + "',GradientType=";
            css += gradientDirection.ie + ");";

            return css;
        },

        /**
         * Gets gradient direction
         *
         * @param {boolean} isHover
         *
         * @return {Object}
         */
        getGradientDirection: function (isHover) {
            var gradientDirection;

            if (isHover === true) {
                gradientDirection = this.gradientDirectionHover;
            } else {
                gradientDirection = this.gradientDirection;
            }

            if (this.gradientDirectionList[gradientDirection] !== undefined) {
                return this.gradientDirectionList[gradientDirection];
            }

            return this.gradientDirectionList[0];
        },

        /**
         * Has animation
         *
         * @return {boolean}
         */
        hasAnimation: function () {
            return this.hasBackgroundGradient === false
                && this.hasBackgroundHover === true
                && this.hasBackgroundAnimation === true;
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
