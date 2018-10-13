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
        this._sample = null;

        this._size = null;
        this._family = null;
        this._color = null;
        this._align = null;
        this._italic = null;
        this._bold = null;
        this._lineHeight = null;
        this._decoration = null;
        this._letterSpacing = null;
        this._transform = null;
        this._hover = null;

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
        this
            ._setSample()
            ._setEditors()
            ._setUpdateEvents();
    };

    /**
     * Sets samples
     *
     * @returns {ss.panel.design.text.Editor}
     *
     * @private
     */
    ss.panel.design.text.Editor.prototype._setSample = function () {
        var selector;

        selector = "text-sample-" + this.getUniqueId();
        this.getEditorContainer().find(".sample").addClass(selector);
        this._sample = this.getEditorContainer()
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
    ss.panel.design.text.Editor.prototype._setEditors = function () {
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

        this._size = new ss.panel.design.text.Size(data);
        this._family = new ss.panel.design.text.Family(data);
        this._color = new ss.panel.design.text.Color(data);
        this._align = new ss.panel.design.text.Align(data);
        this._italic = new ss.panel.design.text.Italic(data);
        this._bold = new ss.panel.design.text.Bold(data);
        this._lineHeight = new ss.panel.design.text.LineHeight(data);
        this._decoration = new ss.panel.design.text.Decoration(data);
        this._letterSpacing = new ss.panel.design.text.LetterSpacing(data);
        this._transform = new ss.panel.design.text.Transform(data);
        this._hover = new ss.panel.design.text.Hover(data);

        return this;
    };

    /**
     * Sets update events
     *
     * @returns {ss.panel.design.text.Editor}
     *
     * @private
     */
    ss.panel.design.text.Editor.prototype._setUpdateEvents = function () {
        this.getEditorContainer()
            .on(
                "update",
                $.proxy(this._onUpdate, this)
            )
            .on(
                "update-text-sample",
                $.proxy(this._onUpdateTextSample, this)
            );

        return this;
    };

    /**
     * On update event
     *
     * @private
     */
    ss.panel.design.text.Editor.prototype._onUpdate = function () {
        var html = "<style>";

        html += this.getSelector() + "{" + this._generateCss(false) + "}";

        if (this._hover.getHasHover() === true) {
            html += this.getSelector();
            html += ":hover{" + this._generateCss(true) + "}";
        }

        html += "</style>";

        this.getStyleContainer().html(html);
    };

    /**
     * On update margin sample
     *
     * @private
     */
    ss.panel.design.text.Editor.prototype._onUpdateTextSample
        = function () {
            var css = "";
            var cssHover = "";

            css += this._size.generateCss(false);
            css += this._family.generateCss();
            css += this._align.generateCss();
            css += this._color.generateCss(false);
            css += this._italic.generateCss(false);
            css += this._bold.generateCss(false);
            css += this._lineHeight.generateCss(false);
            css += this._decoration.generateCss(false);
            css += this._letterSpacing.generateCss(false);
            css += this._transform.generateCss(false);

            if (this._hover.getHasHover() === true) {
                cssHover += this._size.generateCss(true);
                cssHover += this._color.generateCss(true);
                cssHover += this._italic.generateCss(true);
                cssHover += this._bold.generateCss(true);
                cssHover += this._lineHeight.generateCss(true);
                cssHover += this._decoration.generateCss(true);
                cssHover += this._letterSpacing.generateCss(true);
                cssHover += this._transform.generateCss(true);
            }

            var selector = "." + this._sample.data("selector");
            var html = "<style>";
            html += selector + "{" + css + "}";
            html += selector + ":hover{" + cssHover + "}";
            html += "</style>";
            this._sample.html(html);
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
    ss.panel.design.text.Editor.prototype._generateCss = function (
        isHover
    ) {
        var css = "";

        css += this._size.generateCss(isHover);
        css += this._family.generateCss();
        css += this._color.generateCss(isHover);
        css += this._align.generateCss();
        css += this._italic.generateCss(isHover);
        css += this._bold.generateCss(isHover);
        css += this._lineHeight.generateCss(isHover);
        css += this._decoration.generateCss(isHover);
        css += this._letterSpacing.generateCss(isHover);
        css += this._transform.generateCss(isHover);

        return css;
    };

    /**
     * Gets data
     *
     * @returns {Object}
     */
    ss.panel.design.text.Editor.prototype.getData = function () {
        var data = {};

        $.extend(data, this._size.getData());
        $.extend(data, this._family.getData());
        $.extend(data, this._color.getData());
        $.extend(data, this._align.getData());
        $.extend(data, this._italic.getData());
        $.extend(data, this._bold.getData());
        $.extend(data, this._lineHeight.getData());
        $.extend(data, this._decoration.getData());
        $.extend(data, this._letterSpacing.getData());
        $.extend(data, this._transform.getData());
        $.extend(data, this._hover.getData());

        return data;
    };
}(window.jQuery, window.ss);
