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
        
        //this.$_example = null;
        //this.$_styles = null;

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
                ._setSize()
                ._setFamily();
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
                    lineHeightHover: null
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
                        this._updateCss(false);
                    }, this),
                    appendTo: this.$_designContainer
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
                    this._updateCss(false);
                }, this),
                appendTo: this.$_designContainer
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
                    this._updateCss(false);
                }, this),
                appendTo: this.$_designContainer
            });

            return this;
        },

        /**
         * Updates CSS
         *
         * @private
         */
        _updateCss: function() {

        }
    };
}(window.jQuery, window.TestS);