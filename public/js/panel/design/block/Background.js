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
                designContainer: options.designContainer,
                groupContainerName: "background-container",
                title: options.labels.title,
                updateExampleEvent: "update-background-example",
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
     * Init
     */
    ss.panel.design.block.Background.prototype.init = function () {
        this._relativeContainer
            = this.getGroupContainer().find(".relative-container");

        this
            ._setColorPicker()
            ._setColorFrom()
            ._setColorTo()
            ._setHasGradient();
    };

    /**
     * Sets color picker
     *
     * @returns {ss.panel.design.block.Background}
     *
     * @private
     */
    ss.panel.design.block.Background.prototype._setColorPicker = function () {
        $.colorpicker.regional[""]["none"] = this.getLabel("clear");
        $.colorpicker.regional[""]["ok"] = this.getLabel("save");
        $.colorpicker.regional[""]["cancel"] = this.getLabel("cancel");

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

        new ss.forms.Color({
            title: this.getLabel("backgroundColor"),
            value: this._backgroundColorFrom,
            css: "background-color-from",
            appendTo: this._relativeContainer,
            callback: $.proxy(function (color) {
                this._backgroundColorFrom = color;
                this.update();
            }, this)
        });

        if (this._backgroundColorFromHover === null) {
            return this;
        }

        new ss.forms.Color({
            title: this.getLabel("backgroundColor"),
            value: this._backgroundColorFromHover,
            css: "background-color-from-hover",
            iconBefore: "fa-mouse-pointer",
            appendTo: this._relativeContainer,
            callback: $.proxy(function (color) {
                this._backgroundColorFromHover = color;
                this.update();
            }, this)
        });

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

        new ss.forms.Color({
            title: this.getLabel("backgroundColor"),
            value: this._backgroundColorTo,
            css: "background-color-to",
            appendTo: this._relativeContainer,
            callback: $.proxy(function (color) {
                this._backgroundColorTo = color;
                this.update();
            }, this)
        });

        if (this._backgroundColorToHover === null) {
            return this;
        }

        new ss.forms.Color({
            title: this.getLabel("backgroundColor"),
            value: this._backgroundColorToHover,
            css: "background-color-to-hover",
            iconBefore: "fa-mouse-pointer",
            appendTo: this._relativeContainer,
            callback: $.proxy(function (color) {
                this._values["backgroundColorToHover"] = color;
                this._updateBackground(false);
            }, this)
        });

        return this;
    };

    /**
     * Sets background gradient
     *
     * @returns {ss.panel.design.block.Background}
     *
     * @private
     */
    ss.panel.design.block.Background.prototype._setHasGradient = function () {
        if (this._hasBackgroundGradient === true) {
            this.getGroupContainer().addClass("has-gradient");
        }

        var onCheck = function () {
            $container.addClass("has-gradient");
            this._values["hasBackgroundGradient"] = true;
            this._updateBackground(false);
        };

        var onUnCheck = function () {
            $container.removeClass("has-gradient");
            this._values["hasBackgroundGradient"] = false;
            this._updateBackground(false);
        };

        new ss.forms.CheckboxOnOff({
            value: this._hasBackgroundGradient,
            label: this.getLabel("useGradient"),
            appendTo: this.getGroupContainer(),
            onCheck: $.proxy(onCheck, this),
            onUnCheck: $.proxy(onUnCheck, this)
        });

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
            if (this._hasMarginHover !== true) {
                return "";
            }

            return this._getCss(
                ss.components.Library.getIntVal(
                    this._marginTopHover
                ),
                ss.components.Library.getIntVal(
                    this._marginRightHover
                ),
                ss.components.Library.getIntVal(
                    this._marginBottomHover
                ),
                ss.components.Library.getIntVal(
                    this._marginLeftHover
                )
            );
        }

        return this._getCss(
            ss.components.Library.getIntVal(
                this._marginTop
            ),
            ss.components.Library.getIntVal(
                this._marginRight
            ),
            ss.components.Library.getIntVal(
                this._marginBottom
            ),
            ss.components.Library.getIntVal(
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
        return this._hasMarginHover === true
            && this._hasMarginAnimation === true;
    };
}(window.jQuery, window.ss);
