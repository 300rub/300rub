!function ($, ss) {
    'use strict';

    /**
     * Text size
     *
     * @param {Object} options
     *
     * @type {ss.panel.design.text.Size}
     */
    ss.panel.design.text.Size = function (options) {
        this._size = null;
        this._sizeHover = null;

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
    ss.panel.design.text.Size.prototype
        = Object.create(ss.panel.design.AbstractGroup.prototype);

    /**
     * Constructor
     */
    ss.panel.design.text.Size.prototype.constructor
        = ss.panel.design.text.Size;

    /**
     * Fields
     *
     * @type {Array}
     */
    ss.panel.design.text.Size.prototype.fields = [
        "size",
        "sizeHover"
    ];

    /**
     * Init
     */
    ss.panel.design.text.Size.prototype.init = function () {
        this._setSize();
    };

    /**
     * Sets size
     *
     * @returns {ss.panel.design.text.Size}
     *
     * @private
     */
    ss.panel.design.text.Size.prototype._setSize = function () {
        if (this._size === null) {
            return this;
        }

        var sizeHover = null;

        if (this._sizeHover !== null) {
            sizeHover = new ss.forms.Spinner(
                {
                    value: this._sizeHover,
                    css: "size-hover",
                    min: 0,
                    appendTo: this._hoverContainer,
                    callback: $.proxy(
                        function (value) {
                            this._sizeHover = value;
                            this.update();
                        },
                        this
                    )
                }
            );
        }

        new ss.forms.Spinner(
            {
                value: this._size,
                css: "size",
                min: 0,
                appendTo: this._commonContainer,
                callback: $.proxy(
                    function (value) {
                        if (this._size === this._sizeHover
                            && sizeHover !== null
                        ) {
                            this._sizeHover = value;
                            sizeHover.setValue(value);
                        }

                        this._size = value;
                        this.update();
                    },
                    this
                )
            }
        );

        return this;
    };

    /**
     * Generates styles
     *
     * @param {boolean} isHover
     *
     * @returns {String}
     */
    ss.panel.design.text.Size.prototype.generateCss = function (isHover) {
        if (isHover === true) {
            return "font-size:" + this._sizeHover + "px;";
        }

        return "font-size:" + this._size + "px;";
    };
}(window.jQuery, window.ss);
