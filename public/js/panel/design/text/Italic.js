!function ($, ss) {
    'use strict';

    /**
     * Text italic
     *
     * @param {Object} options
     *
     * @type {ss.panel.design.text.Italic}
     */
    ss.panel.design.text.Italic = function (options) {
        this._isItalic = null;
        this._isItalicHover = null;

        this._commonContainer = options.commonContainer;
        this._hoverContainer = options.hoverContainer;

        ss.panel.design.AbstractGroup.call(
            this,
            {
                designContainer: options.designContainer,
                updateExampleEvent: "update-text-example",
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
    ss.panel.design.text.Italic.prototype
        = Object.create(ss.panel.design.AbstractGroup.prototype);

    /**
     * Constructor
     */
    ss.panel.design.text.Italic.prototype.constructor
        = ss.panel.design.text.Italic;

    /**
     * Fields
     *
     * @type {Array}
     */
    ss.panel.design.text.Italic.prototype.fields = [
        "isItalic",
        "isItalicHover"
    ];

    /**
     * Init
     */
    ss.panel.design.text.Italic.prototype.init = function () {
        this._setItalic();
    };

    /**
     * Sets italic
     *
     * @returns {ss.panel.design.Text}
     *
     * @private
     */
    ss.panel.design.text.Italic.prototype._setItalic = function () {
        var hoverForm = null;

        var onCheckHover = $.proxy(
            function () {
                this._isItalicHover = true;
                this.update();
            },
            this
        );
        var onUnCheckHover = $.proxy(
            function () {
                this._isItalicHover = false;
                this.update();
            },
            this
        );

        if (this._isItalicHover !== null) {
            hoverForm = new ss.forms.CheckboxButton(
                {
                    value: this._isItalicHover,
                    icon: "fa-italic",
                    appendTo: this._hoverContainer,
                    onCheck: onCheckHover,
                    onUnCheck: onUnCheckHover
                }
            );
        }

        var onCheck = $.proxy(
            function () {
                if (hoverForm !== null
                    && this._isItalic === this._isItalicHover
                ) {
                    hoverForm.getInstance().attr("checked", true);
                    this._isItalicHover = true;
                }

                this._isItalic = true;
                this.update();
            },
            this
        );

        var onUnCheck = $.proxy(
            function () {
                if (hoverForm !== null
                    && this._isItalic === this._isItalicHover
                ) {
                    hoverForm.getInstance().attr("checked", false);
                    this._isItalicHover = false;
                }

                this._isItalic = false;
                this.update();
            },
            this
        );

        if (this._isItalic !== null) {
            new ss.forms.CheckboxButton(
                {
                    value: this._isItalic,
                    icon: "fa-italic",
                    appendTo: this._commonContainer,
                    onCheck: onCheck,
                    onUnCheck: onUnCheck
                }
            );
        }

        return this;
    };

    /**
     * Generates styles
     *
     * @param {boolean} isHover
     *
     * @returns {String}
     */
    ss.panel.design.text.Italic.prototype.generateCss = function (isHover) {
        if (isHover === true) {
            return "font-style: italic;";
        }

        return "font-style: normal;";
    };
}(window.jQuery, window.ss);
