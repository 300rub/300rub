!function ($, ss) {
    'use strict';

    /**
     * Block border
     *
     * @param {Object} options
     *
     * @type {ss.panel.design.block.Editor}
     */
    ss.panel.design.block.Border = function (options) {
        this._borderTopLeftRadius = null;
        this._borderTopLeftRadiusHover = null;
        this._borderTopRightRadius = null;
        this._borderTopRightRadiusHover = null;
        this._borderBottomRightRadius = null;
        this._borderBottomRightRadiusHover = null;
        this._borderBottomLeftRadius = null;
        this._borderBottomLeftRadiusHover = null;
        this._borderTopWidth = null;
        this._borderTopWidthHover = null;
        this._borderRightWidth = null;
        this._borderRightWidthHover = null;
        this._borderBottomWidth = null;
        this._borderBottomWidthHover = null;
        this._borderLeftWidth = null;
        this._borderLeftWidthHover = null;
        this._borderStyle = null;
        this._borderStyleHover = null;
        this._borderColor = null;
        this._borderColorHover = null;
        this._hasBorderHover = null;
        this._hasBorderAnimation = null;

        this._relativeContainer = null;

        ss.panel.design.AbstractGroup.call(
            this,
            {
                designContainer: options.designContainer,
                groupContainerName: "border-container",
                title: options.labels.title,
                updateExampleEvent: "update-border-example",
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
    ss.panel.design.block.Border.prototype
        = Object.create(ss.panel.design.AbstractGroup.prototype);

    /**
     * Constructor
     */
    ss.panel.design.block.Border.prototype.constructor
        = ss.panel.design.block.Border;

    /**
     * Fields
     *
     * @type {Array}
     */
    ss.panel.design.block.Border.prototype.fields = [
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
    ];

    /**
     * Style list
     *
     * @type {Array}
     */
    ss.panel.design.block.Border.prototype._styleList = [
        {
            value: 0,
            label: "",
            css: "solid"
        },
        {
            value: 1,
            label: "",
            css: "dotted"
        },
        {
            value: 2,
            label: "",
            css: "dashed"
        }
    ];

    /**
     * List of border styles
     *
     * @type {Object}
     */
    ss.panel.design.block.Border.prototype._borderStyleList = {
        0: "solid",
        1: "dotted",
        2: "dashed"
    };

    /**
     * Init
     */
    ss.panel.design.block.Border.prototype.init = function () {
        this._relativeContainer
            = this.getGroupContainer().find(".relative-container");

        this
            ._setTopLeftRadius()
            ._setTopRightRadius()
            ._setBottomRightRadius()
            ._setBottomLeftRadius()
            ._setTopWidth()
            ._setRightWidth()
            ._setBottomWidth()
            ._setLeftWidth()
            ._setStyle()
            ._setColor()
            ._setHasHover()
            ._setStyleHover()
            ._setColorHover();
    };

    /**
     * Sets top left radius
     *
     * @returns {ss.panel.design.block.Border}
     *
     * @private
     */
    ss.panel.design.block.Border.prototype._setTopLeftRadius = function () {
        if (this._borderTopLeftRadius === null) {
            return this;
        }

        var borderTopLeftRadiusHover = null;

        if (this._borderTopLeftRadiusHover !== null) {
            borderTopLeftRadiusHover = new ss.forms.Spinner({
                value: this._borderTopLeftRadiusHover,
                css: "border-top-left-radius-hover",
                min: 0,
                iconBefore: "fa-mouse-pointer",
                appendTo: this._relativeContainer,
                callback: $.proxy(function (value) {
                    this._borderTopLeftRadiusHover = value;
                    this.update();
                }, this)
            });
        }

        new ss.forms.Spinner({
            value: this._borderTopLeftRadius,
            css: "border-top-left-radius",
            min: 0,
            appendTo: this._relativeContainer,
            callback: $.proxy(function (value) {
                if (this._borderTopLeftRadius === this._borderTopLeftRadiusHover
                    && borderTopLeftRadiusHover !== null
                ) {
                    this._borderTopLeftRadiusHover = value;
                    borderTopLeftRadiusHover.setValue(value);
                }

                this._borderTopLeftRadius = value;
                this.update();
            }, this)
        });

        return this;
    };

    /**
     * Sets top right radius
     *
     * @returns {ss.panel.design.block.Border}
     *
     * @private
     */
    ss.panel.design.block.Border.prototype._setTopRightRadius = function () {
        if (this._borderTopRightRadius === null) {
            return this;
        }

        var borderTopRightRadiusHover = null;

        if (this._borderTopRightRadiusHover !== null) {
            borderTopRightRadiusHover = new ss.forms.Spinner({
                value: this._borderTopRightRadiusHover,
                css: "border-top-right-radius-hover",
                iconBefore: "fa-mouse-pointer",
                min: 0,
                appendTo: this._relativeContainer,
                callback: $.proxy(function (value) {
                    this._borderTopRightRadiusHover = value;
                    this.update();
                }, this)
            });
        }

        new ss.forms.Spinner({
            value: this._borderTopRightRadius,
            css: "border-top-right-radius",
            min: 0,
            appendTo: this._relativeContainer,
            callback: $.proxy(function (value) {
                if (this._borderTopRightRadius === this._borderTopRightRadiusHover
                    && borderTopRightRadiusHover !== null
                ) {
                    this._borderTopRightRadiusHover = value;
                    borderTopRightRadiusHover.setValue(value);
                }
                this._borderTopRightRadius = value;
                this.update();
            }, this)
        });

        return this;
    };

    /**
     * Sets bottom right radius
     *
     * @returns {ss.panel.design.block.Border}
     *
     * @private
     */
    ss.panel.design.block.Border.prototype._setBottomRightRadius = function () {
        if (this._borderBottomRightRadius === null) {
            return this;
        }

        var borderBottomRightRadiusHover = null;

        if (this._borderBottomRightRadiusHover !== null) {
            borderBottomRightRadiusHover = new ss.forms.Spinner({
                value: this._borderBottomRightRadiusHover,
                css: "border-bottom-right-radius-hover",
                min: 0,
                iconBefore: "fa-mouse-pointer",
                appendTo: this._relativeContainer,
                callback: $.proxy(function (value) {
                    this._borderBottomRightRadiusHover = value;
                    this.update();
                }, this)
            });
        }

        new ss.forms.Spinner({
            value: this._borderBottomRightRadius,
            css: "border-bottom-right-radius",
            min: 0,
            appendTo: this._relativeContainer,
            callback: $.proxy(function (value) {
                if (this._borderBottomRightRadius === this._borderBottomRightRadiusHover
                    && borderBottomRightRadiusHover !== null
                ) {
                    this._borderBottomRightRadiusHover = value;
                    borderBottomRightRadiusHover.setValue(value);
                }
                this._borderBottomRightRadius = value;
                this.update();
            }, this)
        });

        return this;
    };

    /**
     * Sets bottom left radius
     *
     * @returns {ss.panel.design.block.Border}
     *
     * @private
     */
    ss.panel.design.block.Border.prototype._setBottomLeftRadius = function () {
        if (this._borderBottomLeftRadius === null) {
            return this;
        }

        var borderBottomLeftRadiusHover = null;

        if (this._borderBottomLeftRadiusHover !== null) {
            borderBottomLeftRadiusHover = new ss.forms.Spinner({
                value: this._borderBottomLeftRadiusHover,
                css: "border-bottom-left-radius-hover",
                iconBefore: "fa-mouse-pointer",
                min: 0,
                appendTo: this._relativeContainer,
                callback: $.proxy(function (value) {
                    this._borderBottomLeftRadiusHover = value;
                    this.update();
                }, this)
            });
        }

        new ss.forms.Spinner({
            value: this._borderBottomLeftRadius,
            css: "border-bottom-left-radius",
            min: 0,
            appendTo: this._relativeContainer,
            callback: $.proxy(function (value) {
                if (this._borderBottomLeftRadius === this._borderBottomLeftRadiusHover
                    && borderBottomLeftRadiusHover !== null
                ) {
                    this._borderBottomLeftRadiusHover = value;
                    borderBottomLeftRadiusHover.setValue(value);
                }

                this._borderBottomLeftRadius = value;
                this.update();
            }, this)
        });

        return this;
    };

    /**
     * Sets top width
     *
     * @returns {ss.panel.design.block.Border}
     *
     * @private
     */
    ss.panel.design.block.Border.prototype._setTopWidth = function () {
        if (this._borderTopWidth === null) {
            return this;
        }

        var borderTopWidthHover = null;

        if (this._borderTopWidthHover !== null) {
            borderTopWidthHover = new ss.forms.Spinner({
                value: this._borderTopWidthHover,
                css: "border-top-width-hover",
                min: 0,
                iconBefore: "fa-mouse-pointer",
                appendTo: this._relativeContainer,
                callback: $.proxy(function (value) {
                    this._borderTopWidthHover = value;
                    this.update();
                }, this)
            });
        }

        new ss.forms.Spinner({
            value: this._borderTopWidth,
            css: "border-top-width",
            min: 0,
            appendTo: this._relativeContainer,
            callback: $.proxy(function (value) {
                if (this._borderTopWidth === this._borderTopWidthHover
                    && borderTopWidthHover !== null
                ) {
                    this._borderTopWidthHover = value;
                    borderTopWidthHover.setValue(value);
                }
                this._borderTopWidth = value;
                this.update();
            }, this)
        });

        return this;
    };

    /**
     * Sets right width
     *
     * @returns {ss.panel.design.block.Border}
     *
     * @private
     */
    ss.panel.design.block.Border.prototype._setRightWidth = function () {
        if (this._borderRightWidth === null) {
            return this;
        }

        var borderRightWidthHover = null;

        if (this._borderRightWidthHover !== null) {
            borderRightWidthHover = new ss.forms.Spinner({
                value: this._borderRightWidthHover,
                css: "border-right-width-hover",
                min: 0,
                iconBefore: "fa-mouse-pointer",
                appendTo: this._relativeContainer,
                callback: $.proxy(function (value) {
                    this._borderRightWidthHover = value;
                    this.update();
                }, this)
            });
        }

        new ss.forms.Spinner({
            value: this._borderRightWidth,
            css: "border-right-width",
            min: 0,
            appendTo: this._relativeContainer,
            callback: $.proxy(function (value) {
                if (this._borderRightWidth === this._borderRightWidthHover
                    && borderRightWidthHover !== null
                ) {
                    this._borderRightWidthHover = value;
                    borderRightWidthHover.setValue(value);
                }
                this._borderRightWidth = value;
                this.update();
            }, this)
        });

        return this;
    };

    /**
     * Sets bottom width
     *
     * @returns {ss.panel.design.block.Border}
     *
     * @private
     */
    ss.panel.design.block.Border.prototype._setBottomWidth = function () {
        if (this._borderBottomWidth === null) {
            return this;
        }

        var borderBottomWidthHover = null;

        if (this._borderBottomWidthHover !== null) {
            borderBottomWidthHover = new ss.forms.Spinner({
                value: this._borderBottomWidthHover,
                css: "border-bottom-width-hover",
                min: 0,
                iconBefore: "fa-mouse-pointer",
                appendTo: this._relativeContainer,
                callback: $.proxy(function (value) {
                    this._borderBottomWidthHover = value;
                    this.update();
                }, this)
            });
        }

        new ss.forms.Spinner({
            value: this._borderBottomWidth,
            css: "border-bottom-width",
            min: 0,
            appendTo: this._relativeContainer,
            callback: $.proxy(function (value) {
                if (this._borderBottomWidth === this._borderBottomWidthHover
                    && borderBottomWidthHover !== null
                ) {
                    this._borderBottomWidthHover = value;
                    borderBottomWidthHover.setValue(value);
                }
                this._borderBottomWidth = value;
                this.update();
            }, this)
        });

        return this;
    };

    /**
     * Sets left width
     *
     * @returns {ss.panel.design.block.Border}
     *
     * @private
     */
    ss.panel.design.block.Border.prototype._setLeftWidth = function () {
        if (this._borderLeftWidth === null) {
            return this;
        }

        var borderLeftWidthHover = null;

        if (this._borderLeftWidthHover !== null) {
            borderLeftWidthHover = new ss.forms.Spinner({
                value: this._borderLeftWidthHover,
                css: "border-left-width-hover",
                min: 0,
                iconBefore: "fa-mouse-pointer",
                appendTo: this._relativeContainer,
                callback: $.proxy(function (value) {
                    this._borderLeftWidthHover = value;
                    this.update();
                }, this)
            });
        }

        new ss.forms.Spinner({
            value: this._borderLeftWidth,
            css: "border-left-width",
            min: 0,
            appendTo: this._relativeContainer,
            callback: $.proxy(function (value) {
                if (this._borderLeftWidth === this._borderLeftWidthHover
                    && borderLeftWidthHover !== null
                ) {
                    this._borderLeftWidthHover = value;
                    borderLeftWidthHover.setValue(value);
                }
                this._borderLeftWidth = value;
                this.update();
            }, this)
        });

        return this;
    };

    /**
     * Sets style
     *
     * @returns {ss.panel.design.block.Border}
     *
     * @private
     */
    ss.panel.design.block.Border.prototype._setStyle = function () {
        if (this._borderStyle === null) {
            return this;
        }

        new ss.forms.RadioButtons({
            label: this.getLabel("borderStyle"),
            value: this._borderStyle,
            data: this._styleList,
            appendTo: this.getGroupContainer(),
            onChange: $.proxy(function (value) {
                this._borderStyle = value;
                this.update();
            }, this)
        });

        return this;
    };

    /**
     * Sets color
     *
     * @returns {ss.panel.design.block.Border}
     *
     * @private
     */
    ss.panel.design.block.Border.prototype._setColor = function () {
        if (this._borderColor === null) {
            return this;
        }

        new ss.forms.Color({
            label: this.getLabel("borderColor"),
            title: this.getLabel("borderColor"),
            value: this._borderColor,
            appendTo: this.getGroupContainer(),
            callback: $.proxy(function (color) {
                this._borderColor = color;
                this.update();
            }, this)
        });

        return this;
    };

    /**
     * Sets has hover
     *
     * @returns {ss.panel.design.block.Border}
     *
     * @private
     */
    ss.panel.design.block.Border.prototype._setHasHover = function () {
        if (this._hasBorderHover === null) {
            return this;
        }

        if (this._hasBorderHover === true) {
            this.getGroupContainer().addClass("has-hover");
        }

        var onCheck = $.proxy(function () {
            this._hasBorderHover = true;
            this.getGroupContainer().addClass("has-hover");
            this.update();
        }, this);

        var onUnCheck = $.proxy(function () {
            this._hasBorderHover = false;
            this.getGroupContainer().removeClass("has-hover");
            this.update();
        }, this);

        new ss.forms.CheckboxOnOff({
            value: this._hasBorderHover,
            label: this.getLabel("mouseHoverEffect"),
            appendTo: this.getGroupContainer(),
            onCheck: onCheck,
            onUnCheck: onUnCheck
        });

        return this;
    };

    /**
     * Sets style hover
     *
     * @returns {ss.panel.design.block.Border}
     *
     * @private
     */
    ss.panel.design.block.Border.prototype._setStyleHover = function () {
        if (this._borderStyleHover === null) {
            return this;
        }

        new ss.forms.RadioButtons({
            label: this.getLabel("borderStyleHover"),
            value: this._borderStyleHover,
            css: "border-style-hover",
            data: this._styleList,
            appendTo: this.getGroupContainer(),
            onChange: $.proxy(function (value) {
                this._borderStyleHover = value;
                this.update();
            }, this)
        });

        return this;
    };

    /**
     * Sets color hover
     *
     * @returns {ss.panel.design.block.Border}
     *
     * @private
     */
    ss.panel.design.block.Border.prototype._setColorHover = function () {
        if (this._borderColorHover === null) {
            return this;
        }

        new ss.forms.Color({
            label: this.getLabel("borderColorHover"),
            title: this.getLabel("borderColor"),
            value: this._borderColorHover,
            css: "border-color-hover",
            appendTo: this.getGroupContainer(),
            callback: $.proxy(function (color) {
                this._borderColorHover = color;
                this.update();
            }, this)
        });

        return this;
    };

    /**
     * Sets has animation
     *
     * @returns {ss.panel.design.block.Border}
     *
     * @private
     */
    ss.panel.design.block.Border.prototype._setHasAnimation = function () {
        if (this._hasBorderAnimation === null) {
            return this;
        }

        var onCheck = $.proxy(function () {
            this._hasBorderAnimation = true;
            this.update();
        }, this);

        var onUnCheck =  $.proxy(function () {
            this._hasBorderAnimation = false;
            this.update();
        }, this);

        new ss.forms.CheckboxOnOff({
            value: this._hasBorderAnimation,
            label: this.getLabel("mouseHoverAnimation"),
            css: "has-border-animation",
            appendTo: this.getGroupContainer(),
            onCheck: onCheck,
            onUnCheck: onUnCheck
        });

        return this;
    };

    /**
     * Generates styles
     *
     * @param {boolean} isHover
     *
     * @returns {String}
     */
    ss.panel.design.block.Border.prototype.generateCss = function (isHover) {
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
            if (this._hasBorderHover !== true) {
                return "";
            }

            borderTopLeftRadius = ss.components.Library.getIntVal(
                this._borderTopLeftRadiusHover
            );
            borderTopRightRadius = ss.components.Library.getIntVal(
                this._borderTopRightRadiusHover
            );
            borderBottomRightRadius = ss.components.Library.getIntVal(
                this._borderBottomRightRadiusHover
            );
            borderBottomLeftRadius = ss.components.Library.getIntVal(
                this._borderBottomLeftRadiusHover
            );

            borderTopWidth = ss.components.Library.getIntVal(
                this._borderTopWidthHover
            );
            borderRightWidth = ss.components.Library.getIntVal(
                this._borderRightWidthHover
            );
            borderBottomWidth = ss.components.Library.getIntVal(
                this._borderBottomWidthHover
            );
            borderLeftWidth = ss.components.Library.getIntVal(
                this._borderLeftWidthHover
            );

            borderColor = this._borderColorHover;
        } else {
            borderTopLeftRadius = ss.components.Library.getIntVal(
                this._borderTopLeftRadius
            );
            borderTopRightRadius = ss.components.Library.getIntVal(
                this._borderTopRightRadius
            );
            borderBottomRightRadius = ss.components.Library.getIntVal(
                this._borderBottomRightRadius
            );
            borderBottomLeftRadius = ss.components.Library.getIntVal(
                this._borderBottomLeftRadius
            );

            borderTopWidth = ss.components.Library.getIntVal(
                this._borderTopWidth
            );
            borderRightWidth = ss.components.Library.getIntVal(
                this._borderRightWidth
            );
            borderBottomWidth = ss.components.Library.getIntVal(
                this._borderBottomWidth
            );
            borderLeftWidth = ss.components.Library.getIntVal(
                this._borderLeftWidth
            );

            borderColor = this._borderColor;
        }

        if (borderTopLeftRadius !== 0) {
            borderTopLeftRadius += "px";
        }

        if (borderTopRightRadius !== 0) {
            borderTopRightRadius += "px";
        }

        if (borderBottomRightRadius !== 0) {
            borderBottomRightRadius += "px";
        }

        if (borderBottomLeftRadius !== 0) {
            borderBottomLeftRadius += "px";
        }

        var css = "";

        css += "-webkit-border-radius:"
            + borderTopLeftRadius
            +  " "
            + borderTopRightRadius
            + " "
            + borderBottomRightRadius
            + " "
            + borderBottomLeftRadius
            + ";";

        css += "-moz-border-radius:"
            + borderTopLeftRadius
            +  " "
            + borderTopRightRadius
            + " "
            + borderBottomRightRadius
            + " "
            + borderBottomLeftRadius
            + ";";

        css += "border-radius:"
            + borderTopLeftRadius
            +  " "
            + borderTopRightRadius
            + " "
            + borderBottomRightRadius
            + " "
            + borderBottomLeftRadius
            + ";";

        if (borderTopWidth !== 0) {
            borderTopWidth += "px";
        }

        if (borderRightWidth !== 0) {
            borderRightWidth += "px";
        }

        if (borderBottomWidth !== 0) {
            borderBottomWidth += "px";
        }

        if (borderLeftWidth !== 0) {
            borderLeftWidth += "px";
        }

        css += "border-width:"
            + borderTopWidth
            +  " "
            + borderRightWidth
            + " "
            + borderBottomWidth
            + " "
            + borderLeftWidth
            + ";";

        if (borderColor === null) {
            borderColor = "";
        }

        if (borderColor === "") {
            borderColor = "transparent";
        }
        css += "border-color:" + borderColor + ";";

        css += "border-style:" + this._getBorderStyle(isHover) + ";";

        return css;
    };

    /**
     * Has animation
     *
     * @return {boolean}
     */
    ss.panel.design.block.Border.prototype.hasAnimation = function () {
        return this._hasBorderHover === true
            && this._hasBorderAnimation === true;
    };

    /**
     * Gets border style
     *
     * @param {boolean} isHover
     *
     * @return {String}
     */
    ss.panel.design.block.Border.prototype._getBorderStyle = function(isHover) {
        var borderStyle;

        if (isHover === true) {
            borderStyle = this._borderStyleHover;
        } else {
            borderStyle = this._borderStyle;
        }

        if (this._borderStyleList[borderStyle] !== undefined) {
            return this._borderStyleList[borderStyle];
        }

        return this._borderStyleList[0];
    };
}(window.jQuery, window.ss);
