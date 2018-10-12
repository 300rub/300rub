!function ($, ss) {
    'use strict';

    /**
     * Text hasHover
     *
     * @param {Object} options
     *
     * @type {ss.panel.design.text.Hover}
     */
    ss.panel.design.text.Hover = function (options) {
        this._hasHover = null;

        this._hoverContainer = options.hoverContainer;

        ss.panel.design.AbstractGroup.call(
            this,
            {
                editorContainer: options.editorContainer,
                updateSampleEvent: "update-text-sample",
                labels: options.labels,
                namespace: options.namespace,
                values: options.values
            }
        );

        this.init();
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    ss.panel.design.text.Hover.prototype
        = Object.create(ss.panel.design.AbstractGroup.prototype);

    /**
     * Constructor
     */
    ss.panel.design.text.Hover.prototype.constructor
        = ss.panel.design.text.Hover;

    /**
     * Fields
     *
     * @type {Array}
     */
    ss.panel.design.text.Hover.prototype.fields = [
        "hasHover"
    ];

    /**
     * Init
     */
    ss.panel.design.text.Hover.prototype.init = function () {
        this._setHover();
    };

    /**
     * Sets hasHover
     *
     * @returns {ss.panel.design.text.Hover}
     *
     * @private
     */
    ss.panel.design.text.Hover.prototype._setHover = function () {
        if (this._hasHover === null) {
            this._hoverContainer.addClass("hidden");
            return this;
        }

        if (this._hasHover === true) {
            this._hoverContainer.removeClass("hidden");
        } else {
            this._hoverContainer.addClass("hidden");
        }

        var onCheck = $.proxy(
            function () {
                this._hasHover = true;
                this._hoverContainer.removeClass("hidden");
                this.update();
            },
            this
        );

        var onUnCheck = $.proxy(
            function () {
                this._hasHover = false;
                this._hoverContainer.addClass("hidden");
                this.update();
            },
            this
        );

        var checkboxContainer = this.getEditorContainer()
            .find(".hover-checkbox-container");

        new ss.forms.CheckboxOnOff(
            {
                value: this._hasHover,
                label: this.getLabel("mouseHoverEffect"),
                appendTo: checkboxContainer,
                onCheck: onCheck,
                onUnCheck: onUnCheck
            }
        );

        return this;
    };

    /**
     * Gets hasHover value
     *
     * @returns {boolean}
     */
    ss.panel.design.text.Hover.prototype.hasHover = function () {
        return this._hasHover;
    };
}(window.jQuery, window.ss);
