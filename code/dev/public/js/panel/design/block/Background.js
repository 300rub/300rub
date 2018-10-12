!function ($, ss) {
    'use strict';

    /**
     * Block background
     *
     * @param {Object} options
     *
     * @type {ss.panel.design.block.Editor}
     */
    ss.panel.design.block.Background = function (options) {
        this._backgroundColorFrom = null;
        this._backgroundColorFromHover = null;
        this._backgroundColorTo = null;
        this._backgroundColorToHover = null;
        this._gradientDirection = null;
        this._gradientDirectionHover = null;
        this._hasBackgroundGradient = null;
        this._hasBackgroundHover = null;
        this._hasBackgroundAnimation = null;

        this._relativeContainer = null;

        ss.panel.design.AbstractGroup.call(
            this,
            {
                editorContainer: options.editorContainer,
                groupContainerSelector: ".background-container",
                title: options.labels.title,
                updateSampleEvent: "update-background-sample",
                labels: options.labels,
                namespace: options.namespace,
                values: options.values
            }
        );

        this.init();
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    ss.panel.design.block.Background.prototype
        = Object.create(ss.panel.design.AbstractGroup.prototype);

    /**
     * Constructor
     */
    ss.panel.design.block.Background.prototype.constructor
        = ss.panel.design.block.Background;

    /**
     * Fields
     *
     * @type {Array}
     */
    ss.panel.design.block.Background.prototype.fields = [
        "backgroundColorFrom",
        "backgroundColorFromHover",
        "backgroundColorTo",
        "backgroundColorToHover",
        "gradientDirection",
        "gradientDirectionHover",
        "hasBackgroundGradient",
        "hasBackgroundHover",
        "hasBackgroundAnimation"
    ];

    /**
     * Fields
     *
     * @type {Array}
     */
    ss.panel.design.block.Background.prototype._gradientDirections = [
        {value: 0, icon: "fa-long-arrow-right"},
        {value: 1, icon: "fa-long-arrow-down"},
        {value: 2, icon: "fa-long-arrow-right", css: "deg-45"},
        {value: 3, icon: "fa-long-arrow-up", css: "deg-45"}
    ];

    /**
     * List of gradient directions options
     *
     * @var {Object}
     */
    ss.panel.design.block.Background.prototype._gradientDirectionList = {
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
    };

    /**
     * Init
     */
    ss.panel.design.block.Background.prototype.init = function () {
        this._relativeContainer
            = this.getGroupContainer().find(".relative-container");

        this
            ._setColorPicker()
            ._setColorFrom()
            ._setColorTo()
            ._setHasGradient()
            ._setGradientDirection()
            ._setHasHover()
            ._setHasAnimation()
            ._setGradientDirectionHover();
    };

    /**
     * Sets color picker
     *
     * @returns {ss.panel.design.block.Background}
     *
     * @private
     */
    ss.panel.design.block.Background.prototype._setColorPicker = function () {
        var region = "";

        $.colorpicker.regional[region].none = this.getLabel("clear");
        $.colorpicker.regional[region].ok = this.getLabel("save");
        $.colorpicker.regional[region].cancel = this.getLabel("cancel");

        return this;
    };

    /**
     * Sets background-color from
     *
     * @returns {ss.panel.design.block.Background}
     *
     * @private
     */
    ss.panel.design.block.Background.prototype._setColorFrom = function () {
        if (this._backgroundColorFrom === null) {
            return this;
        }

        new ss.forms.Color(
            {
                title: this.getLabel("backgroundColor"),
                value: this._backgroundColorFrom,
                css: "background-color-from",
                appendTo: this._relativeContainer,
                callback: $.proxy(
                    function (color) {
                        this._backgroundColorFrom = color;
                        this.update();
                    },
                    this
                )
            }
        );

        if (this._backgroundColorFromHover === null) {
            return this;
        }

        new ss.forms.Color(
            {
                title: this.getLabel("backgroundColor"),
                value: this._backgroundColorFromHover,
                css: "background-color-from-hover",
                iconBefore: "fa-mouse-pointer",
                appendTo: this._relativeContainer,
                callback: $.proxy(
                    function (color) {
                        this._backgroundColorFromHover = color;
                        this.update();
                    },
                    this
                )
            }
        );

        return this;
    };

    /**
     * Sets background-color to
     *
     * @returns {ss.panel.design.block.Background}
     *
     * @private
     */
    ss.panel.design.block.Background.prototype._setColorTo = function () {
        if (this._backgroundColorTo === null) {
            return this;
        }

        new ss.forms.Color(
            {
                title: this.getLabel("backgroundColor"),
                value: this._backgroundColorTo,
                css: "background-color-to",
                appendTo: this._relativeContainer,
                callback: $.proxy(
                    function (color) {
                        this._backgroundColorTo = color;
                        this.update();
                    },
                    this
                )
            }
        );

        if (this._backgroundColorToHover === null) {
            return this;
        }

        new ss.forms.Color(
            {
                title: this.getLabel("backgroundColor"),
                value: this._backgroundColorToHover,
                css: "background-color-to-hover",
                iconBefore: "fa-mouse-pointer",
                appendTo: this._relativeContainer,
                callback: $.proxy(
                    function (color) {
                        this._backgroundColorToHover = color;
                        this.update();
                    },
                    this
                )
            }
        );

        return this;
    };

    /**
     * Sets has gradient
     *
     * @returns {ss.panel.design.block.Background}
     *
     * @private
     */
    ss.panel.design.block.Background.prototype._setHasGradient = function () {
        if (this._hasBackgroundGradient === true) {
            this.getGroupContainer().addClass("has-gradient");
        }

        var onCheck = $.proxy(
            function () {
                this.getGroupContainer().addClass("has-gradient");
                this._hasBackgroundGradient = true;
                this.update();
            },
            this
        );

        var onUnCheck = $.proxy(
            function () {
                this.getGroupContainer().removeClass("has-gradient");
                this._hasBackgroundGradient = false;
                this.update();
            },
            this
        );

        new ss.forms.CheckboxOnOff(
            {
                value: this._hasBackgroundGradient,
                label: this.getLabel("useGradient"),
                appendTo: this.getGroupContainer(),
                onCheck: onCheck,
                onUnCheck: onUnCheck
            }
        );

        return this;
    };

    /**
     * Sets gradient direction
     *
     * @returns {ss.panel.design.block.Background}
     *
     * @private
     */
    ss.panel.design.block.Background.prototype._setGradientDirection
        = function () {
            if (this._gradientDirection === null) {
                return this;
            }

            new ss.forms.RadioButtons(
                {
                    value: this._gradientDirection,
                    label: this.getLabel("gradientDirection"),
                    css: "gradient-direction",
                    data: this._gradientDirections,
                    appendTo: this.getGroupContainer(),
                    onChange: $.proxy(
                        function (value) {
                            this._gradientDirection = value;
                            this.update();
                        },
                        this
                    )
                }
            );

            return this;
        };

    /**
     * Sets has hover
     *
     * @returns {ss.panel.design.block.Background}
     *
     * @private
     */
    ss.panel.design.block.Background.prototype._setHasHover = function () {
        if (this._hasBackgroundHover === true) {
            this.getGroupContainer().addClass("has-hover");
        }

        var onCheck = $.proxy(
            function () {
                this.getGroupContainer().addClass("has-hover");
                this._hasBackgroundHover = true;
                this.update();
            },
            this
        );

        var onUnCheck = $.proxy(
            function () {
                this.getGroupContainer().removeClass("has-hover");
                this._hasBackgroundHover = false;
                this.update();
            },
            this
        );

        new ss.forms.CheckboxOnOff(
            {
                value: this._hasBackgroundHover,
                label: this.getLabel("mouseHoverEffect"),
                appendTo: this.getGroupContainer(),
                onCheck: onCheck,
                onUnCheck: onUnCheck
            }
        );

        return this;
    };

    /**
     * Sets has hover
     *
     * @returns {ss.panel.design.block.Background}
     *
     * @private
     */
    ss.panel.design.block.Background.prototype._setHasAnimation = function () {
        if (this._hasBackgroundAnimation === null) {
            return this;
        }

        var onCheck = $.proxy(
            function () {
                this._hasBackgroundAnimation = true;
                this.update();
            },
            this
        );

        var onUnCheck = $.proxy(
            function () {
                this._hasBackgroundAnimation = false;
                this.update();
            },
            this
        );

        new ss.forms.CheckboxOnOff(
            {
                value: this._hasBackgroundAnimation,
                label: this.getLabel("mouseHoverAnimation"),
                css: "has-animation",
                appendTo: this.getGroupContainer(),
                onCheck: onCheck,
                onUnCheck: onUnCheck
            }
        );

        return this;
    };

    /**
     * Sets gradient direction hover
     *
     * @returns {ss.panel.design.block.Background}
     *
     * @private
     */
    ss.panel.design.block.Background.prototype._setGradientDirectionHover
        = function () {
            if (this._gradientDirectionHover === null) {
                return this;
            }

            new ss.forms.RadioButtons(
                {
                    value: this._gradientDirectionHover,
                    label: this.getLabel("gradientDirectionHover"),
                    css: "gradient-direction-hover",
                    data: this._gradientDirections,
                    appendTo: this.getGroupContainer(),
                    onChange: $.proxy(
                        function (value) {
                            this._gradientDirectionHover = value;
                            this.update();
                        },
                        this
                    )
                }
            );

            return this;
        };

    /**
     * Generates styles
     *
     * @param {boolean} isHover
     *
     * @returns {String}
     */
    ss.panel.design.block.Background.prototype.generateCss = function (
        isHover
    ) {
        var backgroundColorFrom = "", backgroundColorTo = "";

        if (isHover === true) {
            if (this._hasBackgroundHover !== true) {
                return "";
            }

            backgroundColorFrom = this._backgroundColorFromHover;
            backgroundColorTo = this._backgroundColorToHover;
        } else {
            backgroundColorFrom = this._backgroundColorFrom;
            backgroundColorTo = this._backgroundColorTo;
        }

        if (backgroundColorFrom === null) {
            backgroundColorFrom = "";
        }

        if (backgroundColorTo === null) {
            backgroundColorTo = "";
        }

        if (this._hasBackgroundGradient !== true) {
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

        return this._generateBackgroundCss(
            isHover,
            backgroundColorFrom,
            backgroundColorTo
        );
    };

    /**
     * Generates styles
     *
     * @param {boolean} isHover
     * @param {String}  backgroundColorFrom
     * @param {String}  backgroundColorTo
     *
     * @returns {String}
     *
     * @private
     */
    ss.panel.design.block.Background.prototype._generateBackgroundCss
        = function (isHover, backgroundColorFrom, backgroundColorTo) {
            if (backgroundColorFrom !== ""
                && backgroundColorTo === ""
            ) {
                return "background-color: " + backgroundColorFrom + ";";
            }

            if (backgroundColorFrom === ""
                && backgroundColorTo !== ""
            ) {
                return "background-color: " + backgroundColorTo + ";";
            }

            if (backgroundColorFrom !== ""
                && backgroundColorTo !== ""
                && this._hasBackgroundGradient !== true
            ) {
                return "background-color: " + backgroundColorFrom + ";";
            }

            if (backgroundColorFrom === ""
                || backgroundColorTo === ""
            ) {
                return "";
            }

            return this._generateGradientCss(
                isHover,
                backgroundColorFrom,
                backgroundColorTo
            );
        };

    /**
     * Generates styles
     *
     * @param {boolean} isHover
     * @param {String}  backgroundColorFrom
     * @param {String}  backgroundColorTo
     *
     * @returns {String}
     */
    ss.panel.design.block.Background.prototype._generateGradientCss = function (
        isHover,
        backgroundColorFrom,
        backgroundColorTo
    ) {
        var css = "";
        var gradientDirection = this._getGradientDirection(isHover);

        css += "background: " + backgroundColorFrom + ";";
        css += "background: -moz-linear-gradient(";
        css += gradientDirection.mozLinear;
        css += ", " + backgroundColorFrom + " 0%, ";
        css += backgroundColorTo + " 100%);";

        css += "background: -webkit-gradient(";
        css += gradientDirection.webkit;
        css += ", color-stop(0%, " + backgroundColorFrom;
        css += "), color-stop(100%, " + backgroundColorTo + "));";

        css += "background: -webkit-linear-gradient(";
        css += gradientDirection.webkitLinear;
        css += ", " + backgroundColorFrom + " 0%, ";
        css += backgroundColorTo + " 100%);";

        css += "background: -o-linear-gradient(";
        css += gradientDirection.oLinear + ", ";
        css += backgroundColorFrom + " 0%, " + backgroundColorTo + " 100%);";

        css += "background: -ms-linear-gradient(";
        css += gradientDirection.msLinear + ", ";
        css += backgroundColorFrom + " 0%, " + backgroundColorTo + " 100%);";

        css += "background: linear-gradient(";
        css += gradientDirection.linear + ", ";
        css += backgroundColorFrom + " 0%, " + backgroundColorTo + " 100%);";

        css += "filter: progid:DXImageTransform.";
        css += "Microsoft.gradient( startColorstr='";
        css += backgroundColorFrom + "', endColorstr='";
        css += backgroundColorTo + "',GradientType=";
        css += gradientDirection.ie + ");";

        return css;
    };

    /**
     * Gets gradient direction
     *
     * @param {boolean} isHover
     *
     * @return {Object}
     */
    ss.panel.design.block.Background.prototype._getGradientDirection
        = function (isHover) {
            var gradientDirection;

            if (isHover === true) {
                gradientDirection = this._gradientDirectionHover;
            } else {
                gradientDirection = this._gradientDirection;
            }

            if (this._gradientDirectionList[gradientDirection] !== undefined) {
                return this._gradientDirectionList[gradientDirection];
            }

            return this._gradientDirectionList[0];
        };

    /**
     * Has animation
     *
     * @return {boolean}
     */
    ss.panel.design.block.Background.prototype.hasAnimation = function () {
        return this._hasBackgroundGradient === false
            && this._hasBackgroundHover === true
            && this._hasBackgroundAnimation === true;
    };
}(window.jQuery, window.ss);
