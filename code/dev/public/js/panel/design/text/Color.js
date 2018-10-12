!function ($, ss) {
    'use strict';

    /**
     * Text color
     *
     * @param {Object} options
     *
     * @type {ss.panel.design.text.Color}
     */
    ss.panel.design.text.Color = function (options) {
        this._color = null;
        this._colorHover = null;

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
    ss.panel.design.text.Color.prototype
        = Object.create(ss.panel.design.AbstractGroup.prototype);

    /**
     * Constructor
     */
    ss.panel.design.text.Color.prototype.constructor
        = ss.panel.design.text.Color;

    /**
     * Fields
     *
     * @type {Array}
     */
    ss.panel.design.text.Color.prototype.fields = [
        "color",
        "colorHover"
    ];

    /**
     * Init
     */
    ss.panel.design.text.Color.prototype.init = function () {
        this._setColor();
    };

    /**
     * Sets color
     *
     * @returns {ss.panel.design.text.Color}
     *
     * @private
     */
    ss.panel.design.text.Color.prototype._setColor = function () {
        if (this._color !== null) {
            new ss.forms.Color(
                {
                    title: this.getLabel("color"),
                    value: this._color,
                    appendTo: this._commonContainer,
                    callback: $.proxy(
                        function (color) {
                            this._color = color;
                            this.update();
                        },
                        this
                    )
                }
            );
        }

        if (this._colorHover !== null) {
            new ss.forms.Color(
                {
                    title: this.getLabel("color"),
                    value: this._colorHover,
                    appendTo: this._hoverContainer,
                    callback: $.proxy(
                        function (color) {
                            this._colorHover = color;
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
    ss.panel.design.text.Color.prototype.generateCss = function (isHover) {
        if (isHover === true) {
            return "color:" + this._colorHover + ";";
        }

        return "color:" + this._color + ";";
    };
}(window.jQuery, window.ss);
