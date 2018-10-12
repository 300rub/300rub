!function ($, ss) {
    'use strict';

    /**
     * Text transform
     *
     * @param {Object} options
     *
     * @type {ss.panel.design.text.Transform}
     */
    ss.panel.design.text.Transform = function (options) {
        this._transform = null;
        this._transformHover = null;

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
    ss.panel.design.text.Transform.prototype
        = Object.create(ss.panel.design.AbstractGroup.prototype);

    /**
     * Constructor
     */
    ss.panel.design.text.Transform.prototype.constructor
        = ss.panel.design.text.Transform;

    /**
     * Fields
     *
     * @type {Array}
     */
    ss.panel.design.text.Transform.prototype.fields = [
        "transform",
        "transformHover"
    ];

    /**
     * Text transform list
     *
     * @var {Array}
     */
    ss.panel.design.text.Transform.prototype._transformList = [
        {value: 0, css: "none", label: "-"},
        {value: 1, css: "uppercase", label: "AA"},
        {value: 2, css: "lowercase", label: "aa"},
        {value: 3, css: "capitalize", label: "Aa"}
    ];

    /**
     * Init
     */
    ss.panel.design.text.Transform.prototype.init = function () {
        this._setTransform();
    };

    /**
     * Sets transform
     *
     * @returns {ss.panel.design.text.Transform}
     *
     * @private
     */
    ss.panel.design.text.Transform.prototype._setTransform = function () {
        var hoverForm = null;
        if (this._transformHover !== null) {
            hoverForm = new ss.forms.RadioButtons(
                {
                    value: this._transformHover,
                    data: this._transformList,
                    appendTo: this._hoverContainer,
                    onChange: $.proxy(
                        function (value) {
                            this._transformHover = value;
                            this.update();
                        },
                        this
                    )
                }
            );
        }

        if (this._transform !== null) {
            new ss.forms.RadioButtons(
                {
                    value: this._transform,
                    data: this._transformList,
                    appendTo: this._commonContainer,
                    onChange: $.proxy(
                        function (value) {
                            if (hoverForm !== null
                                && this._transform === this._transformHover
                            ) {
                                this._transformHover = false;
                                hoverForm.getInstance().val(value).change();
                            }

                            this._transform = value;
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
    ss.panel.design.text.Transform.prototype.generateCss = function (isHover) {
        var transform;
        var transformCss;

        if (isHover === true) {
            transform = this._transformHover;
        } else {
            transform = this._transform;
        }

        if (this._transformList[transform] === undefined) {
            transformCss = this._transformList[0].css;
        } else {
            transformCss = this._transformList[transform].css;
        }

        return "text-transform:" + transformCss + ";";
    };
}(window.jQuery, window.ss);
