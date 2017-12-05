!function ($, TestS) {
    'use strict';

    /**
     * Design block
     *
     * @param {Object} data
     *
     * @type {Object}
     */
    TestS.Panel.Design.Text = function (data) {
        this._data = $.extend({}, data);

        this._selector = "";
        this._labels = {};
        this._values = {};
        this._names = {};

        this._rollbackStyles = "";

        this.$_designContainer = null;
        this.$_styleContainer = null;
        this.$_commonContainer = null;
        this.$_hoverContainer = null;

        this.$_example = null;
        this.$_exampleStyles = null;

        this.init();
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    TestS.Panel.Design.Text.prototype = {

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
                ._setSelector()
                ._setStyleContainer()
                ._setRollback()
                ._setLabels()
                ._setValues()
                ._setNames()
                ._setDesignContainer()
                ._setCommonContainer()
                ._setHoverContainer()
                ._setExample()
                ._setExampleStyles()
                ._update(true)
                ._setSize()
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
         * @returns {TestS.Panel.Design.Text}
         *
         * @private
         */
        _setValues: function() {
            this._values = $.extend(
                {
                    size: null,
                    sizeHover: null,
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
         * Sets names
         *
         * @returns {TestS.Panel.Design.Text}
         *
         * @private
         */
        _setNames: function() {
            var namespace = "";
            if (this._data["namespace"] !== undefined) {
                namespace = this._data["namespace"];
            }

            $.each(this._values, $.proxy(function(name) {
                if (namespace !== "") {
                    this._names[name] = namespace + "." + name;
                } else {
                    this._names[name] = name;
                }
            }, this));

            return this;
        },

        /**
         * Sets selector
         *
         * @returns {TestS.Panel.Design.Text}
         *
         * @private
         */
        _setSelector: function() {
            if (this._data["selector"] !== undefined) {
                this._selector = this._data["selector"];
            }

            return this;
        },

        /**
         * Sets style container
         *
         * @returns {TestS.Panel.Design.Text}
         *
         * @private
         */
        _setStyleContainer: function() {
            if (this._data["id"] !== undefined) {
                this.$_styleContainer = $("#" + this._data["id"]);
            }

            return this;
        },

        /**
         * Sets rollback styles
         *
         * @returns {TestS.Panel.Design.Text}
         *
         * @private
         */
        _setRollback: function() {
            this._rollbackStyles = this.$_styleContainer.html();

            return this;
        },

        /**
         * Rollbacks
         */
        rollback: function() {
            this.$_styleContainer.html(this._rollbackStyles);
        },

        /**
         * Sets labels
         *
         * @returns {TestS.Panel.Design.Text}
         *
         * @private
         */
        _setLabels: function() {
            if ($.type(this._data["labels"]) === "object") {
                this._labels = this._data["labels"];
            }

            return this;
        },

        /**
         * Gets label
         *
         * @param {String} key
         *
         * @returns {String}
         *
         * @private
         */
        _getLabel: function(key) {
            if (this._labels[key] !== undefined) {
                return this._labels[key];
            }

            return "";
        },

        /**
         * Sets design container
         *
         * @returns {TestS.Panel.Design.Text}
         *
         * @private
         */
        _setDesignContainer: function() {
            this.$_designContainer = TestS.Template.get("design-text-container");
            return this;
        },

        /**
         * Sets common container
         *
         * @returns {TestS.Panel.Design.Text}
         *
         * @private
         */
        _setCommonContainer: function() {
            this.$_commonContainer = this.$_designContainer.find(".common-container");
            return this;
        },

        /**
         * Sets hover container
         *
         * @returns {TestS.Panel.Design.Text}
         *
         * @private
         */
        _setHoverContainer: function() {
            this.$_hoverContainer = this.$_designContainer.find(".hover-container");
            return this;
        },

        /**
         * Sets example
         *
         * @returns {TestS.Panel.Design.Text}
         *
         * @private
         */
        _setExample: function() {
            var uniqueId = TestS.getUniqueId();

            this.$_example = this.$_designContainer.find(".example")
                .addClass("example-" + uniqueId)
                .attr("data-id", uniqueId)
                .text(this._getLabel("textExample"));

            return this;
        },

        /**
         * Sets styles
         *
         * @returns {TestS.Panel.Design.Text}
         *
         * @private
         */
        _setExampleStyles: function() {
            this.$_exampleStyles = this.$_designContainer.find(".styles-example-container");
            return this;
        },

        /**
         * Gets design container
         *
         * @returns {Object}
         */
        getDesignContainer: function() {
            return this.$_designContainer;
        },

        /**
         * Sets size
         *
         * @returns {TestS.Panel.Design.Text}
         *
         * @private
         */
        _setSize: function() {
            if (this._values["size"] === null) {
                return this;
            }

            var sizeHover = null;

            if (this._values["sizeHover"] !== null) {
                sizeHover = new TestS.Form({
                    type: "spinner",
                    value: this._values["sizeHover"],
                    class: "size-hover",
                    min: 0,
                    callback: $.proxy(function (value) {
                        this._values["sizeHover"] = value;
                        this._update(false);
                    }, this),
                    appendTo: this.$_hoverContainer
                });
            }

            new TestS.Form({
                type: "spinner",
                value: this._values["size"],
                class: "size",
                min: 0,
                callback: $.proxy(function (value) {
                    if (this._values["size"] === this._values["sizeHover"]
                        && sizeHover !== null
                    ) {
                        this._values["sizeHover"] = value;
                        sizeHover.setValue(value);
                    }
                    this._values["size"] = value;
                    this._update(false);
                }, this),
                appendTo: this.$_commonContainer
            });

            return this;
        },

        /**
         * Sets family
         *
         * @returns {TestS.Panel.Design.Text}
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

            new TestS.Form({
                type: "select",
                list: list,
                value: this._values["family"],
                class: "family",
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
         * @returns {TestS.Panel.Design.Text}
         *
         * @private
         */
        _setColor: function() {
            if (this._values["color"] !== null) {
                new TestS.Form({
                    type: "color",
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
                new TestS.Form({
                    type: "color",
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
         * @returns {TestS.Panel.Design.Text}
         *
         * @private
         */
        _setIsItalic: function() {
            var hoverForm = null;

            if (this._values["isItalicHover"] !== null) {
                hoverForm = new TestS.Form({
                    type: "checkboxButton",
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
                new TestS.Form({
                    type: "checkboxButton",
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
         * @returns {TestS.Panel.Design.Text}
         *
         * @private
         */
        _setIsBold: function() {
            var hoverForm = null;

            if (this._values["isBoldHover"] !== null) {
                hoverForm = new TestS.Form({
                    type: "checkboxButton",
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
                new TestS.Form({
                    type: "checkboxButton",
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
         * @returns {TestS.Panel.Design.Text}
         *
         * @private
         */
        _setAlign: function() {
            if (this._values["align"] === null) {
                return this;
            }

            new TestS.Form({
                type: "radioButtons",
                value: this._values["align"],
                data: this._alignList,
                class: "align",
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
         * @returns {TestS.Panel.Design.Text}
         *
         * @private
         */
        _setDecoration: function() {
            var hoverForm = null;
            if (this._values["decorationHover"] !== null) {
                hoverForm = new TestS.Form({
                    type: "radioButtons",
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
                new TestS.Form({
                    type: "radioButtons",
                    value: this._values["decoration"],
                    data: this._decorationList,
                    class: "decoration",
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
         * @returns {TestS.Panel.Design.Text}
         *
         * @private
         */
        _setTransform: function() {
            var hoverForm = null;
            if (this._values["transformHover"] !== null) {
                hoverForm = new TestS.Form({
                    type: "radioButtons",
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
                new TestS.Form({
                    type: "radioButtons",
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
         * @returns {TestS.Panel.Design.Text}
         *
         * @private
         */
        _setLetterSpacing: function() {
            var hoverForm = null;

            if (this._values["letterSpacingHover"] !== null) {
                hoverForm = new TestS.Form({
                    type: "spinner",
                    value: this._values["letterSpacingHover"],
                    callback: $.proxy(function (value) {
                        this._values["letterSpacingHover"] = value;
                        this._update(false);
                    }, this),
                    appendTo: this.$_hoverContainer
                });
            }

            if (this._values["letterSpacing"] !== null) {
                new TestS.Form({
                    type: "spinner",
                    value: this._values["letterSpacing"],
                    class: "letter-spacing",
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
         * @returns {TestS.Panel.Design.Text}
         *
         * @private
         */
        _setLineHeight: function() {
            var hoverForm = null;

            if (this._values["lineHeightHover"] !== null) {
                hoverForm = new TestS.Form({
                    type: "spinner",
                    value: this._values["lineHeightHover"],
                    callback: $.proxy(function (value) {
                        this._values["lineHeightHover"] = value;
                        this._update(false);
                    }, this),
                    appendTo: this.$_hoverContainer
                });
            }

            if (this._values["lineHeight"] !== null) {
                new TestS.Form({
                    type: "spinner",
                    value: this._values["lineHeight"],
                    class: "line-height",
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
         * @returns {TestS.Panel.Design.Text}
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

            new TestS.Form({
                type: "checkboxOnOff",
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
            var size, color, isBold, isItalic, letterSpacing, lineHeight;
            if (isHover === true) {
                if (this._values["hasHover"] !== true) {
                    return "";
                }

                size = this._values["sizeHover"];
                color = this._values["colorHover"];
                isBold = this._values["isBoldHover"];
                isItalic = this._values["isItalicHover"];
                letterSpacing = this._values["letterSpacingHover"];
                lineHeight = this._values["lineHeightHover"];
            } else {
                size = this._values["size"];
                color = this._values["color"];
                isBold = this._values["isBold"];
                isItalic = this._values["isItalic"];
                letterSpacing = this._values["letterSpacing"];
                lineHeight = this._values["lineHeight"];
            }

            css += "font-size:" + size + "px;";

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
        },

        /**
         * Updates CSS
         *
         * @param {boolean} isOnlyExample
         *
         * @private
         */
        _update: function(isOnlyExample) {
            var css;
            var generatedCss = this._generateCss(false);
            var generatedHoverCss = this._generateCss(true);
            var id = this.$_example.data("id");

            css = "<style>";

            css += ".example-"
                + id
                + "{"
                + generatedCss
                + "}";

            css += ".example-"
                + id
                + ":hover{"
                + generatedHoverCss
                +"}";

            css += "</style>";

            this.$_exampleStyles.html(css);

            if (isOnlyExample !== true) {
                css = "<style>";

                css += this._selector
                    + "{"
                    + generatedCss
                    + "}";

                css += this._selector
                    + ":hover{"
                    + generatedHoverCss
                    + "}";

                css += "</style>";

                this.$_styleContainer.html(css);
            }

            return this;
        },

        /**
         * Gets data
         *
         * @returns {Object}
         */
        getData: function() {
            var data = {};

            $.each(this._values, $.proxy(function(key, value) {
                if (this._names[key] !== undefined) {
                    data[this._names[key]] = value;
                }
            }, this));

            return data;
        }
    };
}(window.jQuery, window.TestS);