!function ($, ss) {
    'use strict';

    /**
     * Init
     */
    ss.panel.design.block.Margin.prototype.init = function () {
        this
            .setMarginTop()
            ._setMarginRight()
            ._setMarginBottom()
            ._setMarginLeft()
            ._setMarginHover()
            ._setHasAnimation();
    };



    /**
     * Sets margin-right
     *
     * @returns {ss.panel.design.block.Margin}
     *
     * @private
     */
    ss.panel.design.block.Margin.prototype._setMarginRight = function () {
        if (this.marginRight === null) {
            return this;
        }

        var hover = null;

        if (this.marginRightHover !== null) {
            hover = new ss.forms.Spinner(
                {
                    value: this.marginRightHover,
                    css: "margin-right-hover",
                    iconBefore: "fa-mouse-pointer",
                    appendTo: this.relativeContainer,
                    callback: $.proxy(
                        function (value) {
                            this.marginRightHover = value;
                            this.update();
                        },
                        this
                    )
                }
            );
        }

        new ss.forms.Spinner(
            {
                value: this.marginRight,
                css: "margin-right",
                appendTo: this.relativeContainer,
                callback: $.proxy(
                    function (value) {
                        var marginRight
                            = this.marginRight;
                        var marginRightHover
                            = this.marginRightHover;
                        if (marginRight === marginRightHover
                            && hover !== null
                        ) {
                            this.marginRightHover = value;
                            hover.setValue(value);
                        }

                        this.marginRight = value;
                        this.update();
                    },
                    this
                )
            }
        );

        return this;
    };

    /**
     * Sets margin-bottom
     *
     * @returns {ss.panel.design.block.Margin}
     *
     * @private
     */
    ss.panel.design.block.Margin.prototype._setMarginBottom = function () {
        if (this.marginBottom === null) {
            return this;
        }

        var hover = null;

        if (this.marginBottomHover !== null) {
            hover = new ss.forms.Spinner(
                {
                    value: this.marginBottomHover,
                    css: "margin-bottom-hover",
                    iconBefore: "fa-mouse-pointer",
                    appendTo: this.relativeContainer,
                    callback: $.proxy(
                        function (value) {
                            this.marginBottomHover = value;
                            this.update();
                        },
                        this
                    )
                }
            );
        }

        new ss.forms.Spinner(
            {
                value: this.marginBottom,
                css: "margin-bottom",
                appendTo: this.relativeContainer,
                callback: $.proxy(
                    function (value) {
                        var marginBottom
                            = this.marginBottom;
                        var marginBottomHover
                            = this.marginBottomHover;
                        if (marginBottom === marginBottomHover
                            && hover !== null
                        ) {
                            this.marginBottomHover = value;
                            hover.setValue(value);
                        }

                        this.marginBottom = value;
                        this.update();
                    },
                    this
                )
            }
        );

        return this;
    };

    /**
     * Sets margin-left
     *
     * @returns {ss.panel.design.block.Margin}
     *
     * @private
     */
    ss.panel.design.block.Margin.prototype._setMarginLeft = function () {
        if (this.marginLeft === null) {
            return this;
        }

        var hover = null;

        if (this.marginLeftHover !== null) {
            hover = new ss.forms.Spinner(
                {
                    value: this.marginLeftHover,
                    css: "margin-left-hover",
                    iconBefore: "fa-mouse-pointer",
                    appendTo: this.relativeContainer,
                    callback: $.proxy(
                        function (value) {
                            this.marginLeftHover = value;
                            this.update();
                        },
                        this
                    )
                }
            );
        }

        new ss.forms.Spinner(
            {
                value: this.marginLeft,
                css: "margin-left",
                appendTo: this.relativeContainer,
                callback: $.proxy(
                    function (value) {
                        var marginLeft
                            = this.marginLeft;
                        var marginLeftHover
                            = this.marginLeftHover;
                        if (marginLeft === marginLeftHover
                            && hover !== null
                        ) {
                            this.marginLeftHover = value;
                            hover.setValue(value);
                        }

                        this.marginLeft = value;
                        this.update();
                    },
                    this
                )
            }
        );

        return this;
    };

    /**
     * Sets margin hover
     *
     * @returns {ss.panel.design.block.Margin}
     *
     * @private
     */
    ss.panel.design.block.Margin.prototype._setMarginHover = function () {
        if (this.hasMarginHover === true) {
            this.getGroupContainer().addClass("has-hover");
        }

        if (this.hasMarginHover === null) {
            return this;
        }

        var onCheck = $.proxy(
            function () {
                this.hasMarginHover = true;
                this.getGroupContainer().addClass("has-hover");
                this.update();
            },
            this
        );

        var onUnCheck = $.proxy(
            function () {
                this.hasMarginHover = false;
                this.getGroupContainer().removeClass("has-hover");
                this.update();
            },
            this
        );

        new ss.forms.CheckboxOnOff(
            {
                value: this.hasMarginHover,
                label: this.getLabel("mouseHoverEffect"),
                onCheck: onCheck,
                onUnCheck: onUnCheck,
                appendTo: this.getGroupContainer()
            }
        );

        return this;
    };

    /**
     * Sets margin animation
     *
     * @returns {ss.panel.design.block.Margin}
     *
     * @private
     */
    ss.panel.design.block.Margin.prototype._setHasAnimation = function () {
        if (this.hasMarginAnimation === null) {
            return this;
        }

        var onCheck = $.proxy(
            function () {
                this.hasMarginAnimation = true;
                this.update();
            },
            this
        );

        var onUnCheck = $.proxy(
            function () {
                this.hasMarginAnimation = false;
                this.update();
            },
            this
        );

        new ss.forms.CheckboxOnOff(
            {
                value: this.hasMarginAnimation,
                label: this.getLabel("mouseHoverAnimation"),
                css: "has-animation",
                onCheck: onCheck,
                onUnCheck: onUnCheck,
                appendTo: this.getGroupContainer()
            }
        );

        return this;
    };

    /**
     * Generates margin styles
     *
     * @param {boolean} isHover
     *
     * @returns {String}
     */
    ss.panel.design.block.Margin.prototype.generateCss = function (isHover) {
        if (isHover === true) {
            if (this.hasMarginHover !== true) {
                return "";
            }

            return this._getCss(
                ss.components.Library.getIntVal(
                    this.marginTopHover
                ),
                ss.components.Library.getIntVal(
                    this.marginRightHover
                ),
                ss.components.Library.getIntVal(
                    this.marginBottomHover
                ),
                ss.components.Library.getIntVal(
                    this.marginLeftHover
                )
            );
        }

        return this._getCss(
            ss.components.Library.getIntVal(
                this.marginTop
            ),
            ss.components.Library.getIntVal(
                this.marginRight
            ),
            ss.components.Library.getIntVal(
                this.marginBottom
            ),
            ss.components.Library.getIntVal(
                this.marginLeft
            )
        );
    };

    /**
     * Gets margin CSS
     *
     * @param {Number|String} marginTop
     * @param {Number|String} marginRight
     * @param {Number|String} marginBottom
     * @param {Number|String} marginLeft
     *
     * @returns {String}
     *
     * @private
     */
    ss.panel.design.block.Margin.prototype._getCss = function (
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

        return css;
    };

    /**
     * Has animation
     *
     * @return {boolean}
     */
    ss.panel.design.block.Margin.prototype.hasAnimation = function () {
        return this.hasMarginHover === true
            && this.hasMarginAnimation === true;
    };
}(window.jQuery, window.ss);
