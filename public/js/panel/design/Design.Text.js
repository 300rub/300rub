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
        this.$_styles = null;

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
                class: "font-family-myrad",
                name: "MyriadPro"
            },
            1: {
                class: "font-family-arial",
                name: "Arial, Helvetica"
            },
            2: {
                class: "font-family-arial-black",
                name: "Arial Black, Gadget"
            },
            3 : {
                class: "font-family-comic-sans",
                name: "Comic Sans MS"
            },
            4: {
                class: "font-family-courier-new",
                name: "Courier New"
            },
            5: {
                class: "font-family-georgia",
                name: "Georgia"
            },
            6: {
                class: "font-family-impact",
                name: "Impact, Charcoal"
            },
            7: {
                class: "font-family-monaco",
                name: "Lucida Console, Monaco"
            },
            8: {
                class: "font-family-lucida-grande",
                name: "Lucida Sans Unicode"
            },
            9: {
                class: "font-family-palatino",
                name: "Palatino"
            },
            10: {
                class: "font-family-tahoma",
                name: "Tahoma, Geneva"
            },
            11: {
                class: "font-family-times",
                name: "Times New Roman, Times"
            },
            12: {
                class: "font-family-helvetica",
                name: "Trebuchet MS, Helvetica"
            },
            13: {
                class: "font-family-verdana",
                name: "Verdana, Geneva"
            },
            14: {
                class: "font-family-geneva",
                name: "MS Sans Serif, Geneva"
            },
            15: {
                class: "font-family-ms-serif",
                name: "MS Serif, New York"
            }
        },

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
                ._setStyles()
                ._update(true)
                ._setSize()
                ._setFamily()
                ._setColor()
                ._setIsItalic()
                ._setIsBold()
                ._setAlign()
                ._setDecoration();
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
            if (this._data["containerId"] !== undefined) {
                this.$_styleContainer = $("#" + this._data["containerId"]);
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
            this.$_hoverContainer = this.$_designContainer.find("hover-container");
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
            this.$_example = this.$_designContainer.find(".example");
            return this;
        },

        /**
         * Sets styles
         *
         * @returns {TestS.Panel.Design.Text}
         *
         * @private
         */
        _setStyles: function() {
            this.$_styles = this.$_designContainer.find(".styles-example-container");
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
                    class: data["class"]
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
            var $colorContainer = this.$_commonContainer.find(".common-color-container");
            var $colorHoverContainer = $container.find(".color-hover-container");

            if (this._values["color"] !== null) {
                this._setColorPicker(
                    $colorContainer.find(".color"),
                    this._getLabel("color"),
                    $.proxy(function(color) {
                        this._values["color"] = color;
                        this._update(false);
                    }, this)
                );
            } else {
                $colorContainer.remove();
            }

            if (this._values["colorHover"] !== null) {
                this._setColorPicker(
                    $colorHoverContainer.find(".color-hover"),
                    this._getLabel("colorHover"),
                    $.proxy(function(color) {
                        this._values["colorHover"] = color;
                        this._update(false);
                    }, this)
                );
            } else {
                $colorHoverContainer.remove();
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
                data: [
                    {
                        value: 0,
                        icon: "fa-align-left"
                    },
                    {
                        value: 1,
                        icon: "fa-align-center"
                    },
                    {
                        value: 2,
                        icon: "fa-align-right"
                    },
                    {
                        value: 3,
                        icon: "fa-align-justify"
                    }
                ],
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
                    data: [
                        {
                            value: 0,
                            class: "none",
                            label: "A"
                        },
                        {
                            value: 1,
                            class: "underline",
                            label: "U"
                        },
                        {
                            value: 2,
                            class: "line-through",
                            label: "T"
                        },
                        {
                            value: 3,
                            class: "overline",
                            label: "O"
                        }
                    ],
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
                    data: [
                        {
                            value: 0,
                            class: "none",
                            label: "A"
                        },
                        {
                            value: 1,
                            class: "underline",
                            label: "U"
                        },
                        {
                            value: 2,
                            class: "line-through",
                            label: "T"
                        },
                        {
                            value: 3,
                            class: "overline",
                            label: "O"
                        }
                    ],
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
                    appendTo: this.$_hoverContainer
                });
            }

            return this;
        },

        /**
         * Sets color picker
         *
         * @param {Object}   $object
         * @param {String}   title
         * @param {function} callback
         *
         * @returns {TestS.Panel.Design.Text}
         *
         * @private
         */
        _setColorPicker: function ($object, title, callback) {
            $object.colorpicker({
                parts: 'full',
                alpha: true,
                showOn: 'button',
                buttonColorize: true,
                buttonClass: "color-button",
                buttonImage: "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7",
                buttonImageOnly: true,
                title: title,
                colorFormat: "RGBA",
                select: function (event, data) {
                    callback(data.formatted);
                }
            });

            return this;
        },

        /**
         * Updates CSS
         *
         * @private
         */
        _update: function() {
            return this;
        }
    };
}(window.jQuery, window.TestS);