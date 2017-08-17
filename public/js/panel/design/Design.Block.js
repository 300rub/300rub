!function ($, TestS) {
    'use strict';

    /**
     * Design block
     *
     * @param {Object} data
     *
     * @type {Object}
     */
    TestS.Panel.Design.Block = function (data) {
        this._data = $.extend({}, data);

        this._selector = "";
        this._labels = {};
        this._values = {};
        this._names = {};

        this._rollbackStyles = "";

        this.$_designContainer = null;
        this.$_styleContainer = null;
        
        this.$_marginExample = null;
        this.$_marginExampleStyles = null;
        this.$_paddingExample = null;
        this.$_paddingExampleStyles = null;
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
    TestS.Panel.Design.Block.prototype = {

        /**
         * List of gradient directions options
         *
         * @var {Object}
         */
        _gradientDirectionList: {
            0: {
                "mozLinear": "left",
                "webkit": "linear, left top, right top",
                "webkitLinear": "left",
                "oLinear": "left",
                "msLinear": "left",
                "linear": "to right",
                "ie": 1
            },
            1: {
                "mozLinear": "top",
                "webkit": "linear, left top, left bottom",
                "webkitLinear": "top",
                "oLinear": "top",
                "msLinear": "top",
                "linear": "to bottom",
                "ie": 0
            },
            2: {
                "mozLinear": "-45deg",
                "webkit": "linear, left top, right bottom",
                "webkitLinear": "-45deg",
                "oLinear": "-45deg",
                "msLinear": "-45deg",
                "linear": "135deg",
                "ie": 1
            },
            3: {
                "mozLinear": "45deg",
                "webkit": "linear, left bottom, right top",
                "webkitLinear": "45deg",
                "oLinear": "45deg",
                "msLinear": "45deg",
                "linear": "45deg",
                "ie": 1
            }
        },

        /**
         * List of border styles
         *
         * @var {Object}
         */
        _borderStyleList: {
            0: "none",
            1: "solid",
            2: "dotted",
            3: "dashed"
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
                ._setMargin()
                ._setPadding()
                ._setBackground()
                ._setBorder();
        },

        /**
         * Sets values
         *
         * @returns {TestS.Panel.Design.Block}
         *
         * @private
         */
        _setValues: function() {
            this._values = $.extend(
                {
                    marginTop: null,
                    marginRight: null,
                    marginBottom: null,
                    marginLeft: null,
                    marginTopHover: null,
                    marginRightHover: null,
                    marginBottomHover: null,
                    marginLeftHover: null,
                    hasMarginHover: null,
                    hasMarginAnimation: null,
                    paddingTop: null,
                    paddingRight: null,
                    paddingBottom: null,
                    paddingLeft: null,
                    paddingTopHover: null,
                    paddingRightHover: null,
                    paddingBottomHover: null,
                    paddingLeftHover: null,
                    hasPaddingHover: null,
                    hasPaddingAnimation: null,
                    backgroundColorFrom: null,
                    backgroundColorFromHover: null,
                    backgroundColorTo: null,
                    backgroundColorToHover: null,
                    gradientDirection: null,
                    gradientDirectionHover: null,
                    hasBackgroundHover: null,
                    hasBackgroundAnimation: null,
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
         * Sets names
         *
         * @returns {TestS.Panel.Design.Block}
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
         * @returns {TestS.Panel.Design.Block}
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
         * @returns {TestS.Panel.Design.Block}
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
         * @returns {TestS.Panel.Design.Block}
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
         * @returns {TestS.Panel.Design.Block}
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
         * @returns {TestS.Panel.Design.Block}
         *
         * @private
         */
        _setDesignContainer: function() {
            this.$_designContainer = TestS.Template.get("design-block-container");
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
         * Sets margin
         *
         * @returns {TestS.Panel.Design.Block}
         *
         * @private
         */
        _setMargin: function() {
            var $container = this.$_designContainer.find(".margin-container");

            if (this._values["marginTop"] === null
                && this._values["marginRight"] === null
                && this._values["marginBottom"] === null
                && this._values["marginLeft"] === null
            ) {
                $container.remove();
                return this;
            }

            this.$_marginExampleStyles = $container.find(".styles-example-container");

            $container.find(".category-title").text(this._getLabel("margin"));

            var uniqueId = TestS.getUniqueId();
            this.$_marginExample = $container.find(".margin-example")
                .addClass("margin-example-" + uniqueId)
                .attr("data-id", uniqueId);

            var $relativeContainer = $container.find(".relative-container");

            if (this._values["marginTop"] !== null) {
                var marginTopHover = null;

                if (this._values["marginTopHover"] !== null) {
                    marginTopHover = new TestS.Form({
                        type: "spinner",
                        value: this._values["marginTopHover"],
                        class: "margin-top-hover",
                        iconBefore: "fa-arrow-right",
                        callback: $.proxy(function (value) {
                            this._values["marginTopHover"] = value;
                            this._updateMargin(false);
                        }, this),
                        appendTo: $relativeContainer
                    });
                }

                new TestS.Form({
                    type: "spinner",
                    value: this._values["marginTop"],
                    class: "margin-top",
                    callback: $.proxy(function (value) {
                        if (this._values["marginTop"] === this._values["marginTopHover"]
                            && marginTopHover !== null
                        ) {
                            this._values["marginTopHover"] = value;
                            marginTopHover.setValue(value);
                        }
                        this._values["marginTop"] = value;
                        this._updateMargin(false);
                    }, this),
                    appendTo: $relativeContainer
                });
            }

            if (this._values["marginRight"] !== null) {
                var marginRightHover = null;

                if (this._values["marginRightHover"] !== null) {
                    marginRightHover = new TestS.Form({
                        type: "spinner",
                        value: this._values["marginRightHover"],
                        class: "margin-right-hover",
                        iconBefore: "fa-arrow-down",
                        callback: $.proxy(function (value) {
                            this._values["marginRightHover"] = value;
                            this._updateMargin(false);
                        }, this),
                        appendTo: $relativeContainer
                    });
                }

                new TestS.Form({
                    type: "spinner",
                    value: this._values["marginRight"],
                    class: "margin-right",
                    callback: $.proxy(function (value) {
                        if (this._values["marginRight"] === this._values["marginRightHover"]
                            && marginRightHover !== null
                        ) {
                            this._values["marginRightHover"] = value;
                            marginRightHover.setValue(value);
                        }
                        this._values["marginRight"] = value;
                        this._updateMargin(false);
                    }, this),
                    appendTo: $relativeContainer
                });
            }

            if (this._values["marginBottom"] !== null) {
                var marginBottomHover = null;

                if (this._values["marginBottomHover"] !== null) {
                    marginBottomHover = new TestS.Form({
                        type: "spinner",
                        value: this._values["marginBottomHover"],
                        class: "margin-bottom-hover",
                        iconBefore: "fa-arrow-right",
                        callback: $.proxy(function (value) {
                            this._values["marginBottomHover"] = value;
                            this._updateMargin(false);
                        }, this),
                        appendTo: $relativeContainer
                    });
                }

                new TestS.Form({
                    type: "spinner",
                    value: this._values["marginBottom"],
                    class: "margin-bottom",
                    callback: $.proxy(function (value) {
                        if (this._values["marginBottom"] === this._values["marginBottomHover"]
                            && marginBottomHover !== null
                        ) {
                            this._values["marginBottomHover"] = value;
                            marginBottomHover.setValue(value);
                        }
                        this._values["marginBottom"] = value;
                        this._updateMargin(false);
                    }, this),
                    appendTo: $relativeContainer
                });
            }

            if (this._values["marginLeft"] !== null) {
                var marginLeftHover = null;

                if (this._values["marginLeftHover"] !== null) {
                    marginLeftHover = new TestS.Form({
                        type: "spinner",
                        value: this._values["marginLeftHover"],
                        class: "margin-left-hover",
                        iconBefore: "fa-arrow-down",
                        callback: $.proxy(function (value) {
                            this._values["marginLeftHover"] = value;
                            this._updateMargin(false);
                        }, this),
                        appendTo: $relativeContainer
                    });
                }

                new TestS.Form({
                    type: "spinner",
                    value: this._values["marginLeft"],
                    class: "margin-left",
                    callback: $.proxy(function (value) {
                        if (this._values["marginLeft"] === this._values["marginLeftHover"]
                            && marginLeftHover !== null
                        ) {
                            this._values["marginLeftHover"] = value;
                            marginLeftHover.setValue(value);
                        }
                        this._values["marginLeft"] = value;
                        this._updateMargin(false);
                    }, this),
                    appendTo: $relativeContainer
                });
            }

            if (this._values["hasMarginHover"] === true) {
                $container.addClass("has-hover");
            }

            if (this._values["hasMarginHover"] !== null) {
                new TestS.Form({
                    type: "checkbox",
                    value: this._values["hasMarginHover"],
                    label: this._getLabel("setHover"),
                    onCheck: $.proxy(function () {
                        this._values["hasMarginHover"] = true;
                        $container.addClass("has-hover");
                        this._updateMargin(false);
                    }, this),
                    onUnCheck: $.proxy(function () {
                        this._values["hasMarginHover"] = false;
                        $container.removeClass("has-hover");
                        this._updateMargin(false);
                    }, this),
                    appendTo: $container
                });
            }

            if (this._values["hasMarginAnimation"] !== null) {
                new TestS.Form({
                    type: "checkbox",
                    value: this._values["hasMarginAnimation"],
                    label: this._getLabel("useAnimation"),
                    class: "has-animation",
                    onCheck: $.proxy(function () {
                        this._values["hasMarginAnimation"] = true;
                        this._updateMargin(false);
                    }, this),
                    onUnCheck: $.proxy(function () {
                        this._values["hasMarginAnimation"] = false;
                        this._updateMargin(false);
                    }, this),
                    appendTo: $container
                });
            }

            this._updateMargin(true);

            return this;
        },

        /**
         * Sets padding
         *
         * @returns {TestS.Panel.Design.Block}
         *
         * @private
         */
        _setPadding: function() {
            var $container = this.$_designContainer.find(".padding-container");

            if (this._values["paddingTop"] === null
                && this._values["paddingRight"] === null
                && this._values["paddingBottom"] === null
                && this._values["paddingLeft"] === null
            ) {
                $container.remove();
                return this;
            }

            this.$_paddingExampleStyles = $container.find(".styles-example-container");

            $container.find(".category-title").text(this._getLabel("padding"));

            var uniqueId = TestS.getUniqueId();
            this.$_paddingExample = $container.find(".padding-example-container")
                .addClass("padding-example-" + uniqueId)
                .attr("data-id", uniqueId);

            var $relativeContainer = $container.find(".relative-container");

            if (this._values["paddingTop"] !== null) {
                var paddingTopHover = null;

                if (this._values["paddingTopHover"] !== null) {
                    paddingTopHover = new TestS.Form({
                        type: "spinner",
                        value: this._values["paddingTopHover"],
                        class: "padding-top-hover",
                        min: 0,
                        iconBefore: "fa-arrow-right",
                        callback: $.proxy(function (value) {
                            this._values["paddingTopHover"] = value;
                            this._updatePadding(false);
                        }, this),
                        appendTo: $relativeContainer
                    });
                }

                new TestS.Form({
                    type: "spinner",
                    value: this._values["paddingTop"],
                    class: "padding-top",
                    min: 0,
                    callback: $.proxy(function (value) {
                        if (this._values["paddingTop"] === this._values["paddingTopHover"]
                            && paddingTopHover !== null
                        ) {
                            this._values["paddingTopHover"] = value;
                            paddingTopHover.setValue(value);
                        }
                        this._values["paddingTop"] = value;
                        this._updatePadding(false);
                    }, this),
                    appendTo: $relativeContainer
                });
            }

            if (this._values["paddingRight"] !== null) {
                var paddingRightHover = null;

                if (this._values["paddingRightHover"] !== null) {
                    paddingRightHover = new TestS.Form({
                        type: "spinner",
                        value: this._values["paddingRightHover"],
                        class: "padding-right-hover",
                        iconBefore: "fa-arrow-down",
                        min: 0,
                        callback: $.proxy(function (value) {
                            this._values["paddingRightHover"] = value;
                            this._updatePadding(false);
                        }, this),
                        appendTo: $relativeContainer
                    });
                }

                new TestS.Form({
                    type: "spinner",
                    value: this._values["paddingRight"],
                    class: "padding-right",
                    min: 0,
                    callback: $.proxy(function (value) {
                        if (this._values["paddingRight"] === this._values["paddingRightHover"]
                            && paddingRightHover !== null
                        ) {
                            this._values["paddingRightHover"] = value;
                            paddingRightHover.setValue(value);
                        }
                        this._values["paddingRight"] = value;
                        this._updatePadding(false);
                    }, this),
                    appendTo: $relativeContainer
                });
            }

            if (this._values["paddingBottom"] !== null) {
                var paddingBottomHover = null;

                if (this._values["paddingBottomHover"] !== null) {
                    paddingBottomHover = new TestS.Form({
                        type: "spinner",
                        value: this._values["paddingBottomHover"],
                        class: "padding-bottom-hover",
                        min: 0,
                        iconBefore: "fa-arrow-right",
                        callback: $.proxy(function (value) {
                            this._values["paddingBottomHover"] = value;
                            this._updatePadding(false);
                        }, this),
                        appendTo: $relativeContainer
                    });
                }

                new TestS.Form({
                    type: "spinner",
                    value: this._values["paddingBottom"],
                    class: "padding-bottom",
                    min: 0,
                    callback: $.proxy(function (value) {
                        if (this._values["paddingBottom"] === this._values["paddingBottomHover"]
                            && paddingBottomHover !== null
                        ) {
                            this._values["paddingBottomHover"] = value;
                            paddingBottomHover.setValue(value);
                        }
                        this._values["paddingBottom"] = value;
                        this._updatePadding(false);
                    }, this),
                    appendTo: $relativeContainer
                });
            }

            if (this._values["paddingLeft"] !== null) {
                var paddingLeftHover = null;

                if (this._values["paddingLeftHover"] !== null) {
                    paddingLeftHover = new TestS.Form({
                        type: "spinner",
                        value: this._values["paddingLeftHover"],
                        class: "padding-left-hover",
                        iconBefore: "fa-arrow-down",
                        min: 0,
                        callback: $.proxy(function (value) {
                            this._values["paddingLeftHover"] = value;
                            this._updatePadding(false);
                        }, this),
                        appendTo: $relativeContainer
                    });
                }

                new TestS.Form({
                    type: "spinner",
                    value: this._values["paddingLeft"],
                    class: "padding-left",
                    min: 0,
                    callback: $.proxy(function (value) {
                        if (this._values["paddingLeft"] === this._values["paddingLeftHover"]
                            && paddingLeftHover !== null
                        ) {
                            this._values["paddingLeftHover"] = value;
                            paddingLeftHover.setValue(value);
                        }
                        this._values["paddingLeft"] = value;
                        this._updatePadding(false);
                    }, this),
                    appendTo: $relativeContainer
                });
            }

            if (this._values["hasPaddingHover"] === true) {
                $container.addClass("has-hover");
            }

            if (this._values["hasPaddingHover"] !== null) {
                new TestS.Form({
                    type: "checkbox",
                    value: this._values["hasPaddingHover"],
                    label: this._getLabel("setHover"),
                    onCheck: $.proxy(function () {
                        this._values["hasPaddingHover"] = true;
                        $container.addClass("has-hover");
                        this._updatePadding(false);
                    }, this),
                    onUnCheck: $.proxy(function () {
                        this._values["hasPaddingHover"] = false;
                        $container.removeClass("has-hover");
                        this._updatePadding(false);
                    }, this),
                    appendTo: $container
                });
            }

            if (this._values["hasPaddingAnimation"] !== null) {
                new TestS.Form({
                    type: "checkbox",
                    value: this._values["hasPaddingAnimation"],
                    label: this._getLabel("useAnimation"),
                    class: "has-animation",
                    onCheck: $.proxy(function () {
                        this._values["hasPaddingAnimation"] = true;
                        this._updatePadding(false);
                    }, this),
                    onUnCheck: $.proxy(function () {
                        this._values["hasPaddingAnimation"] = false;
                        this._updatePadding(false);
                    }, this),
                    appendTo: $container
                });
            }

            this._updatePadding(true);

            return this;
        },

        /**
         * Sets padding
         *
         * @returns {TestS.Panel.Design.Block}
         *
         * @private
         */
        _setBackground: function() {
            var $container = this.$_designContainer.find(".background-container");

            if (this._values["backgroundColorFrom"] === null) {
                $container.remove();
                return this;
            }

            $container.find(".category-title").text(this._getLabel("background"));

            this.$_backgroundExampleStyles = $container.find(".styles-example-container");

            var uniqueId = TestS.getUniqueId();
            this.$_backgroundExample = $container.find(".background-example")
                .addClass("background-example-" + uniqueId)
                .attr("data-id", uniqueId);

            if (this._values["backgroundColorFrom"] !== null) {
                new TestS.Form({
                    type: "color",
                    title: this._getLabel("backgroundColor"),
                    value: this._values["backgroundColorFrom"],
                    callback: $.proxy(function (color) {
                        this._values["backgroundColorFrom"] = color;
                        this._updateBackground(false);
                    }, this),
                    appendTo: $container
                });
            }

            if (this._values["backgroundColorTo"] !== null) {
                new TestS.Form({
                    type: "color",
                    title: this._getLabel("backgroundColor"),
                    value: this._values["backgroundColorTo"],
                    callback: $.proxy(function (color) {
                        this._values["backgroundColorTo"] = color;
                        this._updateBackground(false);
                    }, this),
                    appendTo: $container
                });
            }

            if (this._values["backgroundColorFromHover"] !== null) {
                new TestS.Form({
                    type: "color",
                    title: this._getLabel("backgroundColor"),
                    value: this._values["backgroundColorFromHover"],
                    callback: $.proxy(function (color) {
                        this._values["backgroundColorFromHover"] = color;
                        this._updateBackground(false);
                    }, this),
                    appendTo: $container
                });
            }

            if (this._values["backgroundColorToHover"] !== null) {
                new TestS.Form({
                    type: "color",
                    title: this._getLabel("backgroundColor"),
                    value: this._values["backgroundColorToHover"],
                    callback: $.proxy(function (color) {
                        this._values["backgroundColorToHover"] = color;
                        this._updateBackground(false);
                    }, this),
                    appendTo: $container
                });
            }

            if (this._values["gradientDirection"] !== null) {
                new TestS.Form({
                    type: "radioButtons",
                    value: this._values["gradientDirection"],
                    data: [
                        {
                            value: 0,
                            icon: "fa-long-arrow-right"
                        },
                        {
                            value: 1,
                            icon: "fa-long-arrow-down"
                        },
                        {
                            value: 2,
                            icon: "fa-user"
                        },
                        {
                            value: 3,
                            icon: "fa-lock"
                        }
                    ],
                    onChange: $.proxy(function (value) {
                        this._values["gradientDirection"] = value;
                        this._updateBackground(false);
                    }, this),
                    appendTo: $container
                });
            }

            if (this._values["gradientDirectionHover"] !== null) {
                new TestS.Form({
                    type: "radioButtons",
                    value: this._values["gradientDirectionHover"],
                    data: [
                        {
                            value: 0,
                            icon: "fa-long-arrow-right"
                        },
                        {
                            value: 1,
                            icon: "fa-long-arrow-down"
                        },
                        {
                            value: 2,
                            icon: "fa-user"
                        },
                        {
                            value: 3,
                            icon: "fa-lock"
                        }
                    ],
                    onChange: $.proxy(function (value) {
                        this._values["gradientDirectionHover"] = value;
                        this._updateBackground(false);
                    }, this),
                    appendTo: $container
                });
            }

            new TestS.Form({
                type: "checkbox",
                value: this._values["backgroundColorTo"] || this._values["backgroundColorHover"],
                label: this._getLabel("useGradient"),
                onCheck: $.proxy(function () {
                    //
                }, this),
                onUnCheck: $.proxy(function () {
                    //
                }, this),
                appendTo: $container
            });

            if (this._values["hasBackgroundHover"] !== null) {
                new TestS.Form({
                    type: "checkbox",
                    value: this._values["hasBackgroundHover"],
                    label: this._getLabel("setHover"),
                    onCheck: $.proxy(function () {
                        //

                        this._values["hasBackgroundHover"] = true;
                        this._updateBackground(false);
                    }, this),
                    onUnCheck: $.proxy(function () {
                        //

                        this._values["hasBackgroundHover"] = false;
                        this._updateBackground(false);
                    }, this),
                    appendTo: $container
                });
            }

            if (this._values["hasBackgroundAnimation"] !== null) {
                new TestS.Form({
                    type: "checkbox",
                    value: this._values["hasBackgroundAnimation"],
                    label: this._getLabel("useAnimation"),
                    class: "has-animation",
                    onCheck: $.proxy(function () {
                        this._values["hasBackgroundAnimation"] = true;
                        this._updateBackground(false);
                    }, this),
                    onUnCheck: $.proxy(function () {
                        this._values["hasBackgroundAnimation"] = false;
                        this._updateBackground(false);
                    }, this),
                    appendTo: $container
                });
            }

            this._updateBackground(true);

            return this;
        },

        /**
         * Sets border
         *
         * @returns {TestS.Panel.Design.Block}
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

            $container.find(".category-title").text(this._getLabel("border"));

            var uniqueId = TestS.getUniqueId();
            this.$_borderExample = $container.find(".border-example")
                .addClass("border-example-" + uniqueId)
                .attr("data-id", uniqueId);

            var $relativeContainer = $container.find(".relative-container");

            if (this._values["borderTopLeftRadius"] !== null) {
                var borderTopLeftRadiusHover = null;

                if (this._values["borderTopLeftRadiusHover"] !== null) {
                    borderTopLeftRadiusHover = new TestS.Form({
                        type: "spinner",
                        value: this._values["borderTopLeftRadiusHover"],
                        class: "border-top-left-radius-hover",
                        min: 0,
                        iconBefore: "fa-arrow-right",
                        callback: $.proxy(function (value) {
                            this._values["borderTopLeftRadiusHover"] = value;
                            this._updateBorder(false);
                        }, this),
                        appendTo: $relativeContainer
                    });
                }

                new TestS.Form({
                    type: "spinner",
                    value: this._values["borderTopLeftRadius"],
                    class: "border-top-left-radius",
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
                    borderTopRightRadiusHover = new TestS.Form({
                        type: "spinner",
                        value: this._values["borderTopRightRadiusHover"],
                        class: "border-top-right-radius-hover",
                        min: 0,
                        callback: $.proxy(function (value) {
                            this._values["borderTopRightRadiusHover"] = value;
                            this._updateBorder(false);
                        }, this),
                        appendTo: $relativeContainer
                    });
                }

                new TestS.Form({
                    type: "spinner",
                    value: this._values["borderTopRightRadius"],
                    class: "border-top-right-radius",
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
                    borderBottomRightRadiusHover = new TestS.Form({
                        type: "spinner",
                        value: this._values["borderBottomRightRadiusHover"],
                        class: "border-bottom-right-radius-hover",
                        min: 0,
                        iconBefore: "fa-arrow-right",
                        callback: $.proxy(function (value) {
                            this._values["borderBottomRightRadiusHover"] = value;
                            this._updateBorder(false);
                        }, this),
                        appendTo: $relativeContainer
                    });
                }

                new TestS.Form({
                    type: "spinner",
                    value: this._values["borderBottomRightRadius"],
                    class: "border-bottom-right-radius",
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
                    borderBottomLeftRadiusHover = new TestS.Form({
                        type: "spinner",
                        value: this._values["borderBottomLeftRadiusHover"],
                        class: "border-bottom-left-radius-hover",
                        min: 0,
                        callback: $.proxy(function (value) {
                            this._values["borderBottomLeftRadiusHover"] = value;
                            this._updateBorder(false);
                        }, this),
                        appendTo: $relativeContainer
                    });
                }

                new TestS.Form({
                    type: "spinner",
                    value: this._values["borderBottomLeftRadius"],
                    class: "border-bottom-left-radius",
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
                    borderTopWidthHover = new TestS.Form({
                        type: "spinner",
                        value: this._values["borderTopWidthHover"],
                        class: "border-top-Width-hover",
                        min: 0,
                        iconBefore: "fa-arrow-right",
                        callback: $.proxy(function (value) {
                            this._values["borderTopWidthHover"] = value;
                            this._updateBorder(false);
                        }, this),
                        appendTo: $relativeContainer
                    });
                }

                new TestS.Form({
                    type: "spinner",
                    value: this._values["borderTopWidth"],
                    class: "border-top-width",
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
                    borderRightWidthHover = new TestS.Form({
                        type: "spinner",
                        value: this._values["borderRightWidthHover"],
                        class: "border-right-width-hover",
                        min: 0,
                        iconBefore: "fa-arrow-right",
                        callback: $.proxy(function (value) {
                            this._values["borderRightWidthHover"] = value;
                            this._updateBorder(false);
                        }, this),
                        appendTo: $relativeContainer
                    });
                }

                new TestS.Form({
                    type: "spinner",
                    value: this._values["borderRightWidth"],
                    class: "border-right-width",
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
                    borderBottomWidthHover = new TestS.Form({
                        type: "spinner",
                        value: this._values["borderBottomWidthHover"],
                        class: "border-bottom-width-hover",
                        min: 0,
                        iconBefore: "fa-arrow-right",
                        callback: $.proxy(function (value) {
                            this._values["borderBottomWidthHover"] = value;
                            this._updateBorder(false);
                        }, this),
                        appendTo: $relativeContainer
                    });
                }

                new TestS.Form({
                    type: "spinner",
                    value: this._values["borderBottomWidth"],
                    class: "border-bottom-width",
                    min: 0,
                    callback: $.proxy(function (value) {
                        if (this._values["borderRightWidth"] === this._values["borderBottomWidthHover"]
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
                    borderLeftWidthHover = new TestS.Form({
                        type: "spinner",
                        value: this._values["borderLeftWidthHover"],
                        class: "border-left-width-hover",
                        min: 0,
                        iconBefore: "fa-arrow-right",
                        callback: $.proxy(function (value) {
                            this._values["borderLeftWidthHover"] = value;
                            this._updateBorder(false);
                        }, this),
                        appendTo: $relativeContainer
                    });
                }

                new TestS.Form({
                    type: "spinner",
                    value: this._values["borderLeftWidth"],
                    class: "border-left-width",
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
                new TestS.Form({
                    type: "radioButtons",
                    value: this._values["borderStyle"],
                    data: [
                        {
                            value: 0,
                            class: "none"
                        },
                        {
                            value: 1,
                            class: "solid"
                        },
                        {
                            value: 2,
                            class: "dotted"
                        },
                        {
                            value: 3,
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

            if (this._values["borderStyleHover"] !== null) {
                new TestS.Form({
                    type: "radioButtons",
                    value: this._values["borderStyleHover"],
                    data: [
                        {
                            value: 0,
                            class: "none"
                        },
                        {
                            value: 1,
                            class: "solid"
                        },
                        {
                            value: 2,
                            class: "dotted"
                        },
                        {
                            value: 3,
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

            if (this._values["borderColor"] !== null) {
                new TestS.Form({
                    type: "color",
                    title: this._getLabel("borderColor"),
                    value: this._values["borderColor"],
                    callback: $.proxy(function (color) {
                        this._values["borderColor"] = color;
                        this._updateBorder(false);
                    }, this),
                    appendTo: $container
                });
            }

            if (this._values["borderColorHover"] !== null) {
                new TestS.Form({
                    type: "color",
                    title: this._getLabel("borderColor"),
                    value: this._values["borderColorHover"],
                    callback: $.proxy(function (color) {
                        this._values["borderColorHover"] = color;
                        this._updateBorder(false);
                    }, this),
                    appendTo: $container
                });
            }

            if (this._values["hasBorderHover"] === true) {
                $container.addClass("has-hover");
            }

            if (this._values["hasBorderHover"] !== null) {
                new TestS.Form({
                    type: "checkbox",
                    value: this._values["hasBorderHover"],
                    label: this._getLabel("setHover"),
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

            if (this._values["hasBorderAnimation"] !== null) {
                new TestS.Form({
                    type: "checkbox",
                    value: this._values["hasBorderAnimation"],
                    label: this._getLabel("useAnimation"),
                    class: "has-animation",
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
         * Gets gradient direction
         *
         * @param {boolean} isHover
         *
         * @return {Object}
         */
        _getGradientDirection: function(isHover) {
            var gradientDirection;

            if (isHover === true) {
                gradientDirection = this._values["gradientDirectionHover"];
            } else {
                gradientDirection = this._values["gradientDirection"];
            }

            if (this._gradientDirectionList[gradientDirection] !== undefined) {
                return this._gradientDirectionList[gradientDirection];
            }

            return this._gradientDirectionList[0];
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
         * Generates margin styles
         *
         * @param {boolean} isHover
         *
         * @returns {String}
         *
         * @private
         */
        _generateMarginCss: function(isHover) {
            var marginTop, marginRight, marginBottom, marginLeft;

            if (isHover === true) {
                if (this._values["hasMarginHover"] !== true) {
                    return "";
                }

                marginTop = TestS.getIntVal(this._values["marginTopHover"]);
                marginRight = TestS.getIntVal(this._values["marginRightHover"]);
                marginBottom = TestS.getIntVal(this._values["marginBottomHover"]);
                marginLeft = TestS.getIntVal(this._values["marginLeftHover"]);
            } else {
                marginTop = TestS.getIntVal(this._values["marginTop"]);
                marginRight = TestS.getIntVal(this._values["marginRight"]);
                marginBottom = TestS.getIntVal(this._values["marginBottom"]);
                marginLeft = TestS.getIntVal(this._values["marginLeft"]);
            }

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

            var css = "margin:" + marginTop + " " + marginRight + " " + marginBottom + " " + marginLeft + ";";

            if (this._values["hasMarginHover"] === true
                && this._values["hasMarginAnimation"] === true
            ) {
                css += "-webkit-transition:margin .3s;";
                css += "-ms-transition:margin .3s;";
                css += "-o-transition:margin .3s;";
                css += "transition:margin .3s;";
            }

            return css
        },

        /**
         * Generates padding styles
         *
         * @param {boolean} isHover
         *
         * @returns {String}
         *
         * @private
         */
        _generatePaddingCss: function(isHover) {
            var paddingTop, paddingRight, paddingBottom, paddingLeft;

            if (isHover === true) {
                if (this._values["hasPaddingHover"] !== true) {
                    return "";
                }

                paddingTop = TestS.getIntVal(this._values["paddingTopHover"]);
                paddingRight = TestS.getIntVal(this._values["paddingRightHover"]);
                paddingBottom = TestS.getIntVal(this._values["paddingBottomHover"]);
                paddingLeft = TestS.getIntVal(this._values["paddingLeftHover"]);
            } else {
                paddingTop = TestS.getIntVal(this._values["paddingTop"]);
                paddingRight = TestS.getIntVal(this._values["paddingRight"]);
                paddingBottom = TestS.getIntVal(this._values["paddingBottom"]);
                paddingLeft = TestS.getIntVal(this._values["paddingLeft"]);
            }

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

            var css = "padding:" + paddingTop + " " + paddingRight + " " + paddingBottom + " " + paddingLeft + ";";

            if (this._values["hasPaddingHover"] === true
                && this._values["hasPaddingAnimation"] === true
            ) {
                css += "-webkit-transition:padding .3s;";
                css += "-ms-transition:padding .3s;";
                css += "-o-transition:padding .3s;";
                css += "transition:padding .3s;";
            }

            return css
        },

        /**
         * Generates background styles
         *
         * @param {boolean} isHover
         *
         * @returns {String}
         *
         * @private
         */
        _generateBackgroundCss: function(isHover) {
            var css = "",
                backgroundColorFrom = "",
                backgroundColorTo = "";

            if (isHover === true) {
                backgroundColorFrom = this._values["backgroundColorFromHover"];
                backgroundColorTo = this._values["backgroundColorToHover"];
            } else {
                backgroundColorFrom = this._values["backgroundColorFrom"];
                backgroundColorTo = this._values["backgroundColorTo"];
            }

            if (backgroundColorFrom === null) {
                backgroundColorFrom = "";
            }

            if (backgroundColorTo === null) {
                backgroundColorTo = "";
            }

            var isSimpleBackground = false;

            if (backgroundColorFrom !== ""
                && backgroundColorTo === ""
            ) {
                css += "background-color: " + backgroundColorFrom + ";";
                isSimpleBackground = true;
            } else if (backgroundColorFrom === ""
                && backgroundColorTo !== ""
            ) {
                css += "background-color: " + backgroundColorTo + ";";
                isSimpleBackground = true;
            } else if (backgroundColorFrom !== ""
                && backgroundColorTo !== ""
            ) {
                var gradientDirection = this._getGradientDirection(isHover);

                css += "background: " + backgroundColorFrom + ";";
                css += "background: -moz-linear-gradient("
                    + gradientDirection["mozLinear"]
                    + ", "
                    + backgroundColorFrom
                    + " 0%, "
                    + backgroundColorTo
                    + " 100%);";

                css += "background: -webkit-gradient("
                    + gradientDirection["webkit"]
                    + ", color-stop(0%, "
                    + backgroundColorFrom
                    + "), color-stop(100%, "
                    + backgroundColorTo
                    + "));";

                css += "background: -webkit-linear-gradient("
                    + gradientDirection["webkitLinear"]
                    + ", "
                    + backgroundColorFrom
                    + " 0%, "
                    + backgroundColorTo
                    + " 100%);";

                css += "background: -o-linear-gradient("
                    + gradientDirection["oLinear"]
                    + ", "
                    + backgroundColorFrom
                    + " 0%, "
                    + backgroundColorTo
                    + " 100%);";

                css += "background: -ms-linear-gradient("
                    + gradientDirection["msLinear"]
                    + ", "
                    + backgroundColorFrom
                    + " 0%, "
                    + backgroundColorTo
                    + " 100%);";

                css += "background: linear-gradient("
                    + gradientDirection["linear"]
                    + ", "
                    + backgroundColorFrom
                    + " 0%, "
                    + backgroundColorTo
                    + " 100%);";

                css += "filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='"
                    + backgroundColorFrom
                    + "', endColorstr='"
                    + backgroundColorTo
                    + "',GradientType="
                    + gradientDirection["ie"]
                    + ");";
            }

            if (isSimpleBackground === true
                && this._values["hasBackgroundHover"] === true
                && this._values["hasBackgroundAnimation"] === true
            ) {
                css += "-webkit-transition:padding .3s;";
                css += "-ms-transition:background-color .3s;";
                css += "-o-transition:background-color .3s;";
                css += "transition:background-color .3s;";
            }

            return css
        },

        /**
         * Generates border styles
         *
         * @param {boolean} isHover
         *
         * @returns {String}
         *
         * @private
         */
        _generateBorderCss: function(isHover) {
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

                borderTopLeftRadius = TestS.getIntVal(this._values["borderTopLeftRadiusHover"]);
                borderTopRightRadius = TestS.getIntVal(this._values["borderTopRightRadiusHover"]);
                borderBottomRightRadius = TestS.getIntVal(this._values["borderBottomRightRadiusHover"]);
                borderBottomLeftRadius = TestS.getIntVal(this._values["borderBottomLeftRadiusHover"]);

                borderTopWidth = TestS.getIntVal(this._values["borderTopWidthHover"]);
                borderRightWidth = TestS.getIntVal(this._values["borderRightWidthHover"]);
                borderBottomWidth = TestS.getIntVal(this._values["borderBottomWidthHover"]);
                borderLeftWidth = TestS.getIntVal(this._values["borderLeftWidthHover"]);

                borderColor = this._values["borderColorHover"];
            } else {
                borderTopLeftRadius = TestS.getIntVal(this._values["borderTopLeftRadius"]);
                borderTopRightRadius = TestS.getIntVal(this._values["borderTopRightRadius"]);
                borderBottomRightRadius = TestS.getIntVal(this._values["borderBottomRightRadius"]);
                borderBottomLeftRadius = TestS.getIntVal(this._values["borderBottomLeftRadius"]);

                borderTopWidth = TestS.getIntVal(this._values["borderTopWidth"]);
                borderRightWidth = TestS.getIntVal(this._values["borderRightWidth"]);
                borderBottomWidth = TestS.getIntVal(this._values["borderBottomWidth"]);
                borderLeftWidth = TestS.getIntVal(this._values["borderLeftWidth"]);

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

            if (borderColor !== "") {
                css += "border-color:" + borderColor + ";";
            }

            var borderStyle = this._getBorderStyle(isHover);
            css += "border-style:" + borderStyle + ";";

            if (this._values["hasBorderHover"] === true
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
            return this._generateMarginCss(isHover)
                + this._generatePaddingCss(isHover)
                + this._generateBackgroundCss(isHover)
                + this._generateBorderCss(isHover);
        },

        /**
         * Updates margin
         *
         * @param {boolean} isOnlyExample
         *
         * @private
         */
        _updateMargin: function(isOnlyExample) {
            var id = this.$_marginExample.data("id");

            var css = "<style>";

            css += ".margin-example-"
                + id
                + "{"
                + this._generateMarginCss(false)
                + "}";

            css += ".margin-example-"
                + id
                + ":hover{"
                + this._generateMarginCss(true)
                +"}";

            css +="</style>";

            this.$_marginExampleStyles.html(css);

            if (isOnlyExample !== true) {
                this._update();
            }
        },

        /**
         * Updates padding
         *
         * @param {boolean} isOnlyExample
         *
         * @private
         */
        _updatePadding: function(isOnlyExample) {
            var id = this.$_paddingExample.data("id");

            var css = "<style>";

            css += ".padding-example-"
                + id
                + "{"
                + this._generatePaddingCss(false)
                + "}";

            css += ".padding-example-"
                + id
                + ":hover{"
                + this._generatePaddingCss(true)
                +"}";

            css += "</style>";

            this.$_paddingExampleStyles.html(css);

            if (isOnlyExample !== true) {
                this._update();
            }
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
        },

        /**
         * Updates all styles
         *
         * @private
         */
        _update: function() {
            var css = "<style>";

            css += this._selector
                + "{"
                + this._generateCss(false)
                + "}";

            css += this._selector
                + ":hover{"
                + this._generateCss(true)
                + "}";

            css += "</style>";

            this.$_styleContainer.html(css);
        }
    };
}(window.jQuery, window.TestS);