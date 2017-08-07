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

        this._namespace = "";
        this._selector = "";
        this._labels = {};

        this.$_styleContainer = null;
        this.$_designContainer = null;

        this.$_marginContainer = null;
        this.$_marginExample = null;
        this._marginTop = null;
        this._marginRight = null;
        this._marginBottom = null;
        this._marginLeft = null;
        this._marginTopHover = null;
        this._marginRightHover = null;
        this._marginBottomHover = null;
        this._marginLeftHover = null;

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
                ._setNamespace()
                ._setSelector()
                ._setStyleContainer()
                ._setLabels()
                ._setValues()
                ._setDesignContainer()
                ._setMargin();
        },

        _setNamespace: function() {
            if (this._data["namespace"] !== undefined) {
                this._namespace = this._data["namespace"];
            }

            return this;
        },

        _setSelector: function() {
            if (this._data["selector"] !== undefined) {
                this._selector = this._data["selector"];
            }

            return this;
        },

        _setStyleContainer: function() {
            if (this._data["containerId"] !== undefined) {
                this.$_styleContainer = $("#" + this._data["containerId"]);
            }

            return this;
        },

        _setLabels: function() {
            if ($.type(this._data["labels"]) === "object") {
                this._labels = this._data["labels"];
            }

            return this;
        },

        _getLabel: function(key) {
            if (this._labels[key] !== undefined) {
                return this._labels[key];
            }

            return "";
        },

        _setDesignContainer: function() {
            this.$_designContainer = TestS.Template.get("design-block-container");
            return this;
        },

        getDesignContainer: function() {
            return this.$_designContainer;
        },

        _setValues: function() {
            var values = this._data["values"];

            if ($.type(values) !== "object") {
                return this;
            }

            if (values["marginTop"] !== undefined) {
                this._marginTop = parseInt(values["marginTop"]);
            }

            if (values["marginRight"] !== undefined) {
                this._marginRight = parseInt(values["marginRight"]);
            }

            if (values["marginBottom"] !== undefined) {
                this._marginBottom = parseInt(values["marginBottom"]);
            }

            if (values["marginLeft"] !== undefined) {
                this._marginLeft = parseInt(values["marginLeft"]);
            }

            return this;
        },

        _setMargin: function() {
            this.$_marginContainer = this.$_designContainer.find(".margin-container");

            if (this._marginTop === null
                && this._marginRight === null
                && this._marginBottom === null
                && this._marginLeft === null
            ) {
                this.$_marginContainer.remove();
                return this;
            }

            var uniqueId = TestS.getUniqueId();
            this.$_marginExample = this.$_marginContainer.find(".margin-example")
                .addClass("margin-example-" + uniqueId)
                .attr("data-id", uniqueId);

            this.$_marginContainer.find(".category-title").text(this._getLabel("margin"));
            this.$_marginContainer.find(".has-margin-hover-label").text(this._getLabel("setHover"));
            this.$_marginContainer.find(".has-margin-animation-label").text(this._getLabel("useAnimation"));

            this
                ._setSpinner("margin-top-container", "marginTop", "_updateMargin")
                ._setSpinner("margin-right-container", "marginRight", "_updateMargin")
                ._setSpinner("margin-bottom-container", "marginBottom", "_updateMargin")
                ._setSpinner("margin-left-container", "marginLeft", "_updateMargin")
            ;

            return this;
        },

        _setSpinner: function(containerClassName, name, callbackName) {
            var t = this;
            var privateName = "_" + name;

            var $container = t.$_designContainer.find("." + containerClassName);
            if (t[privateName] === null) {
                $container.remove();
                return this;
            }

            $container.find("input")
                .val(t[privateName])
                .attr("name", t._getName(name))
                .on("keyup", function() {
                    t[privateName] = parseInt($(this).val());
                    t[callbackName]();
                })
                .spinner({
                    spin: function (event, ui) {
                        t[privateName] = parseInt(ui.value);
                        t[callbackName]();
                    },
                    icons: {
                        up: "fa fa-chevron-up",
                        down: "fa fa-chevron-down"
                    }
                });

            return this;
        },

        _updateMargin: function() {
            var $example = this.$_marginContainer.find(".styles-example-container");

            var css = "<style>"
                + ".margin-example-"
                + this.$_marginExample.data("id")
                + "{"
                + this._generateMarginCss()
                + "}</style>";

            $example.html(css);

            this._update();
        },

        _update: function() {
            var css = "<style>"
                + this._selector
                + "{"
                + this._generateCss()
                + "}</style>";

            this.$_styleContainer.html(css);
        },

        _generateMarginCss: function() {
            var marginTop = TestS.getIntVal(this._marginTop);
            var marginRight = TestS.getIntVal(this._marginRight);
            var marginBottom = TestS.getIntVal(this._marginBottom);
            var marginLeft = TestS.getIntVal(this._marginLeft);

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

        _generateCss: function() {
            return this._generateMarginCss();
        },

        _getName: function(name) {
            return this._namespace + "." + name;
        }
    };
}(window.jQuery, window.TestS);