!function ($, ss) {
    'use strict';

    /**
     * Text decoration
     *
     * @param {Object} options
     *
     * @type {ss.panel.design.text.Decoration}
     */
    ss.panel.design.text.Decoration = function (options) {
        this._decoration = null;
        this._decorationHover = null;

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
    ss.panel.design.text.Decoration.prototype
        = Object.create(ss.panel.design.AbstractGroup.prototype);

    /**
     * Constructor
     */
    ss.panel.design.text.Decoration.prototype.constructor
        = ss.panel.design.text.Decoration;

    /**
     * Fields
     *
     * @type {Array}
     */
    ss.panel.design.text.Decoration.prototype.fields = [
        "decoration",
        "decorationHover"
    ];

    /**
     * Text decoration list
     *
     * @var {Array}
     */
    ss.panel.design.text.Decoration.prototype._decorationList = [
        {value: 0, css: "none", label: "N"},
        {value: 1, css: "underline", label: "U"},
        {value: 2, css: "line-through", label: "T"},
        {value: 3, css: "overline", label: "O"}
    ];

    /**
     * Init
     */
    ss.panel.design.text.Decoration.prototype.init = function () {
        this._setDecoration();
    };

    /**
     * Sets text-decoration
     *
     * @returns {ss.panel.design.text.Decoration}
     *
     * @private
     */
    ss.panel.design.text.Decoration.prototype._setDecoration = function () {
        var hoverForm = null;
        if (this._decorationHover !== null) {
            hoverForm = new ss.forms.RadioButtons(
                {
                    value: this._decorationHover,
                    data: this._decorationList,
                    appendTo: this._hoverContainer,
                    onChange: $.proxy(
                        function (value) {
                            this._decorationHover = value;
                            this.update();
                        },
                        this
                    )
                }
            );
        }

        if (this._decoration !== null) {
            new ss.forms.RadioButtons(
                {
                    value: this._decoration,
                    data: this._decorationList,
                    css: "decoration",
                    appendTo: this._commonContainer,
                    onChange: $.proxy(
                        function (value) {
                            if (hoverForm !== null
                                && this._decoration === this._decorationHover
                            ) {
                                this._decorationHover = false;
                                hoverForm.getInstance().val(value).change();
                            }

                            this._decoration = value;
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
    ss.panel.design.text.Decoration.prototype.generateCss = function (isHover) {
        var decoration;
        var decorationCss;
        if (isHover === true) {
            decoration = this._decorationHover;
        } else {
            decoration = this._decoration;
        }

        if (this._decorationList[decoration] === undefined) {
            decorationCss = this._decorationList[0].css;
        } else {
            decorationCss = this._decorationList[decoration].css;
        }

        return "text-decoration:" + decorationCss + ";";
    };
}(window.jQuery, window.ss);
