!function ($, TestS) {
    'use strict';

    /**
     * Block editor
     *
     * @param {Object} options
     *
     * @type {TestS.Panel.Design.Block.Editor}
     */
    TestS.Panel.Design.Block.Editor = function (options) {
        this._margin = null;
        this._marginExample = null;

        TestS.Panel.Design.AbstractEditor.call(
            this,
            options
        );

        this.init();
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    TestS.Panel.Design.Block.Editor.prototype
        = Object.create(TestS.Panel.Design.AbstractEditor.prototype);

    /**
     * Constructor
     */
    TestS.Panel.Design.Block.Editor.prototype.constructor
        = TestS.Panel.Design.Block.Editor;

    /**
     * Init
     */
    TestS.Panel.Design.Block.Editor.prototype.init = function () {
        this
            ._setExamples()
            ._setGroupEditors()
            ._setUpdateEvents();
    };

    /**
     * Sets examples
     *
     * @private
     */
    TestS.Panel.Design.Block.Editor.prototype._setExamples = function () {
        var selector;

        selector = "margin-example-" + this.getUniqueId();
        this.getDesignContainer().find(".margin-example").addClass(selector);
        this._marginExample = this.getDesignContainer()
            .find(".margin-container .styles-example-container")
            .attr("data-selector", selector);
    };

    /**
     * Sets group editors
     *
     * @returns {TestS.Panel.Design.Block.Editor}
     *
     * @private
     */
    TestS.Panel.Design.Block.Editor.prototype._setGroupEditors = function () {
        this._margin = new TestS.Panel.Design.Block.Margin(
            {
                designContainer: this.getDesignContainer(),
                labels: this.getLabels(),
                values: this.getValues(),
                namespace: this.getNamespace()
            }
        );

        return this;
    };

    /**
     * Sets update events
     *
     * @returns {TestS.Panel.Design.Block.Editor}
     *
     * @private
     */
    TestS.Panel.Design.Block.Editor.prototype._setUpdateEvents = function () {
        this.getDesignContainer()
            .on(
                "update",
                $.proxy(this._onUpdate, this)
            )
            .on(
                "update-margin-example",
                $.proxy(this._onUpdateMarginExample, this)
            );

        return this;
    };

    /**
     * On update event
     *
     * @private
     */
    TestS.Panel.Design.Block.Editor.prototype._onUpdate = function () {
        var html = "<style>";

        html += this.getSelector() + "{" + this._generateCss(false) + "}";

        html += this.getSelector() + ":hover{" + this._generateCss(true) + "}";

        html += "</style>";

        this.getStyleContainer().html(html);
    };

    /**
     * On update margin example
     *
     * @private
     */
    TestS.Panel.Design.Block.Editor.prototype._onUpdateMarginExample
        = function () {
            var css = this._margin.generateCss(false);
            var cssHover = this._margin.generateCss(true);

            if (this._margin.hasAnimation() === true) {
                var cssAnimation = "";
                cssAnimation += "-webkit-transition:margin .3s;";
                cssAnimation += "-ms-transition:margin .3s;";
                cssAnimation += "-o-transition:margin .3s;";
                cssAnimation += "transition:margin .3s;";

                css += cssAnimation;
                cssHover += cssAnimation;
            }

            var selector = "." + this._marginExample.data("selector");

            var html = "<style>";

            html += selector + "{" + css + "}";

            html += selector + ":hover{" + cssHover + "}";

            html += "</style>";

            this._marginExample.html(html);
        };

    /**
     * Generates CSS
     *
     * @param {boolean} isHover
     *
     * @returns {String}
     *
     * @private
     */
    TestS.Panel.Design.Block.Editor.prototype._generateCss = function (
        isHover
    ) {
        var css = "";

        css += this._margin.generateCss(isHover);

        var animation = [];

        if (this._margin.hasAnimation() === true) {
            animation.push("margin .3s");
        }

        if (animation.length > 0) {
            var animationString = animation.join(",");
            css += "-webkit-transition:" + animationString + ";";
            css += "-ms-transition:" + animationString + ";";
            css += "-o-transition:" + animationString + ";";
            css += "transition:" + animationString + ";";
        }

        return css;
    };
}(window.jQuery, window.TestS);
