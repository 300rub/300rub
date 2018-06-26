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

        this._padding = null;
        this._paddingExample = null;

        this._background = null;
        this._backgroundExample = null;

        this._border = null;
        this._borderExample = null;

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

        selector = "padding-example-" + this.getUniqueId();
        this.getDesignContainer()
            .find(".padding-example-container")
            .addClass(selector);
        this._paddingExample = this.getDesignContainer()
            .find(".padding-container .styles-example-container")
            .attr("data-selector", selector);

        selector = "background-example-" + this.getUniqueId();
        this.getDesignContainer()
            .find(".background-example")
            .addClass(selector);
        this._backgroundExample = this.getDesignContainer()
            .find(".background-container .styles-example-container")
            .attr("data-selector", selector);

        selector = "border-example-" + this.getUniqueId();
        this.getDesignContainer().find(".border-example").addClass(selector);
        this._borderExample = this.getDesignContainer()
            .find(".border-container .styles-example-container")
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

        this._padding = new ss.panel.design.block.Padding(
            {
                designContainer: this.getDesignContainer(),
                labels: this.getLabels(),
                values: this.getValues(),
                namespace: this.getNamespace()
            }
        );

        this._background = new ss.panel.design.block.Background(
            {
                designContainer: this.getDesignContainer(),
                labels: this.getLabels(),
                values: this.getValues(),
                namespace: this.getNamespace()
            }
        );

        this._border = new ss.panel.design.block.Border(
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
            )
            .on(
                "update-padding-example",
                $.proxy(this._onUpdatePaddingExample, this)
            ).on(
                "update-background-example",
                $.proxy(this._onUpdateBackgroundExample, this)
            ).on(
                "update-border-example",
                $.proxy(this._onUpdateBorderExample, this)
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
     * On update padding example
     *
     * @private
     */
    ss.panel.design.block.Editor.prototype._onUpdatePaddingExample
        = function () {
            var css = this._padding.generateCss(false);
            var cssHover = this._padding.generateCss(true);

            if (this._padding.hasAnimation() === true) {
                var cssAnimation = "";
                cssAnimation += "-webkit-transition:padding .3s;";
                cssAnimation += "-ms-transition:padding .3s;";
                cssAnimation += "-o-transition:padding .3s;";
                cssAnimation += "transition:padding .3s;";

                css += cssAnimation;
                cssHover += cssAnimation;
            }

            var selector = "." + this._paddingExample.data("selector");

            var html = "<style>";

            html += selector + "{" + css + "}";

            html += selector + ":hover{" + cssHover + "}";

            html += "</style>";

            this._paddingExample.html(html);
        };

    /**
     * On update background example
     *
     * @private
     */
    ss.panel.design.block.Editor.prototype._onUpdateBackgroundExample
        = function () {
            var css = this._background.generateCss(false);
            var cssHover = this._background.generateCss(true);

            if (this._background.hasAnimation() === true) {
                var cssAnimation = "";
                cssAnimation += "-webkit-transition:background-color .3s;";
                cssAnimation += "-ms-transition:background-color .3s;";
                cssAnimation += "-o-transition:background-color .3s;";
                cssAnimation += "transition:background-color .3s;";

                css += cssAnimation;
                cssHover += cssAnimation;
            }

            var selector = "." + this._backgroundExample.data("selector");

            var html = "<style>";

            html += selector + "{" + css + "}";

            html += selector + ":hover{" + cssHover + "}";

            html += "</style>";

            this._backgroundExample.html(html);
        };

    /**
     * On update border example
     *
     * @private
     */
    ss.panel.design.block.Editor.prototype._onUpdateBorderExample
        = function () {
            var css = this._border.generateCss(false);
            var cssHover = this._border.generateCss(true);

            if (this._border.hasAnimation() === true) {
                var cssAnimation = "";
                cssAnimation += "-webkit-transition:border-radius .3s,";
                cssAnimation += "border-width .3s,border-color .3s;";
                cssAnimation += "-ms-transition:border-radius .3s,";
                cssAnimation += "border-width .3s,border-color .3s;";
                cssAnimation += "-o-transition:border-radius .3s,";
                cssAnimation += "border-width .3s,border-color .3s;";
                cssAnimation += "transition:border-radius .3s,";
                cssAnimation += "border-width .3s,border-color .3s;";
                css += cssAnimation;
                cssHover += cssAnimation;
            }

            var selector = "." + this._borderExample.data("selector");

            var html = "<style>";

            html += selector + "{" + css + "}";

            html += selector + ":hover{" + cssHover + "}";

            html += "</style>";

            this._borderExample.html(html);
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
        css += this._padding.generateCss(isHover);
        css += this._background.generateCss(isHover);
        css += this._border.generateCss(isHover);

        var animation = [];

        if (this._margin.hasAnimation() === true) {
            animation.push("margin .3s");
        }

        if (this._padding.hasAnimation() === true) {
            animation.push("padding .3s");
        }

        if (this._background.hasAnimation() === true) {
            animation.push("background-color .3s");
        }

        if (this._border.hasAnimation() === true) {
            animation.push("border-radius .3s");
            animation.push("border-width .3s");
            animation.push("border-color .3s");
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
        $.extend(data, this._padding.getData());
        $.extend(data, this._background.getData());
        $.extend(data, this._border.getData());

        return data;
    };
}(window.jQuery, window.ss);