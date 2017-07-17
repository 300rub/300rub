!function ($, TestS) {
    'use strict';

    /**
     * Design block
     *
     * @param {Object} options
     *
     * @type {Object}
     */
    TestS.Panel.Design.Block = function (options) {
        this._options = options;
        this.init();
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    TestS.Panel.Design.Block.prototype = {

        /**
         * Options
         *
         * @type {Object}
         */
        _options: {},

        /**
         * Design container
         *
         * @type {Object}
         */
        $_designContainer: null,

        /**
         * Block
         *
         * @type {Object}
         */
        $_block: null,

        /**
         * Margin example container
         *
         * @type {Object}
         */
        $_marginExample: null,

        $_marginTop: null,

        /**
         * Init
         */
        init: function () {
            this.$_designContainer = TestS.Template.get("design-block-container");
            this.$_block = this._options.block;

            this._setMargin();
        },

        /**
         * Sets margin
         *
         * @returns {TestS.Panel.Design.Block}
         *
         * @private
         */
        _setMargin: function() {
            this.$_marginExample = this.$_designContainer.find(".margin-example-inside");

            this._setMarginTop();

            return this;
        },

        /**
         * Sets margin-top
         *
         * @returns {TestS.Panel.Design.Block}
         *
         * @private
         */
        _setMarginTop: function() {
            var t = this;

            this.$_marginTop = this.$_designContainer
                .find("margin-top")
                .val(this._options.data.marginTop)
                .attr("name", this._options.namespace + "." + "marginTop")
                .on("keyup", function() {
                    t._updateMarginTop($(this).val());
                })
                .spinner({
                    min: -300,
                    spin: $.proxy(function (event, ui) {
                        t._updateMarginTop(ui.value);
                    }, this)
                });

            return this;
        },

        /**
         * Updates margin-top
         *
         * @param value
         *
         * @returns {TestS.Panel.Design.Block}
         *
         * @private
         */
        _updateMarginTop: function(value) {
            var result = parseInt(value) + "px !important";

            this.$_marginExample.css("margin-top", result);
            this.$_block.css("margin-top", result);

            return this;
        },

        /**
         * Gets design container
         *
         * @returns {Object}
         */
        get: function() {
            return this.$_designContainer;
        }
    };
}(window.jQuery, window.TestS);