!function ($, ss) {
    'use strict';

    /**
     * Block editor
     *
     * @param {Object} options
     *
     * @type {ss.panel.design.block.Editor}
     */
    ss.panel.design.block.Editor = function (options) {
        this._margin = null;
        this._marginExample = null;

        ss.panel.design.AbstractEditor.call(
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
    ss.panel.design.block.Editor.prototype
        = Object.create(ss.panel.design.AbstractEditor.prototype);

    /**
     * Constructor
     */
    ss.panel.design.block.Editor.prototype.constructor
        = ss.panel.design.block.Editor;

    /**
     * Init
     */
    ss.panel.design.block.Editor.prototype.init = function () {
        this
            ._setExamples()
            ._setGroupEditors()
            ._setUpdateEvents();
    };

    /**
     * Sets examples
     *
     * @returns {ss.panel.design.block.Editor}
     *
     * @private
     */
    ss.panel.design.block.Editor.prototype._setExamples = function () {
        var selector;

        selector = "margin-example-" + this.getUniqueId();
        this.getDesignContainer().find(".margin-example").addClass(selector);
        this._marginExample = this.getDesignContainer()
            .find(".margin-container .styles-example-container")
            .attr("data-selector", selector);

        return this;
    };

    /**
     * Sets group editors
     *
     * @returns {ss.panel.design.block.Editor}
     *
     * @private
     */
    ss.panel.design.block.Editor.prototype._setGroupEditors = function () {
        this._margin = new ss.panel.design.block.Margin(
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
     * @returns {ss.panel.design.block.Editor}
     *
     * @private
     */
    ss.panel.design.block.Editor.prototype._setUpdateEvents = function () {
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
    ss.panel.design.block.Editor.prototype._onUpdate = function () {
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
    ss.panel.design.block.Editor.prototype._onUpdateMarginExample
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
    ss.panel.design.block.Editor.prototype._generateCss = function (
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

    /**
     * Gets data
     *
     * @returns {Object}
     */
    ss.panel.design.block.Editor.prototype.getData = function () {
        var data = {};

        $.extend(data, this._margin.getData());

        return data;
    };
}(window.jQuery, window.ss);
