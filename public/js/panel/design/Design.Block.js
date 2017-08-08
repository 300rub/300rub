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

        this._rollback = "";

        this.$_designContainer = null;
        this.$_styleContainer = null;
        
        this.$_marginExample = null;
        this.$_marginExampleStyles = null;

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
                ._setMargin();
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
                    marginLeftHover: null
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
            this._rollback = this.$_styleContainer.html();

            return this;
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

            new TestS.Form({
                type: "checkbox",
                value: this._values["hasMarginHover"],
                label: this._getLabel("setHover"),
                onCheck: function() {
                    $container.addClass("has-hover");
                },
                onUnCheck: function() {
                    $container.removeClass("has-hover");
                },
                appendTo: $container
            });

            new TestS.Form({
                type: "checkbox",
                value: this._values["hasMarginAnimation"],
                label: this._getLabel("useAnimation"),
                class: "has-animation",
                appendTo: $container
            });

            this._updateMargin(true);

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
                marginTop = TestS.getIntVal(this._values["marginTopHover"]);
                marginRight = TestS.getIntVal(this._values["marginTopHover"]);
                marginBottom = TestS.getIntVal(this._values["marginTopHover"]);
                marginLeft = TestS.getIntVal(this._values["marginTopHover"]);
            } else {
                marginTop = TestS.getIntVal(this._values["marginTop"]);
                marginRight = TestS.getIntVal(this._values["marginRight"]);
                marginBottom = TestS.getIntVal(this._values["marginBottom"]);
                marginLeft = TestS.getIntVal(this._values["marginLeft"]);
            }

            if (marginTop === 0
                && marginRight === 0
                && marginBottom === 0
                && marginLeft === 0
            ) {
                return "";
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

            return "margin:" + marginTop + " " + marginRight + " " + marginBottom + " " + marginLeft + ";";
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