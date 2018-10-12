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
        this._marginSample = null;

        this._padding = null;
        this._paddingSample = null;

        this._background = null;
        this._backgroundSample = null;

        this._border = null;
        this._borderSample = null;

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
            ._setSamples()
            ._setGroupEditors()
            ._setUpdateEvents();
    };

    /**
     * Sets samples
     *
     * @returns {ss.panel.design.block.Editor}
     *
     * @private
     */
    ss.panel.design.block.Editor.prototype._setSamples = function () {
        var selector;

        selector = "margin-sample-" + this.getUniqueId();
        this.getEditorContainer().find(".margin-sample").addClass(selector);
        this._marginSample = this.getEditorContainer()
            .find(".margin-container .styles-sample-container")
            .attr("data-selector", selector);

        selector = "padding-sample-" + this.getUniqueId();
        this.getEditorContainer()
            .find(".padding-sample-container")
            .addClass(selector);
        this._paddingSample = this.getEditorContainer()
            .find(".padding-container .styles-sample-container")
            .attr("data-selector", selector);

        selector = "background-sample-" + this.getUniqueId();
        this.getEditorContainer()
            .find(".background-sample")
            .addClass(selector);
        this._backgroundSample = this.getEditorContainer()
            .find(".background-container .styles-sample-container")
            .attr("data-selector", selector);

        selector = "border-sample-" + this.getUniqueId();
        this.getEditorContainer().find(".border-sample").addClass(selector);
        this._borderSample = this.getEditorContainer()
            .find(".border-container .styles-sample-container")
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
                editorContainer: this.getEditorContainer(),
                labels: this.getLabels(),
                values: this.getValues(),
                namespace: this.getNamespace()
            }
        );

        this._padding = new ss.panel.design.block.Padding(
            {
                editorContainer: this.getEditorContainer(),
                labels: this.getLabels(),
                values: this.getValues(),
                namespace: this.getNamespace()
            }
        );

        this._background = new ss.panel.design.block.Background(
            {
                editorContainer: this.getEditorContainer(),
                labels: this.getLabels(),
                values: this.getValues(),
                namespace: this.getNamespace()
            }
        );

        this._border = new ss.panel.design.block.Border(
            {
                editorContainer: this.getEditorContainer(),
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
        this.getEditorContainer()
            .on(
                "update",
                $.proxy(this._onUpdate, this)
            )
            .on(
                "update-margin-sample",
                $.proxy(this._onUpdateMarginSample, this)
            )
            .on(
                "update-padding-sample",
                $.proxy(this._onUpdatePaddingSample, this)
            ).on(
                "update-background-sample",
                $.proxy(this._onUpdateBackgroundSample, this)
            ).on(
                "update-border-sample",
                $.proxy(this._onUpdateBorderSample, this)
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
     * On update margin sample
     *
     * @private
     */
    ss.panel.design.block.Editor.prototype._onUpdateMarginSample
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

            var selector = "." + this._marginSample.data("selector");

            var html = "<style>";

            html += selector + "{" + css + "}";

            html += selector + ":hover{" + cssHover + "}";

            html += "</style>";

            this._marginSample.html(html);
        };

    /**
     * On update padding sample
     *
     * @private
     */
    ss.panel.design.block.Editor.prototype._onUpdatePaddingSample
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

            var selector = "." + this._paddingSample.data("selector");

            var html = "<style>";

            html += selector + "{" + css + "}";

            html += selector + ":hover{" + cssHover + "}";

            html += "</style>";

            this._paddingSample.html(html);
        };

    /**
     * On update background sample
     *
     * @private
     */
    ss.panel.design.block.Editor.prototype._onUpdateBackgroundSample
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

            var selector = "." + this._backgroundSample.data("selector");

            var html = "<style>";

            html += selector + "{" + css + "}";

            html += selector + ":hover{" + cssHover + "}";

            html += "</style>";

            this._backgroundSample.html(html);
        };

    /**
     * On update border sample
     *
     * @private
     */
    ss.panel.design.block.Editor.prototype._onUpdateBorderSample
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

            var selector = "." + this._borderSample.data("selector");

            var html = "<style>";

            html += selector + "{" + css + "}";

            html += selector + ":hover{" + cssHover + "}";

            html += "</style>";

            this._borderSample.html(html);
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
