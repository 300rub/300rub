!function ($, TestS) {
    'use strict';

    /**
     * Block margin
     *
     * @param {Object} options
     *
     * @type {TestS.Panel.Design.Block.Editor}
     */
    TestS.Panel.Design.Block.Margin = function (options) {
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

        this._relativeContainer = null;

        TestS.Panel.Design.AbstractGroup.call(
            this,
            {
                designContainer: options.designContainer,
                groupContainerName: "margin-container",
                title: options.designContainer,
                updateExampleEvent: "update-margin-example",
                labels: options.labels,
                values: {
                    keys: [
                        "marginTop",
                        "marginRight",
                        "marginBottom",
                        "marginLeft",
                        "marginTopHover",
                        "marginRightHover",
                        "marginBottomHover",
                        "marginLeftHover",
                        "hasMarginHover",
                        "hasMarginAnimation"
                    ],
                    values: options.values
                }
            }
        );

        this.init();
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    TestS.Panel.Design.Block.Margin.prototype
        = Object.create(TestS.Panel.Design.AbstractGroup.prototype);

    /**
     * Constructor
     */
    TestS.Panel.Design.Block.Margin.prototype.constructor
        = TestS.Panel.Design.Block.Margin;

    /**
     * Init
     */
    TestS.Panel.Design.Block.Margin.prototype.init = function () {
        this._relativeContainer
            = this.getGroupContainer().find(".relative-container");

        this
            ._setMarginTop()
            ._setMarginRight()
            ._setMarginBottom()
            ._setMarginLeft()
            ._setMarginHover()
            ._setHasAnimation();
    };

    /**
     * Sets margin-top
     *
     * @returns {TestS.Panel.Design.Block.Margin}
     *
     * @private
     */
    TestS.Panel.Design.Block.Margin.prototype._setMarginTop = function () {
        if (this._marginTop === null) {
            return this;
        }

        var hover = null;

        if (this._marginTopHover !== null) {
            hover = new TestS.Form.Spinner(
                {
                    value: this._marginTopHover,
                    css: "margin-top-hover",
                    iconBefore: "fa-mouse-pointer",
                    appendTo: this._relativeContainer,
                    callback: $.proxy(
                        function (value) {
                            this._marginTopHover = value;
                            this.update();
                        },
                        this
                    )
                }
            );
        }

        new TestS.Form.Spinner(
            {
                value: this._marginTop,
                css: "margin-top",
                appendTo: this._relativeContainer,
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
                        this.update();
                    },
                    this
                )
            }
        );

        return this;
    };

    /**
     * Sets margin-right
     *
     * @returns {TestS.Panel.Design.Block.Margin}
     *
     * @private
     */
    TestS.Panel.Design.Block.Margin.prototype._setMarginRight = function () {
        if (this._marginRight === null) {
            return this;
        }

        var hover = null;

        if (this._marginRightHover !== null) {
            hover = new TestS.Form.Spinner(
                {
                    value: this._marginRightHover,
                    css: "margin-right-hover",
                    iconBefore: "fa-mouse-pointer",
                    appendTo: this._relativeContainer,
                    callback: $.proxy(
                        function (value) {
                            this._marginRightHover = value;
                            this.update();
                        },
                        this
                    )
                }
            );
        }

        new TestS.Form.Spinner(
            {
                value: this._marginRight,
                css: "margin-right",
                appendTo: this._relativeContainer,
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
     * @returns {TestS.Panel.Design.Block.Margin}
     *
     * @private
     */
    TestS.Panel.Design.Block.Margin.prototype._setMarginBottom = function () {
        if (this._marginBottom === null) {
            return this;
        }

        var hover = null;

        if (this._marginBottomHover !== null) {
            hover = new TestS.Form.Spinner(
                {
                    value: this._marginBottomHover,
                    css: "margin-bottom-hover",
                    iconBefore: "fa-mouse-pointer",
                    appendTo: this._relativeContainer,
                    callback: $.proxy(
                        function (value) {
                            this._marginBottomHover = value;
                            this.update();
                        },
                        this
                    )
                }
            );
        }

        new TestS.Form.Spinner(
            {
                value: this._marginBottom,
                css: "margin-bottom",
                appendTo: this._relativeContainer,
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
     * @returns {TestS.Panel.Design.Block.Margin}
     *
     * @private
     */
    TestS.Panel.Design.Block.Margin.prototype._setMarginLeft = function () {
        if (this._marginLeft === null) {
            return this;
        }

        var hover = null;

        if (this._marginLeftHover !== null) {
            hover = new TestS.Form.Spinner(
                {
                    value: this._marginLeftHover,
                    css: "margin-left-hover",
                    iconBefore: "fa-mouse-pointer",
                    appendTo: this._relativeContainer,
                    callback: $.proxy(
                        function (value) {
                            this._marginLeftHover = value;
                            this.update();
                        },
                        this
                    )
                }
            );
        }

        new TestS.Form.Spinner(
            {
                value: this._marginLeft,
                css: "margin-left",
                appendTo: this._relativeContainer,
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
     * @returns {TestS.Panel.Design.Block.Margin}
     *
     * @private
     */
    TestS.Panel.Design.Block.Margin.prototype._setMarginHover = function () {
        if (this._hasMarginHover === true) {
            this.getGroupContainer().addClass("has-hover");
        }

        if (this._hasMarginHover === null) {
            return this;
        }

        var onCheck = $.proxy(
            function () {
                this._hasMarginHover = true;
                this.getGroupContainer().addClass("has-hover");
                this.update();
            },
            this
        );

        var onUnCheck = $.proxy(
            function () {
                this._hasMarginHover = false;
                this.getGroupContainer().removeClass("has-hover");
                this.update();
            },
            this
        );

        new TestS.Form.CheckboxOnOff(
            {
                value: this._hasMarginHover,
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
     * @returns {TestS.Panel.Design.Block.Margin}
     *
     * @private
     */
    TestS.Panel.Design.Block.Margin.prototype._setHasAnimation = function () {
        if (this._hasMarginAnimation === null) {
            return this;
        }

        var onCheck = $.proxy(
            function () {
                this._hasMarginAnimation = true;
                this.update();
            },
            this
        );

        var onUnCheck = $.proxy(
            function () {
                this._hasMarginAnimation = false;
                this.update();
            },
            this
        );

        new TestS.Form.CheckboxOnOff(
            {
                value: this._hasMarginAnimation,
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
    TestS.Panel.Design.Block.Margin.prototype.generateCss = function (isHover) {
        if (isHover === true) {
            if (this._hasMarginHover !== true) {
                return "";
            }

            return this._getCss(
                TestS.Components.Library.getIntVal(
                    this._marginTopHover
                ),
                TestS.Components.Library.getIntVal(
                    this._marginRightHover
                ),
                TestS.Components.Library.getIntVal(
                    this._marginBottomHover
                ),
                TestS.Components.Library.getIntVal(
                    this._marginLeftHover
                )
            );
        }

        return this._getCss(
            TestS.Components.Library.getIntVal(
                this._marginTop
            ),
            TestS.Components.Library.getIntVal(
                this._marginRight
            ),
            TestS.Components.Library.getIntVal(
                this._marginBottom
            ),
            TestS.Components.Library.getIntVal(
                this._marginLeft
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
    TestS.Panel.Design.Block.Margin.prototype._getCss = function (
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
    TestS.Panel.Design.Block.Margin.prototype.hasAnimation = function () {
        return this._hasMarginHover === true
            && this._hasMarginAnimation === true;
    };
}(window.jQuery, window.TestS);
