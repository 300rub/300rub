!function ($, ss) {
    'use strict';

    /**
     * Text bold
     *
     * @param {Object} options
     *
     * @type {ss.panel.design.text.Bold}
     */
    ss.panel.design.text.Bold = function (options) {
        this._isBold = null;
        this._isBoldHover = null;

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
    ss.panel.design.text.Bold.prototype
        = Object.create(ss.panel.design.AbstractGroup.prototype);

    /**
     * Constructor
     */
    ss.panel.design.text.Bold.prototype.constructor
        = ss.panel.design.text.Bold;

    /**
     * Fields
     *
     * @type {Array}
     */
    ss.panel.design.text.Bold.prototype.fields = [
        "isBold",
        "isBoldHover"
    ];

    /**
     * Init
     */
    ss.panel.design.text.Bold.prototype.init = function () {
        this._setBold();
    };

    /**
     * Sets bold
     *
     * @returns {ss.panel.design.text.Bold}
     *
     * @private
     */
    ss.panel.design.text.Bold.prototype._setBold = function () {
        var hoverForm = null;

        var onCheckHover = $.proxy(
            function () {
                this._isBoldHover = true;
                this.update();
            },
            this
        );
        var onUnCheckHover = $.proxy(
            function () {
                this._isBoldHover = false;
                this.update();
            },
            this
        );

        if (this._isBoldHover !== null) {
            hoverForm = new ss.forms.CheckboxButton(
                {
                    value: this._isBoldHover,
                    icon: "fa-bold",
                    appendTo: this._hoverContainer,
                    onCheck: onCheckHover,
                    onUnCheck: onUnCheckHover
                }
            );
        }

        var onCheck = $.proxy(
            function () {
                if (hoverForm !== null
                    && this._isBold === this._isBoldHover
                ) {
                    hoverForm.getInstance().attr("checked", true);
                    this._isBoldHover = true;
                }

                this._isBold = true;
                this.update();
            },
            this
        );

        var onUnCheck = $.proxy(
            function () {
                if (hoverForm !== null
                    && this._isBold === this._isBoldHover
                ) {
                    hoverForm.getInstance().attr("checked", false);
                    this._isBoldHover = false;
                }

                this._isBold = false;
                this.update();
            },
            this
        );

        if (this._isBold !== null) {
            new ss.forms.CheckboxButton(
                {
                    value: this._isBold,
                    icon: "fa-bold",
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
    ss.panel.design.text.Bold.prototype.generateCss = function (isHover) {
        if (isHover === true) {
            return "font-weight: bold;";
        }

        return "font-weight: normal;";
    };
}(window.jQuery, window.ss);
