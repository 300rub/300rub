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
        this._example = null;

        this._size = null;

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
            ._setExample()
            ._setEditors()
            ._setUpdateEvents();
    };

    /**
     * Sets examples
     *
     * @returns {ss.panel.design.text.Editor}
     *
     * @private
     */
    ss.panel.design.text.Editor.prototype._setExample = function () {
        var selector;

        selector = "text-example-" + this.getUniqueId();
        this.getDesignContainer().find(".example").addClass(selector);
        this._example = this.getDesignContainer()
            .find(".styles-example-container")
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
            = this.getDesignContainer().find(".common-container");
        var hoverContainer
            = this.getDesignContainer().find(".hover-container");

        var data = {
            designContainer: this.getDesignContainer(),
            labels: this.getLabels(),
            values: this.getValues(),
            namespace: this.getNamespace(),
            commonContainer: commonContainer,
            hoverContainer: hoverContainer
        };

        this._size = new ss.panel.design.text.Size(data);

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
        this.getDesignContainer()
            .on(
                "update",
                $.proxy(this._onUpdate, this)
            )
            .on(
                "update-text-example",
                $.proxy(this._onUpdateTextExample, this)
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

        if (this.getValue("hasHover") === true) {
            html += this.getSelector() + ":hover{" + this._generateCss(true) + "}";
        }

        html += "</style>";

        this.getStyleContainer().html(html);
    };

    /**
     * On update margin example
     *
     * @private
     */
    ss.panel.design.text.Editor.prototype._onUpdateTextExample
        = function () {
            var css = "";
            var cssHover = "";

            css += this._size.generateCss(false);

            if (this.getValue("hasHover") === true) {
                cssHover += this._size.generateCss(true);
            }

            var selector = "." + this._example.data("selector");
            var html = "<style>";
            html += selector + "{" + css + "}";
            html += selector + ":hover{" + cssHover + "}";
            html += "</style>";
            this._example.html(html);
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

        return data;
    };
}(window.jQuery, window.ss);
