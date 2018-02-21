!function ($, ss) {
    'use strict';

    /**
     * Prototype
     *
     * @type {Object}
     */
    ss.panel.design.Text.prototype = {

        /**
         * List of font family types
         *
         * @var {Object}
         */
        _familyList: {
            0: {
                style: 'font-family: "Open Sans", sans-serif;',
                name: "Open Sans"
            },
            1: {
                style: 'font-family: Arial, Helvetica, sans-serif;',
                name: "Arial, Helvetica"
            },
            2: {
                style: 'font-family: "Arial Black", Gadget, sans-serif;',
                name: "Arial Black, Gadget"
            },
            3 : {
                style: 'font-family: "Comic Sans MS", cursive;',
                name: "Comic Sans MS"
            },
            4: {
                style: 'font-family: "Courier New", Courier, monospace;',
                name: "Courier New"
            },
            5: {
                style: 'font-family: Georgia, serif;',
                name: "Georgia"
            },
            6: {
                style: 'font-family: Impact, Charcoal, sans-serif;',
                name: "Impact, Charcoal"
            },
            7: {
                style: 'font-family: "Lucida Console", Monaco, monospace;',
                name: "Lucida Console, Monaco"
            },
            8: {
                style: 'font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;',
                name: "Lucida Sans Unicode"
            },
            9: {
                style: 'font-family: "Palatino Linotype", "Book Antiqua", Palatino, serif;',
                name: "Palatino"
            },
            10: {
                style: 'font-family: Tahoma, Geneva, sans-serif;',
                name: "Tahoma, Geneva"
            },
            11: {
                style: 'font-family: "Times New Roman", Times, serif;',
                name: "Times New Roman, Times"
            },
            12: {
                style: 'font-family: "Trebuchet MS", Helvetica, sans-serif;',
                name: "Trebuchet MS, Helvetica"
            },
            13: {
                style: 'font-family: Verdana, Geneva, sans-serif;',
                name: "Verdana, Geneva"
            },
            14: {
                style: 'font-family: "MS Sans Serif", Geneva, sans-serif;',
                name: "MS Sans Serif, Geneva"
            },
            15: {
                style: 'font-family: "MS Serif", "New York", serif;',
                name: "MS Serif, New York"
            }
        },

        /**
         * Align list
         *
         * @var {Array}
         */
        _alignList: [
            {
                value: 0,
                css: "left",
                icon: "fa-align-left"
            },
            {
                value: 1,
                css: "center",
                icon: "fa-align-center"
            },
            {
                value: 2,
                css: "right",
                icon: "fa-align-right"
            },
            {
                value: 3,
                css: "justify",
                icon: "fa-align-justify"
            }
        ],

        /**
         * Text decoration list
         *
         * @var {Array}
         */
        _decorationList: [
            {
                value: 0,
                css: "none",
                class: "none",
                label: "N"
            },
            {
                value: 1,
                css: "underline",
                class: "underline",
                label: "U"
            },
            {
                value: 2,
                css: "line-through",
                class: "line-through",
                label: "T"
            },
            {
                value: 3,
                css: "overline",
                class: "overline",
                label: "O"
            }
        ],

        /**
         * Text decoration list
         *
         * @var {Array}
         */
        _transformList: [
            {
                value: 0,
                css: "none",
                label: "-"
            },
            {
                value: 1,
                css: "uppercase",
                label: "AA"
            },
            {
                value: 2,
                css: "lowercase",
                label: "aa"
            },
            {
                value: 3,
                css: "capitalize",
                label: "Aa"
            }
        ],

        /**
         * Init
         */
        init: function () {
            this
                ._setFamily()
                ._setColor()
                ._setAlign()
                ._setIsItalic()
                ._setIsBold()
                ._setLineHeight()
                ._setDecoration()
                ._setLetterSpacing()
                ._setTransform()
                ._setHasHover();
        },

        /**
         * Sets values
         *
         * @returns {ss.panel.design.Text}
         *
         * @private
         */
        _setValues: function() {
            this._values = $.extend(
                {
                    family: null,
                    color: null,
                    colorHover: null,
                    isItalic: null,
                    isItalicHover: null,
                    isBold: null,
                    isBoldHover: null,
                    align: null,
                    decoration: null,
                    decorationHover: null,
                    transform: null,
                    transformHover: null,
                    letterSpacing: null,
                    letterSpacingHover: null,
                    lineHeight: null,
                    lineHeightHover: null,
                    hasHover: null
                },
                this._data["values"]
            );

            return this;
        },

        /**
         * Sets family
         *
         * @returns {ss.panel.design.Text}
         *
         * @private
         */
        _setFamily: function() {
            if (this._values["family"] === null) {
                return this;
            }

            var list = [];
            $.each(this._familyList, function(key, data) {
                list.push({
                    key: key,
                    value: data["name"],
                    style: data["style"]
                });
            });

            new ss.forms.Select({
                list: list,
                value: this._values["family"],
                css: "family",
                onChange: $.proxy(function (value) {
                    this._values["family"] = value;
                    this._update(false);
                }, this),
                appendTo: this.$_commonContainer
            });

            return this;
        },

        /**
         * Sets color
         *
         * @returns {ss.panel.design.Text}
         *
         * @private
         */
        _setColor: function() {
            if (this._values["color"] !== null) {
                new ss.forms.Color({
                    title: this._getLabel("color"),
                    value: this._values["color"],
                    callback: $.proxy(function (color) {
                        this._values["color"] = color;
                        this._update(false);
                    }, this),
                    appendTo: this.$_commonContainer
                });
            }

            if (this._values["colorHover"] !== null) {
                new ss.forms.Color({
                    title: this._getLabel("color"),
                    value: this._values["colorHover"],
                    callback: $.proxy(function (color) {
                        this._values["colorHover"] = color;
                        this._update(false);
                    }, this),
                    appendTo: this.$_hoverContainer
                });
            }

            return this;
        },

        /**
         * Sets isItalic
         *
         * @returns {ss.panel.design.Text}
         *
         * @private
         */
        _setIsItalic: function() {
            var hoverForm = null;

            if (this._values["isItalicHover"] !== null) {
                hoverForm = new ss.forms.CheckboxButton({
                    value: this._values["isItalicHover"],
                    icon: "fa-italic",
                    onCheck: $.proxy(function () {
                        this._values["isItalicHover"] = true;
                        this._update(false);
                    }, this),
                    onUnCheck: $.proxy(function () {
                        this._values["isItalicHover"] = false;
                        this._update(false);
                    }, this),
                    appendTo: this.$_hoverContainer
                });
            }

            if (this._values["isItalic"] !== null) {
                new ss.forms.CheckboxButton({
                    value: this._values["isItalic"],
                    icon: "fa-italic",
                    onCheck: $.proxy(function () {
                        if (hoverForm !== null
                            && this._values["isItalic"] === this._values["isItalicHover"]
                        ) {
                            hoverForm.getFormInstance().attr("checked", true);
                            this._values["isItalicHover"] = true;
                        }

                        this._values["isItalic"] = true;
                        this._update(false);
                    }, this),
                    onUnCheck: $.proxy(function () {
                        if (hoverForm !== null
                            && this._values["isItalic"] === this._values["isItalicHover"]
                        ) {
                            hoverForm.getFormInstance().attr("checked", false);
                            this._values["isItalicHover"] = false;
                        }

                        this._values["isItalic"] = false;
                        this._update(false);
                    }, this),
                    appendTo: this.$_commonContainer
                });
            }

            return this;
        },

        /**
         * Sets isBold
         *
         * @returns {ss.panel.design.Text}
         *
         * @private
         */
        _setIsBold: function() {
            var hoverForm = null;

            if (this._values["isBoldHover"] !== null) {
                hoverForm = new ss.forms.CheckboxButton({
                    value: this._values["isBoldHover"],
                    icon: "fa-bold",
                    onCheck: $.proxy(function () {
                        this._values["isBoldHover"] = true;
                        this._update(false);
                    }, this),
                    onUnCheck: $.proxy(function () {
                        this._values["isBoldHover"] = false;
                        this._update(false);
                    }, this),
                    appendTo: this.$_hoverContainer
                });
            }

            if (this._values["isBold"] !== null) {
                new ss.forms.CheckboxButton({
                    value: this._values["isBold"],
                    icon: "fa-bold",
                    onCheck: $.proxy(function () {
                        if (hoverForm !== null
                            && this._values["isBold"] === this._values["isBoldHover"]
                        ) {
                            hoverForm.getFormInstance().attr("checked", true);
                            this._values["isBoldHover"] = true;
                        }

                        this._values["isBold"] = true;
                        this._update(false);
                    }, this),
                    onUnCheck: $.proxy(function () {
                        if (hoverForm !== null
                            && this._values["isBold"] === this._values["isBoldHover"]
                        ) {
                            hoverForm.getFormInstance().attr("checked", false);
                            this._values["isBoldHover"] = false;
                        }

                        this._values["isBold"] = false;
                        this._update(false);
                    }, this),
                    appendTo: this.$_commonContainer
                });
            }

            return this;
        },

        /**
         * Sets align
         *
         * @returns {ss.panel.design.Text}
         *
         * @private
         */
        _setAlign: function() {
            if (this._values["align"] === null) {
                return this;
            }

            new ss.forms.RadioButtons({
                value: this._values["align"],
                data: this._alignList,
                css: "align",
                onChange: $.proxy(function (value) {
                    this._values["align"] = value;
                    this._update(false);
                }, this),
                appendTo: this.$_commonContainer
            });

            return this;
        },

        /**
         * Sets align
         *
         * @returns {ss.panel.design.Text}
         *
         * @private
         */
        _setDecoration: function() {
            var hoverForm = null;
            if (this._values["decorationHover"] !== null) {
                hoverForm = new ss.forms.RadioButtons({
                    value: this._values["decorationHover"],
                    data: this._decorationList,
                    onChange: $.proxy(function (value) {
                        this._values["decorationHover"] = value;
                        this._update(false);
                    }, this),
                    appendTo: this.$_hoverContainer
                });
            }

            if (this._values["decoration"] !== null) {
                new ss.forms.RadioButtons({
                    value: this._values["decoration"],
                    data: this._decorationList,
                    css: "decoration",
                    onChange: $.proxy(function (value) {
                        if (hoverForm !== null
                            && this._values["decoration"] === this._values["decorationHover"]
                        ) {
                            this._values["decorationHover"] = false;
                            hoverForm.getFormInstance().val(value).change();
                        }

                        this._values["decoration"] = value;
                        this._update(false);
                    }, this),
                    appendTo: this.$_commonContainer
                });
            }

            return this;
        },

        /**
         * Sets transform
         *
         * @returns {ss.panel.design.Text}
         *
         * @private
         */
        _setTransform: function() {
            var hoverForm = null;
            if (this._values["transformHover"] !== null) {
                hoverForm = new ss.forms.RadioButtons({
                    value: this._values["transformHover"],
                    data: this._transformList,
                    onChange: $.proxy(function (value) {
                        this._values["transformHover"] = value;
                        this._update(false);
                    }, this),
                    appendTo: this.$_hoverContainer
                });
            }

            if (this._values["transform"] !== null) {
                new ss.forms.RadioButtons({
                    value: this._values["transform"],
                    data: this._transformList,
                    onChange: $.proxy(function (value) {
                        if (hoverForm !== null
                            && this._values["transform"] === this._values["transformHover"]
                        ) {
                            this._values["transformHover"] = false;
                            hoverForm.getFormInstance().val(value).change();
                        }

                        this._values["transform"] = value;
                        this._update(false);
                    }, this),
                    appendTo: this.$_commonContainer
                });
            }

            return this;
        },

        /**
         * Sets letterSpacing
         *
         * @returns {ss.panel.design.Text}
         *
         * @private
         */
        _setLetterSpacing: function() {
            var hoverForm = null;

            if (this._values["letterSpacingHover"] !== null) {
                hoverForm = new ss.forms.Spinner({
                    value: this._values["letterSpacingHover"],
                    callback: $.proxy(function (value) {
                        this._values["letterSpacingHover"] = value;
                        this._update(false);
                    }, this),
                    appendTo: this.$_hoverContainer
                });
            }

            if (this._values["letterSpacing"] !== null) {
                new ss.forms.Spinner({
                    value: this._values["letterSpacing"],
                    css: "letter-spacing",
                    iconBefore: "fa-arrows-h",
                    callback: $.proxy(function (value) {
                        if (hoverForm !== null
                            && this._values["letterSpacing"] === this._values["letterSpacingHover"]
                        ) {
                            this._values["letterSpacingHover"] = value;
                            hoverForm.getFormInstance().val(value);
                        }

                        this._values["letterSpacing"] = value;
                        this._update(false);
                    }, this),
                    appendTo: this.$_commonContainer
                });
            }

            return this;
        },

        /**
         * Sets lineHeight
         *
         * @returns {ss.panel.design.Text}
         *
         * @private
         */
        _setLineHeight: function() {
            var hoverForm = null;

            if (this._values["lineHeightHover"] !== null) {
                hoverForm = new ss.forms.Spinner({
                    value: this._values["lineHeightHover"],
                    callback: $.proxy(function (value) {
                        this._values["lineHeightHover"] = value;
                        this._update(false);
                    }, this),
                    appendTo: this.$_hoverContainer
                });
            }

            if (this._values["lineHeight"] !== null) {
                new ss.forms.Spinner({
                    value: this._values["lineHeight"],
                    css: "line-height",
                    iconBefore: "fa-arrows-v",
                    callback: $.proxy(function (value) {
                        if (hoverForm !== null
                            && this._values["lineHeight"] === this._values["lineHeightHover"]
                        ) {
                            this._values["lineHeightHover"] = value;
                            hoverForm.getFormInstance().val(value);
                        }

                        this._values["lineHeight"] = value;
                        this._update(false);
                    }, this),
                    appendTo: this.$_commonContainer
                });
            }

            return this;
        },

        /**
         * Sets lineHeight
         *
         * @returns {ss.panel.design.Text}
         *
         * @private
         */
        _setHasHover: function() {
            if (this._values["hasHover"] === null) {
                this.$_hoverContainer.addClass("hidden");
                return this;
            }

            if (this._values["hasHover"] === true) {
                this.$_hoverContainer.removeClass("hidden");
            } else {
                this.$_hoverContainer.addClass("hidden");
            }

            new ss.forms.CheckboxOnOff({
                value: this._values["hasHover"],
                label: this._getLabel("mouseHoverEffect"),
                onCheck: $.proxy(function () {
                    this._values["hasHover"] = true;
                    this.$_hoverContainer.removeClass("hidden");
                    this._update(false);
                }, this),
                onUnCheck: $.proxy(function () {
                    this._values["hasHover"] = false;
                    this.$_hoverContainer.addClass("hidden");
                    this._update(false);
                }, this),
                appendTo: this.$_designContainer.find(".hover-checkbox-container")
            });

            return this;
        },

        /**
         * Gets family style
         *
         * @return {String}
         *
         * @private
         */
        _getFamilyStyle: function() {
            if (this._familyList[this._values["family"]] === undefined) {
                return this._familyList[0]["style"];
            }

            return this._familyList[this._values["family"]]["style"];
        },

        /**
         * Gets align
         *
         * @return {String}
         *
         * @private
         */
        _getAlign: function() {
            if (this._alignList[this._values["align"]] === undefined) {
                return this._alignList[0]["css"];
            }

            return this._alignList[this._values["align"]]["css"];
        },

        /**
         * Gets transform
         *
         * @return {String}
         *
         * @private
         */
        _getTransform: function(isHover) {
            var transform;
            if (isHover === true) {
                transform = this._values["transformHover"];
            } else {
                transform = this._values["transform"];
            }

            if (this._transformList[transform] === undefined) {
                return this._transformList[0]["css"];
            }

            return this._transformList[transform]["css"];
        },

        /**
         * Gets decoration
         *
         * @return {String}
         *
         * @private
         */
        _getDecoration: function(isHover) {
            var decoration;
            if (isHover === true) {
                decoration = this._values["decorationHover"];
            } else {
                decoration = this._values["decoration"];
            }

            if (this._decorationList[decoration] === undefined) {
                return this._decorationList[0]["css"];
            }

            return this._decorationList[decoration]["css"];
        },

        /**
         * Generates styles
         *
         * @param {boolean} isHover
         *
         * @returns {String}
         *
         * @private
         */
        _generateCss: function(isHover) {
            var css = "";
            var color, isBold, isItalic, letterSpacing, lineHeight;
            if (isHover === true) {
                if (this._values["hasHover"] !== true) {
                    return "";
                }

                color = this._values["colorHover"];
                isBold = this._values["isBoldHover"];
                isItalic = this._values["isItalicHover"];
                letterSpacing = this._values["letterSpacingHover"];
                lineHeight = this._values["lineHeightHover"];
            } else {

                color = this._values["color"];
                isBold = this._values["isBold"];
                isItalic = this._values["isItalic"];
                letterSpacing = this._values["letterSpacing"];
                lineHeight = this._values["lineHeight"];
            }

            css += this._getFamilyStyle();

            if (color) {
                css += "color:" + color + ";";
            }

            if (isItalic === true) {
                css += "font-style: italic;";
            } else {
                css += "font-style: normal;";
            }

            if (isBold === true) {
                css += "font-weight: bold;";
            } else {
                css += "font-weight: normal;";
            }

            css += "text-align:" + this._getAlign() + ";";
            css += "text-decoration:" + this._getDecoration(isHover) + ";";
            css += "text-transform:" + this._getTransform(isHover) + ";";

            css += "letter-spacing:" + letterSpacing + "px;";

            var finalLineHeight = 1.4 + lineHeight / 100;
            css += "line-height:" + finalLineHeight + ";";

            return css;
        }
    };
}(window.jQuery, window.ss);