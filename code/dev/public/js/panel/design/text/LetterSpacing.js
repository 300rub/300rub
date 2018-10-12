!function ($, ss) {
    'use strict';

    /**
     * Text letter-spacing
     *
     * @param {Object} options
     *
     * @type {ss.panel.design.text.LetterSpacing}
     */
    ss.panel.design.text.LetterSpacing = function (options) {
        this._letterSpacing = null;
        this._letterSpacingHover = null;

        this._commonContainer = options.commonContainer;
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
    ss.panel.design.text.LetterSpacing.prototype
        = Object.create(ss.panel.design.AbstractGroup.prototype);

    /**
     * Constructor
     */
    ss.panel.design.text.LetterSpacing.prototype.constructor
        = ss.panel.design.text.LetterSpacing;

    /**
     * Fields
     *
     * @type {Array}
     */
    ss.panel.design.text.LetterSpacing.prototype.fields = [
        "letterSpacing",
        "letterSpacingHover"
    ];

    /**
     * Init
     */
    ss.panel.design.text.LetterSpacing.prototype.init = function () {
        this._setLetterSpacing();
    };

    /**
     * Sets letter-spacing
     *
     * @returns {ss.panel.design.text.LetterSpacing}
     *
     * @private
     */
    ss.panel.design.text.LetterSpacing.prototype._setLetterSpacing = function (
    ) {
        var hoverForm = null;

        if (this._letterSpacingHover !== null) {
            hoverForm = new ss.forms.Spinner(
                {
                    value: this._letterSpacingHover,
                    appendTo: this._hoverContainer,
                    callback: $.proxy(
                        function (value) {
                            this._letterSpacingHover = value;
                            this.update();
                        },
                        this
                    )
                }
            );
        }

        if (this._letterSpacing !== null) {
            new ss.forms.Spinner(
                {
                    value: this._letterSpacing,
                    css: "letter-spacing",
                    iconBefore: "fa-arrows-h",
                    appendTo: this._commonContainer,
                    callback: $.proxy(
                        function (value) {
                            var hover = this._letterSpacingHover;
                            if (hoverForm !== null
                                && this._letterSpacing === hover
                            ) {
                                this._letterSpacingHover = value;
                                hoverForm.getInstance().val(value);
                            }

                            this._letterSpacing = value;
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
    ss.panel.design.text.LetterSpacing.prototype.generateCss = function (
        isHover
    ) {
        if (isHover === true) {
            return "letter-spacing:" + this._letterSpacingHover + "px;";
        }

        return "letter-spacing:" + this._letterSpacing + "px;";
    };
}(window.jQuery, window.ss);
