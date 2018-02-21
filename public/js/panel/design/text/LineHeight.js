!function ($, ss) {
    'use strict';

    /**
     * Text line-height
     *
     * @param {Object} options
     *
     * @type {ss.panel.design.text.LineHeight}
     */
    ss.panel.design.text.LineHeight = function (options) {
        this._lineHeight = null;
        this._lineHeightHover = null;

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
    ss.panel.design.text.LineHeight.prototype
        = Object.create(ss.panel.design.AbstractGroup.prototype);

    /**
     * Constructor
     */
    ss.panel.design.text.LineHeight.prototype.constructor
        = ss.panel.design.text.LineHeight;

    /**
     * Fields
     *
     * @type {Array}
     */
    ss.panel.design.text.LineHeight.prototype.fields = [
        "lineHeight",
        "lineHeightHover"
    ];

    /**
     * Init
     */
    ss.panel.design.text.LineHeight.prototype.init = function () {
        this._setLineHeight();
    };

    /**
     * Sets line-height
     *
     * @returns {ss.panel.design.text.LineHeight}
     *
     * @private
     */
    ss.panel.design.text.LineHeight.prototype._setLineHeight = function () {
        var hoverForm = null;

        if (this._lineHeightHover !== null) {
            hoverForm = new ss.forms.Spinner(
                {
                    value: this._lineHeightHover,
                    appendTo: this._hoverContainer,
                    callback: $.proxy(
                        function (value) {
                            this._lineHeightHover = value;
                            this.update();
                        },
                        this
                    )

                }
            );
        }

        if (this._lineHeight !== null) {
            new ss.forms.Spinner(
                {
                    value: this._lineHeight,
                    css: "line-height",
                    iconBefore: "fa-arrows-v",
                    appendTo: this._commonContainer,
                    callback: $.proxy(
                        function (value) {
                            if (hoverForm !== null
                                && this._lineHeight === this._lineHeightHover
                            ) {
                                this._lineHeightHover = value;
                                hoverForm.getInstance().val(value);
                            }

                            this._lineHeight = value;
                            this.update();
                        },
                        this
                    )
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
    ss.panel.design.text.LineHeight.prototype.generateCss = function (isHover) {
        var lineHeight;

        if (isHover === true) {
            lineHeight = this._lineHeightHover;
        } else {
            lineHeight = this._lineHeight;
        }

        lineHeight = 1.4 + (lineHeight / 100);

        return "line-height:" + lineHeight + ";";
    };
}(window.jQuery, window.ss);
