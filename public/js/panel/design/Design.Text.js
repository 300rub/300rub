!function ($, ss) {
    'use strict';

    /**
     * Prototype
     *
     * @type {Object}
     */
    ss.panel.design.Text.prototype = {

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
         * Sets
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
            var letterSpacing, lineHeight;
            if (isHover === true) {
                if (this._values["hasHover"] !== true) {
                    return "";
                }
                
                letterSpacing = this._values["letterSpacingHover"];
                lineHeight = this._values["lineHeightHover"];
            } else {
                letterSpacing = this._values["letterSpacing"];
                lineHeight = this._values["lineHeight"];
            }

            css += "text-decoration:" + this._getDecoration(isHover) + ";";
            css += "text-transform:" + this._getTransform(isHover) + ";";

            css += "letter-spacing:" + letterSpacing + "px;";

            var finalLineHeight = 1.4 + lineHeight / 100;
            css += "line-height:" + finalLineHeight + ";";

            return css;
        }
    };
}(window.jQuery, window.ss);