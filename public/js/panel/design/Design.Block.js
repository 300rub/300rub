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

        this.init();
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    TestS.Panel.Design.Block.prototype = {

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
                ._setPadding();
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
                    hasPaddingAnimation: null
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
            this.$_paddingExample = $container.find(".padding-example")
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
         * Updates margin
         *
         * @param {boolean} isOnlyExample
         *
         * @private
         */
        _updateMargin: function(isOnlyExample) {
            var id = this.$_marginExample.data("id");

            var css = "<style>"
                + ".margin-example-"
                + id
                + "{"
                + this._generateMarginCss(false)
                + "}.margin-example-"
                + id
                + ":hover {"
                + this._generateMarginCss(true)
                +"}</style>";

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

            var css = "<style>"
                + ".padding-example-"
                + id
                + "{"
                + this._generatePaddingCss(false)
                + "}.padding-example-"
                + id
                + ":hover {"
                + this._generatePaddingCss(true)
                +"}</style>";

            this.$_paddingExampleStyles.html(css);

            if (isOnlyExample !== true) {
                this._update();
            }
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
         * Updates all styles
         *
         * @private
         */
        _update: function() {
            var css = "<style>"
                + this._selector
                + "{"
                + this._generateCss(false)
                + "}"
                + this._selector
                + ":hover{"
                + this._generateCss(true)
                + "}</style>";

            this.$_styleContainer.html(css);
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
            return this._generateMarginCss(isHover);
        }
    };
}(window.jQuery, window.TestS);