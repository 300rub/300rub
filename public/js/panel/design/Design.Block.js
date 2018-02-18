!function ($, ss) {
    'use strict';

    /**
     * Design block
     *
     * @param {Object} data
     *
     * @type {ss.panel.design.block}
     */
    ss.panel.design.block = function (data) {
        this._data = $.extend({}, data);

        this._selector = "";
        this._labels = {};
        this._values = {};
        this._names = {};

        this._rollbackStyles = "";

        this.$_designContainer = null;
        this.$_styleContainer = null;

        this.$_backgroundExample = null;
        this.$_backgroundExampleStyles = null;
        this.$_borderExample = null;
        this.$_borderExampleStyles = null;

        this.init();
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    ss.panel.design.block.prototype = {



        /**
         * List of border styles
         *
         * @var {Object}
         */
        _borderStyleList: {
            0: "solid",
            1: "dotted",
            2: "dashed"
        },

        /**
         * Init
         */
        init: function () {
            this
                ._setValues()
                ._setBackground()
                ._setBorder();
        },

        /**
         * Sets values
         *
         * @returns {ss.panel.design.block}
         *
         * @private
         */
        _setValues: function() {
            this._values = $.extend(
                {
                    borderTopLeftRadius: null,
                    borderTopLeftRadiusHover: null,
                    borderTopRightRadius: null,
                    borderTopRightRadiusHover: null,
                    borderBottomRightRadius: null,
                    borderBottomRightRadiusHover: null,
                    borderBottomLeftRadius: null,
                    borderBottomLeftRadiusHover: null,
                    borderTopWidth: null,
                    borderTopWidthHover: null,
                    borderRightWidth: null,
                    borderRightWidthHover: null,
                    borderBottomWidth: null,
                    borderBottomWidthHover: null,
                    borderLeftWidth: null,
                    borderLeftWidthHover: null,
                    borderStyle: null,
                    borderStyleHover: null,
                    borderColor: null,
                    borderColorHover: null,
                    hasBorderHover: null,
                    hasBorderAnimation: null
                },
                this._data["values"]
            );

            return this;
        },

        /**
         * Sets border
         *
         * @returns {ss.panel.design.block}
         *
         * @private
         */
        _setBorder: function() {
            var $container = this.$_designContainer.find(".border-container");

            if (this._values["borderTopLeftRadius"] === null
                && this._values["borderTopRightRadius"] === null
                && this._values["borderBottomRightRadius"] === null
                && this._values["borderBottomLeftRadius"] === null
                && this._values["borderTopWidth"] === null
                && this._values["borderRightWidth"] === null
                && this._values["borderBottomWidth"] === null
                && this._values["borderLeftWidth"] === null
            ) {
                $container.remove();
                return this;
            }

            this.$_borderExampleStyles = $container.find(".styles-example-container");

            $container.find(".category-title").text(this.getLabel("border"));

            var uniqueId = ss.components.Library.getUniqueId();
            this.$_borderExample = $container.find(".border-example")
                .addClass("border-example-" + uniqueId)
                .attr("data-id", uniqueId);

            var $relativeContainer = $container.find(".relative-container");

            if (this._values["borderTopLeftRadius"] !== null) {
                var borderTopLeftRadiusHover = null;

                if (this._values["borderTopLeftRadiusHover"] !== null) {
                    borderTopLeftRadiusHover = new ss.forms.Spinner({
                        value: this._values["borderTopLeftRadiusHover"],
                        css: "border-top-left-radius-hover",
                        min: 0,
                        iconBefore: "fa-mouse-pointer",
                        callback: $.proxy(function (value) {
                            this._values["borderTopLeftRadiusHover"] = value;
                            this._updateBorder(false);
                        }, this),
                        appendTo: $relativeContainer
                    });
                }

                new ss.forms.Spinner({
                    value: this._values["borderTopLeftRadius"],
                    css: "border-top-left-radius",
                    min: 0,
                    callback: $.proxy(function (value) {
                        if (this._values["borderTopLeftRadius"] === this._values["borderTopLeftRadiusHover"]
                            && borderTopLeftRadiusHover !== null
                        ) {
                            this._values["borderTopLeftRadiusHover"] = value;
                            borderTopLeftRadiusHover.setValue(value);
                        }
                        this._values["borderTopLeftRadius"] = value;
                        this._updateBorder(false);
                    }, this),
                    appendTo: $relativeContainer
                });
            }

            if (this._values["borderTopRightRadius"] !== null) {
                var borderTopRightRadiusHover = null;

                if (this._values["borderTopRightRadiusHover"] !== null) {
                    borderTopRightRadiusHover = new ss.forms.Spinner({
                        value: this._values["borderTopRightRadiusHover"],
                        css: "border-top-right-radius-hover",
                        iconBefore: "fa-mouse-pointer",
                        min: 0,
                        callback: $.proxy(function (value) {
                            this._values["borderTopRightRadiusHover"] = value;
                            this._updateBorder(false);
                        }, this),
                        appendTo: $relativeContainer
                    });
                }

                new ss.forms.Spinner({
                    value: this._values["borderTopRightRadius"],
                    css: "border-top-right-radius",
                    min: 0,
                    callback: $.proxy(function (value) {
                        if (this._values["borderTopRightRadius"] === this._values["borderTopRightRadiusHover"]
                            && borderTopRightRadiusHover !== null
                        ) {
                            this._values["borderTopRightRadiusHover"] = value;
                            borderTopRightRadiusHover.setValue(value);
                        }
                        this._values["borderTopRightRadius"] = value;
                        this._updateBorder(false);
                    }, this),
                    appendTo: $relativeContainer
                });
            }

            if (this._values["borderBottomRightRadius"] !== null) {
                var borderBottomRightRadiusHover = null;

                if (this._values["borderBottomRightRadiusHover"] !== null) {
                    borderBottomRightRadiusHover = new ss.forms.Spinner({
                        value: this._values["borderBottomRightRadiusHover"],
                        css: "border-bottom-right-radius-hover",
                        min: 0,
                        iconBefore: "fa-mouse-pointer",
                        callback: $.proxy(function (value) {
                            this._values["borderBottomRightRadiusHover"] = value;
                            this._updateBorder(false);
                        }, this),
                        appendTo: $relativeContainer
                    });
                }

                new ss.forms.Spinner({
                    value: this._values["borderBottomRightRadius"],
                    css: "border-bottom-right-radius",
                    min: 0,
                    callback: $.proxy(function (value) {
                        if (this._values["borderBottomRightRadius"] === this._values["borderBottomRightRadiusHover"]
                            && borderBottomRightRadiusHover !== null
                        ) {
                            this._values["borderBottomRightRadiusHover"] = value;
                            borderBottomRightRadiusHover.setValue(value);
                        }
                        this._values["borderBottomRightRadius"] = value;
                        this._updateBorder(false);
                    }, this),
                    appendTo: $relativeContainer
                });
            }

            if (this._values["borderBottomLeftRadius"] !== null) {
                var borderBottomLeftRadiusHover = null;

                if (this._values["borderBottomLeftRadiusHover"] !== null) {
                    borderBottomLeftRadiusHover = new ss.forms.Spinner({
                        value: this._values["borderBottomLeftRadiusHover"],
                        css: "border-bottom-left-radius-hover",
                        iconBefore: "fa-mouse-pointer",
                        min: 0,
                        callback: $.proxy(function (value) {
                            this._values["borderBottomLeftRadiusHover"] = value;
                            this._updateBorder(false);
                        }, this),
                        appendTo: $relativeContainer
                    });
                }

                new ss.forms.Spinner({
                    value: this._values["borderBottomLeftRadius"],
                    css: "border-bottom-left-radius",
                    min: 0,
                    callback: $.proxy(function (value) {
                        if (this._values["borderBottomLeftRadius"] === this._values["borderBottomLeftRadiusHover"]
                            && borderBottomLeftRadiusHover !== null
                        ) {
                            this._values["borderBottomLeftRadiusHover"] = value;
                            borderBottomLeftRadiusHover.setValue(value);
                        }
                        this._values["borderBottomLeftRadius"] = value;
                        this._updateBorder(false);
                    }, this),
                    appendTo: $relativeContainer
                });
            }

            if (this._values["borderTopWidth"] !== null) {
                var borderTopWidthHover = null;

                if (this._values["borderTopWidthHover"] !== null) {
                    borderTopWidthHover = new ss.forms.Spinner({
                        value: this._values["borderTopWidthHover"],
                        css: "border-top-width-hover",
                        min: 0,
                        iconBefore: "fa-mouse-pointer",
                        callback: $.proxy(function (value) {
                            this._values["borderTopWidthHover"] = value;
                            this._updateBorder(false);
                        }, this),
                        appendTo: $relativeContainer
                    });
                }

                new ss.forms.Spinner({
                    value: this._values["borderTopWidth"],
                    css: "border-top-width",
                    min: 0,
                    callback: $.proxy(function (value) {
                        if (this._values["borderTopWidth"] === this._values["borderTopWidthHover"]
                            && borderTopWidthHover !== null
                        ) {
                            this._values["borderTopWidthHover"] = value;
                            borderTopWidthHover.setValue(value);
                        }
                        this._values["borderTopWidth"] = value;
                        this._updateBorder(false);
                    }, this),
                    appendTo: $relativeContainer
                });
            }

            if (this._values["borderRightWidth"] !== null) {
                var borderRightWidthHover = null;

                if (this._values["borderRightWidthHover"] !== null) {
                    borderRightWidthHover = new ss.forms.Spinner({
                        value: this._values["borderRightWidthHover"],
                        css: "border-right-width-hover",
                        min: 0,
                        iconBefore: "fa-mouse-pointer",
                        callback: $.proxy(function (value) {
                            this._values["borderRightWidthHover"] = value;
                            this._updateBorder(false);
                        }, this),
                        appendTo: $relativeContainer
                    });
                }

                new ss.forms.Spinner({
                    value: this._values["borderRightWidth"],
                    css: "border-right-width",
                    min: 0,
                    callback: $.proxy(function (value) {
                        if (this._values["borderRightWidth"] === this._values["borderRightWidthHover"]
                            && borderRightWidthHover !== null
                        ) {
                            this._values["borderRightWidthHover"] = value;
                            borderRightWidthHover.setValue(value);
                        }
                        this._values["borderRightWidth"] = value;
                        this._updateBorder(false);
                    }, this),
                    appendTo: $relativeContainer
                });
            }

            if (this._values["borderBottomWidth"] !== null) {
                var borderBottomWidthHover = null;

                if (this._values["borderBottomWidthHover"] !== null) {
                    borderBottomWidthHover = new ss.forms.Spinner({
                        value: this._values["borderBottomWidthHover"],
                        css: "border-bottom-width-hover",
                        min: 0,
                        iconBefore: "fa-mouse-pointer",
                        callback: $.proxy(function (value) {
                            this._values["borderBottomWidthHover"] = value;
                            this._updateBorder(false);
                        }, this),
                        appendTo: $relativeContainer
                    });
                }

                new ss.forms.Spinner({
                    value: this._values["borderBottomWidth"],
                    css: "border-bottom-width",
                    min: 0,
                    callback: $.proxy(function (value) {
                        if (this._values["borderBottomWidth"] === this._values["borderBottomWidthHover"]
                            && borderBottomWidthHover !== null
                        ) {
                            this._values["borderBottomWidthHover"] = value;
                            borderBottomWidthHover.setValue(value);
                        }
                        this._values["borderBottomWidth"] = value;
                        this._updateBorder(false);
                    }, this),
                    appendTo: $relativeContainer
                });
            }

            if (this._values["borderLeftWidth"] !== null) {
                var borderLeftWidthHover = null;

                if (this._values["borderLeftWidthHover"] !== null) {
                    borderLeftWidthHover = new ss.forms.Spinner({
                        value: this._values["borderLeftWidthHover"],
                        css: "border-left-width-hover",
                        min: 0,
                        iconBefore: "fa-mouse-pointer",
                        callback: $.proxy(function (value) {
                            this._values["borderLeftWidthHover"] = value;
                            this._updateBorder(false);
                        }, this),
                        appendTo: $relativeContainer
                    });
                }

                new ss.forms.Spinner({
                    value: this._values["borderLeftWidth"],
                    css: "border-left-width",
                    min: 0,
                    callback: $.proxy(function (value) {
                        if (this._values["borderLeftWidth"] === this._values["borderLeftWidthHover"]
                            && borderLeftWidthHover !== null
                        ) {
                            this._values["borderLeftWidthHover"] = value;
                            borderLeftWidthHover.setValue(value);
                        }
                        this._values["borderLeftWidth"] = value;
                        this._updateBorder(false);
                    }, this),
                    appendTo: $relativeContainer
                });
            }

            if (this._values["borderStyle"] !== null) {
                new ss.forms.RadioButtons({
                    label: this.getLabel("borderStyle"),
                    value: this._values["borderStyle"],
                    data: [
                        {
                            value: 0,
                            label: "",
                            class: "solid"
                        },
                        {
                            value: 1,
                            label: "",
                            class: "dotted"
                        },
                        {
                            value: 2,
                            label: "",
                            class: "dashed"
                        }
                    ],
                    onChange: $.proxy(function (value) {
                        this._values["borderStyle"] = value;
                        this._updateBorder(false);
                    }, this),
                    appendTo: $container
                });
            }

            if (this._values["borderColor"] !== null) {
                new ss.forms.Color({
                    label: this.getLabel("borderColor"),
                    title: this.getLabel("borderColor"),
                    value: this._values["borderColor"],
                    callback: $.proxy(function (color) {
                        this._values["borderColor"] = color;
                        this._updateBorder(false);
                    }, this),
                    appendTo: $container
                });
            }

            if (this._values["hasBorderHover"] === true) {
                $container.addClass("has-hover");
            }

            if (this._values["hasBorderHover"] !== null) {
                new ss.forms.CheckboxOnOff({
                    value: this._values["hasBorderHover"],
                    label: this.getLabel("mouseHoverEffect"),
                    onCheck: $.proxy(function () {
                        this._values["hasBorderHover"] = true;
                        $container.addClass("has-hover");
                        this._updateBorder(false);
                    }, this),
                    onUnCheck: $.proxy(function () {
                        this._values["hasBorderHover"] = false;
                        $container.removeClass("has-hover");
                        this._updateBorder(false);
                    }, this),
                    appendTo: $container
                });
            }

            if (this._values["borderStyleHover"] !== null) {
                new ss.forms.RadioButtons({
                    label: this.getLabel("borderStyleHover"),
                    value: this._values["borderStyleHover"],
                    css: "border-style-hover",
                    data: [
                        {
                            value: 0,
                            label: "",
                            class: "solid"
                        },
                        {
                            value: 1,
                            label: "",
                            class: "dotted"
                        },
                        {
                            value: 2,
                            label: "",
                            class: "dashed"
                        }
                    ],
                    onChange: $.proxy(function (value) {
                        this._values["borderStyleHover"] = value;
                        this._updateBorder(false);
                    }, this),
                    appendTo: $container
                });
            }

            if (this._values["borderColorHover"] !== null) {
                new ss.forms.Color({
                    label: this.getLabel("borderColorHover"),
                    title: this.getLabel("borderColor"),
                    value: this._values["borderColorHover"],
                    css: "border-color-hover",
                    callback: $.proxy(function (color) {
                        this._values["borderColorHover"] = color;
                        this._updateBorder(false);
                    }, this),
                    appendTo: $container
                });
            }

            if (this._values["hasBorderAnimation"] !== null) {
                new ss.forms.CheckboxOnOff({
                    value: this._values["hasBorderAnimation"],
                    label: this.getLabel("mouseHoverAnimation"),
                    css: "has-border-animation",
                    onCheck: $.proxy(function () {
                        this._values["hasBorderAnimation"] = true;
                        this._updateBorder(false);
                    }, this),
                    onUnCheck: $.proxy(function () {
                        this._values["hasBorderAnimation"] = false;
                        this._updateBorder(false);
                    }, this),
                    appendTo: $container
                });
            }

            this._updateBorder(true);

            return this;
        },



        /**
         * Gets border style
         *
         * @param {boolean} isHover
         *
         * @return {String}
         */
        _getBorderStyle: function(isHover) {
            var borderStyle;

            if (isHover === true) {
                borderStyle = this._values["borderStyleHover"];
            } else {
                borderStyle = this._values["borderStyle"];
            }

            if (this._borderStyleList[borderStyle] !== undefined) {
                return this._borderStyleList[borderStyle];
            }

            return this._borderStyleList[0];
        },

        /**
         * Generates border styles
         *
         * @param {boolean} isHover
         * @param {boolean} skipAnimation
         *
         * @returns {String}
         *
         * @private
         */
        _generateBorderCss: function(isHover, skipAnimation) {
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
                if (this._values["hasBorderHover"] !== true) {
                    return "";
                }

                borderTopLeftRadius = ss.components.Library.getIntVal(this._values["borderTopLeftRadiusHover"]);
                borderTopRightRadius = ss.components.Library.getIntVal(this._values["borderTopRightRadiusHover"]);
                borderBottomRightRadius = ss.components.Library.getIntVal(this._values["borderBottomRightRadiusHover"]);
                borderBottomLeftRadius = ss.components.Library.getIntVal(this._values["borderBottomLeftRadiusHover"]);

                borderTopWidth = ss.components.Library.getIntVal(this._values["borderTopWidthHover"]);
                borderRightWidth = ss.components.Library.getIntVal(this._values["borderRightWidthHover"]);
                borderBottomWidth = ss.components.Library.getIntVal(this._values["borderBottomWidthHover"]);
                borderLeftWidth = ss.components.Library.getIntVal(this._values["borderLeftWidthHover"]);

                borderColor = this._values["borderColorHover"];
            } else {
                borderTopLeftRadius = ss.components.Library.getIntVal(this._values["borderTopLeftRadius"]);
                borderTopRightRadius = ss.components.Library.getIntVal(this._values["borderTopRightRadius"]);
                borderBottomRightRadius = ss.components.Library.getIntVal(this._values["borderBottomRightRadius"]);
                borderBottomLeftRadius = ss.components.Library.getIntVal(this._values["borderBottomLeftRadius"]);

                borderTopWidth = ss.components.Library.getIntVal(this._values["borderTopWidth"]);
                borderRightWidth = ss.components.Library.getIntVal(this._values["borderRightWidth"]);
                borderBottomWidth = ss.components.Library.getIntVal(this._values["borderBottomWidth"]);
                borderLeftWidth = ss.components.Library.getIntVal(this._values["borderLeftWidth"]);

                borderColor = this._values["borderColor"];
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

            if (skipAnimation !== true
                && this._values["hasBorderHover"] === true
                && this._values["hasBorderAnimation"] === true
            ) {
                css += "-webkit-transition:border-radius .3s,border-width .3s,border-color .3s;";
                css += "-ms-transition:border-radius .3s,border-width .3s,border-color .3s;";
                css += "-o-transition:border-radius .3s,border-width .3s,border-color .3s;";
                css += "transition:border-radius .3s,border-width .3s,border-color .3s;";
            }

            return css;
        },

        /**
         * Generates all styles
         *
         * @param {boolean} isHover
         *
         * @returns {String}
         *
         * @private
         */
        _generateCss: function(isHover) {
            var css = "";



            css += this._generateBackgroundCss(isHover, true)
                + this._generateBorderCss(isHover, true);


            if (this._values["hasBackgroundGradient"] === false
                && this._values["hasBackgroundHover"] === true
                && this._values["hasBackgroundAnimation"] === true
            ) {
                animation.push("background-color .3s");
            }

            if (this._values["hasBorderHover"] === true
                && this._values["hasBorderAnimation"] === true
            ) {
                animation.push("border-radius .3s");
                animation.push("border-width .3s");
                animation.push("border-color .3s");
            }

            return css;
        },

        /**
         * Updates background
         *
         * @param {boolean} isOnlyExample
         *
         * @private
         */
        _updateBackground: function(isOnlyExample) {
            var id = this.$_backgroundExample.data("id");

            var css = "<style>";

            css += ".background-example-"
                + id
                + "{"
                + this._generateBackgroundCss(false)
                + "}";

            css += ".background-example-"
                + id
                + ":hover{"
                + this._generateBackgroundCss(true)
                +"}";

            css += "</style>";

            this.$_backgroundExampleStyles.html(css);

            if (isOnlyExample !== true) {
                this._update();
            }
        },

        /**
         * Updates border
         *
         * @param {boolean} isOnlyExample
         *
         * @private
         */
        _updateBorder: function(isOnlyExample) {
            var id = this.$_borderExample.data("id");

            var css = "<style>";

            css += ".border-example-"
                + id
                + "{"
                + this._generateBorderCss(false)
                + "}";

            css += ".border-example-"
                + id
                + ":hover{"
                + this._generateBorderCss(true)
                +"}";

            css += "</style>";

            this.$_borderExampleStyles.html(css);

            if (isOnlyExample !== true) {
                this._update();
            }
        }
    };
}(window.jQuery, window.ss);