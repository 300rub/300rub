!function ($, ss) {
    'use strict';

    /**
     * Block padding
     *
     * @param {Object} options
     *
     * @type {ss.panel.design.block.Editor}
     */
    ss.panel.design.block.Padding = function (options) {
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

        this._relativeContainer = null;

        ss.panel.design.AbstractGroup.call(
            this,
            {
                designContainer: options.designContainer,
                groupContainerName: "padding-container",
                title: options.labels.title,
                updateExampleEvent: "update-padding-example",
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
    ss.panel.design.block.Padding.prototype
        = Object.create(ss.panel.design.AbstractGroup.prototype);

    /**
     * Constructor
     */
    ss.panel.design.block.Padding.prototype.constructor
        = ss.panel.design.block.Padding;

    /**
     * Fields
     *
     * @type {Array}
     */
    ss.panel.design.block.Padding.prototype.fields = [
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

    /**
     * Init
     */
    ss.panel.design.block.Padding.prototype.init = function () {
        this._relativeContainer
            = this.getGroupContainer().find(".relative-container");

        this
            ._setPaddingTop()
            ._setPaddingRight()
            ._setPaddingBottom()
            ._setPaddingLeft()
            ._setPaddingHover()
            ._setHasAnimation();
    };

    /**
     * Sets padding-top
     *
     * @returns {ss.panel.design.block.Padding}
     *
     * @private
     */
    ss.panel.design.block.Padding.prototype._setPaddingTop = function () {
        if (this._paddingTop === null) {
            return this;
        }

        var hover = null;

        if (this._paddingTopHover !== null) {
            hover = new ss.forms.Spinner(
                {
                    value: this._paddingTopHover,
                    css: "padding-top-hover",
                    iconBefore: "fa-mouse-pointer",
                    appendTo: this._relativeContainer,
                    callback: $.proxy(
                        function (value) {
                            this._paddingTopHover = value;
                            this.update();
                        },
                        this
                    )
                }
            );
        }

        new ss.forms.Spinner(
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
                        this.update();
                    },
                    this
                )
            }
        );

        return this;
    };

    /**
     * Sets padding-right
     *
     * @returns {ss.panel.design.block.Padding}
     *
     * @private
     */
    ss.panel.design.block.Padding.prototype._setPaddingRight = function () {
        if (this._paddingRight === null) {
            return this;
        }

        var hover = null;

        if (this._paddingRightHover !== null) {
            hover = new ss.forms.Spinner(
                {
                    value: this._paddingRightHover,
                    css: "padding-right-hover",
                    iconBefore: "fa-mouse-pointer",
                    appendTo: this._relativeContainer,
                    callback: $.proxy(
                        function (value) {
                            this._paddingRightHover = value;
                            this.update();
                        },
                        this
                    )
                }
            );
        }

        new ss.forms.Spinner(
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
                        this.update();
                    },
                    this
                )
            }
        );

        return this;
    };

    /**
     * Sets padding-bottom
     *
     * @returns {ss.panel.design.block.Padding}
     *
     * @private
     */
    ss.panel.design.block.Padding.prototype._setPaddingBottom = function () {
        if (this._paddingBottom === null) {
            return this;
        }

        var hover = null;

        if (this._paddingBottomHover !== null) {
            hover = new ss.forms.Spinner(
                {
                    value: this._paddingBottomHover,
                    css: "padding-bottom-hover",
                    iconBefore: "fa-mouse-pointer",
                    appendTo: this._relativeContainer,
                    callback: $.proxy(
                        function (value) {
                            this._paddingBottomHover = value;
                            this.update();
                        },
                        this
                    )
                }
            );
        }

        new ss.forms.Spinner(
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
                        this.update();
                    },
                    this
                )
            }
        );

        return this;
    };

    /**
     * Sets padding-left
     *
     * @returns {ss.panel.design.block.Padding}
     *
     * @private
     */
    ss.panel.design.block.Padding.prototype._setPaddingLeft = function () {
        if (this._paddingLeft === null) {
            return this;
        }

        var hover = null;

        if (this._paddingLeftHover !== null) {
            hover = new ss.forms.Spinner(
                {
                    value: this._paddingLeftHover,
                    css: "padding-left-hover",
                    iconBefore: "fa-mouse-pointer",
                    appendTo: this._relativeContainer,
                    callback: $.proxy(
                        function (value) {
                            this._paddingLeftHover = value;
                            this.update();
                        },
                        this
                    )
                }
            );
        }

        new ss.forms.Spinner(
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
                        this.update();
                    },
                    this
                )
            }
        );

        return this;
    };

    /**
     * Sets padding hover
     *
     * @returns {ss.panel.design.block.Padding}
     *
     * @private
     */
    ss.panel.design.block.Padding.prototype._setPaddingHover = function () {
        if (this._hasPaddingHover === true) {
            this.getGroupContainer().addClass("has-hover");
        }

        if (this._hasPaddingHover === null) {
            return this;
        }

        var onCheck = $.proxy(
            function () {
                this._hasPaddingHover = true;
                this.getGroupContainer().addClass("has-hover");
                this.update();
            },
            this
        );

        var onUnCheck = $.proxy(
            function () {
                this._hasPaddingHover = false;
                this.getGroupContainer().removeClass("has-hover");
                this.update();
            },
            this
        );

        new ss.forms.CheckboxOnOff(
            {
                value: this._hasPaddingHover,
                label: this.getLabel("mouseHoverEffect"),
                onCheck: onCheck,
                onUnCheck: onUnCheck,
                appendTo: this.getGroupContainer()
            }
        );

        return this;
    };

    /**
     * Sets padding animation
     *
     * @returns {ss.panel.design.block.Padding}
     *
     * @private
     */
    ss.panel.design.block.Padding.prototype._setHasAnimation = function () {
        if (this._hasPaddingAnimation === null) {
            return this;
        }

        var onCheck = $.proxy(
            function () {
                this._hasPaddingAnimation = true;
                this.update();
            },
            this
        );

        var onUnCheck = $.proxy(
            function () {
                this._hasPaddingAnimation = false;
                this.update();
            },
            this
        );

        new ss.forms.CheckboxOnOff(
            {
                value: this._hasPaddingAnimation,
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
     * Generates padding styles
     *
     * @param {boolean} isHover
     *
     * @returns {String}
     */
    ss.panel.design.block.Padding.prototype.generateCss = function (isHover) {
        if (isHover === true) {
            if (this._hasPaddingHover !== true) {
                return "";
            }

            return this._getCss(
                ss.components.Library.getIntVal(
                    this._paddingTopHover
                ),
                ss.components.Library.getIntVal(
                    this._paddingRightHover
                ),
                ss.components.Library.getIntVal(
                    this._paddingBottomHover
                ),
                ss.components.Library.getIntVal(
                    this._paddingLeftHover
                )
            );
        }

        return this._getCss(
            ss.components.Library.getIntVal(
                this._paddingTop
            ),
            ss.components.Library.getIntVal(
                this._paddingRight
            ),
            ss.components.Library.getIntVal(
                this._paddingBottom
            ),
            ss.components.Library.getIntVal(
                this._paddingLeft
            )
        );
    };

    /**
     * Gets padding CSS
     *
     * @param {Number|String} paddingTop
     * @param {Number|String} paddingRight
     * @param {Number|String} paddingBottom
     * @param {Number|String} paddingLeft
     *
     * @returns {String}
     *
     * @private
     */
    ss.panel.design.block.Padding.prototype._getCss = function (
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

        return css;
    };

    /**
     * Has animation
     *
     * @return {boolean}
     */
    ss.panel.design.block.Padding.prototype.hasAnimation = function () {
        return this._hasPaddingHover === true
            && this._hasPaddingAnimation === true;
    };
}(window.jQuery, window.ss);
