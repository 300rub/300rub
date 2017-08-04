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

        this.$_designContainer = null;

        this.$_marginContainer = null;
        this.$_marginExample = null;
        this._marginTop = 0;
        this._marginRight = 0;
        this._marginBottom = 0;
        this._marginLeft = 0;

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
                ._setDesignContainer()
                ._setValues()
                ._setMargin();
        },

        _setNamespace: function() {
            if (this._data["namespace"] !== undefined) {
                this._namespace = this._data["namespace"];
            }

            return this;
        },

        _setDesignContainer: function() {
            this.$_designContainer = TestS.Template.get("design-block-container");
            return this;
        },

        _setValues: function() {
            var values = this._data["values"];
            if ($.type("values") !== "object") {
                return this;
            }

            if (values["marginTop"] !== undefined) {
                this._marginTop = parseInt(values["marginTop"]);
            }

            return this;
        },

        _setMargin: function() {
            var t = this;

            var uniqueId = TestS.getUniqueId();

            t.$_marginContainer = this.$_designContainer.find(".margin-container");
            t.$_marginExample = t.$_marginContainer.find(".margin-example")
                .addClass("margin-example-" + uniqueId)
                .attr("data-id", uniqueId);

            var instances = {
                marginTop: "margin-top",
                marginRight: "margin-right",
                marginBottom: "margin-bottom",
                marginLeft: "margin-left"
            };

            $.each(instances, function(name, className) {
                var privateName = "_" + name;

                t.$_marginContainer.find("." + className)
                    .val(t[privateName])
                    .attr("name", t._getName(name))
                    .on("keyup", function() {
                        t[privateName]= parseInt($(this).val());
                        t._updateMargin();
                    })
                    .spinner({
                        spin: function (event, ui) {
                            t[privateName] = parseInt(ui.value);
                            t._updateMargin();
                        }
                    });
            });

            return this;
        },

        _updateMargin: function() {
            var $example = this.$_marginContainer.find(".styles-example-container");

            var css = "<style>"
                + ".margin-example-"
                + $example.data("id")
                + "{"
                + this._generateMarginCss()
                + "}</style>";

            $example.html(css);

            this._update();
        },

        _update: function() {
            var css = "<style>" + this._generateCss() + "</style>";
        },

        _generateMarginCss: function() {
            var marginTop = this._marginTop;
            var marginRight = this._marginRight;
            var marginBottom = this._marginBottom;
            var marginLeft = this._marginLeft;

            if (marginTop === 0
                && marginRight === 0
                && marginBottom === 0
                && marginLeft === 0
            ) {
                return "";
            }

            if (marginTop > 0) {
                marginTop += "px";
            }

            if (marginRight > 0) {
                marginRight += "px";
            }

            if (marginBottom > 0) {
                marginBottom += "px";
            }

            if (marginLeft > 0) {
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