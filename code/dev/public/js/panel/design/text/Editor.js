!function ($, ss) {
    'use strict';

    /**
     * Text editor
     *
     * @param {Object} options
     *
     * @type {ss.panel.design.text.Editor}
     */
    ss.panel.design.text.Editor = function (options) {


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
    ss.panel.design.text.Editor.prototype
        = Object.create(ss.panel.design.AbstractEditor.prototype);

    /**
     * Constructor
     */
    ss.panel.design.text.Editor.prototype.constructor
        = ss.panel.design.text.Editor;

    /**
     * Init
     */
    ss.panel.design.text.Editor.prototype.init = function () {

    };

    /**
     * Sets samples
     *
     * @returns {ss.panel.design.text.Editor}
     *
     * @private
     */
    ss.panel.design.text.Editor.prototype.setSample = function () {
        var selector;

        selector = "text-sample-" + this.getUniqueId();
        this.getEditorContainer().find(".sample").addClass(selector);
        this.sample = this.getEditorContainer()
            .find(".styles-sample-container")
            .attr("data-selector", selector);

        return this;
    };

    /**
     * Sets group editors
     *
     * @returns {ss.panel.design.text.Editor}
     *
     * @private
     */
    ss.panel.design.text.Editor.prototype.setEditors = function () {
        var commonContainer
            = this.getEditorContainer().find(".common-container");
        var hoverContainer
            = this.getEditorContainer().find(".hover-container");

        var data = {
            editorContainer: this.getEditorContainer(),
            labels: this.getLabels(),
            values: this.getValues(),
            namespace: this.getNamespace(),
            commonContainer: commonContainer,
            hoverContainer: hoverContainer
        };

        this.size = new ss.panel.design.text.Size(data);
        this.family = new ss.panel.design.text.Family(data);
        this.color = new ss.panel.design.text.Color(data);
        this.align = new ss.panel.design.text.Align(data);
        this.italic = new ss.panel.design.text.Italic(data);
        this.bold = new ss.panel.design.text.Bold(data);
        this.lineHeight = new ss.panel.design.text.LineHeight(data);
        this.decoration = new ss.panel.design.text.Decoration(data);
        this.letterSpacing = new ss.panel.design.text.LetterSpacing(data);
        this.transform = new ss.panel.design.text.Transform(data);
        this.hover = new ss.panel.design.text.Hover(data);

        return this;
    };

    /**
     * Sets update events
     *
     * @returns {ss.panel.design.text.Editor}
     *
     * @private
     */
    ss.panel.design.text.Editor.prototype.setUpdateEvents = function () {
        this.getEditorContainer()
            .on(
                "update",
                $.proxy(this.onUpdate, this)
            )
            .on(
                "update-text-sample",
                $.proxy(this.onUpdateTextSample, this)
            );

        return this;
    };

    /**
     * On update event
     *
     * @private
     */
    ss.panel.design.text.Editor.prototype.onUpdate = function () {
        var html = "<style>";

        html += this.getSelector() + "{" + this.generateCss(false) + "}";

        if (this.hover.getHasHover() === true) {
            html += this.getSelector();
            html += ":hover{" + this.generateCss(true) + "}";
        }

        html += "</style>";

        this.getStyleContainer().html(html);
    };

    /**
     * On update margin sample
     *
     * @private
     */
    ss.panel.design.text.Editor.prototype.onUpdateTextSample
        = function () {
            var css = "";
            var cssHover = "";

            css += this.size.generateCss(false);
            css += this.family.generateCss();
            css += this.align.generateCss();
            css += this.color.generateCss(false);
            css += this.italic.generateCss(false);
            css += this.bold.generateCss(false);
            css += this.lineHeight.generateCss(false);
            css += this.decoration.generateCss(false);
            css += this.letterSpacing.generateCss(false);
            css += this.transform.generateCss(false);

            if (this.hover.getHasHover() === true) {
                cssHover += this.size.generateCss(true);
                cssHover += this.color.generateCss(true);
                cssHover += this.italic.generateCss(true);
                cssHover += this.bold.generateCss(true);
                cssHover += this.lineHeight.generateCss(true);
                cssHover += this.decoration.generateCss(true);
                cssHover += this.letterSpacing.generateCss(true);
                cssHover += this.transform.generateCss(true);
            }

            var selector = "." + this.sample.data("selector");
            var html = "<style>";
            html += selector + "{" + css + "}";
            html += selector + ":hover{" + cssHover + "}";
            html += "</style>";
            this.sample.html(html);
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
    ss.panel.design.text.Editor.prototype.generateCss = function (
        isHover
    ) {
        var css = "";

        css += this.size.generateCss(isHover);
        css += this.family.generateCss();
        css += this.color.generateCss(isHover);
        css += this.align.generateCss();
        css += this.italic.generateCss(isHover);
        css += this.bold.generateCss(isHover);
        css += this.lineHeight.generateCss(isHover);
        css += this.decoration.generateCss(isHover);
        css += this.letterSpacing.generateCss(isHover);
        css += this.transform.generateCss(isHover);

        return css;
    };

    /**
     * Gets data
     *
     * @returns {Object}
     */
    ss.panel.design.text.Editor.prototype.getData = function () {
        var data = {};

        $.extend(data, this.size.getData());
        $.extend(data, this.family.getData());
        $.extend(data, this.color.getData());
        $.extend(data, this.align.getData());
        $.extend(data, this.italic.getData());
        $.extend(data, this.bold.getData());
        $.extend(data, this.lineHeight.getData());
        $.extend(data, this.decoration.getData());
        $.extend(data, this.letterSpacing.getData());
        $.extend(data, this.transform.getData());
        $.extend(data, this.hover.getData());

        return data;
    };
}(window.jQuery, window.ss);
