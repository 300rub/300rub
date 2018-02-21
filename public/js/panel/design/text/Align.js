!function ($, ss) {
    'use strict';

    /**
     * Text align
     *
     * @param {Object} options
     *
     * @type {ss.panel.design.text.Align}
     */
    ss.panel.design.text.Align = function (options) {
        this._align = null;

        this._commonContainer = options.commonContainer;

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
    ss.panel.design.text.Align.prototype
        = Object.create(ss.panel.design.AbstractGroup.prototype);

    /**
     * Constructor
     */
    ss.panel.design.text.Align.prototype.constructor
        = ss.panel.design.text.Align;

    /**
     * Fields
     *
     * @type {Array}
     */
    ss.panel.design.text.Align.prototype.fields = [
        "align"
    ];

    /**
     * Align list
     *
     * @var {Array}
     */
    ss.panel.design.text.Align.prototype._alignList = [
        {value: 0, css: "left", icon: "fa-align-left"},
        {value: 1, css: "center", icon: "fa-align-center"},
        {value: 2, css: "right", icon: "fa-align-right"},
        {value: 3, css: "justify", icon: "fa-align-justify"}
    ];

    /**
     * Init
     */
    ss.panel.design.text.Align.prototype.init = function () {
        this._setAlign();
    };

    /**
     * Sets align
     *
     * @returns {ss.panel.design.Text}
     *
     * @private
     */
    ss.panel.design.text.Align.prototype._setAlign = function () {
        if (this._align === null) {
            return this;
        }

        new ss.forms.RadioButtons(
            {
                value: this._align,
                data: this._alignList,
                css: "align",
                appendTo: this._commonContainer,
                onChange: $.proxy(
                    function (value) {
                        this._align = value;
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
     * @returns {String}
     */
    ss.panel.design.text.Align.prototype.generateCss = function () {
        var css = "";
        if (this._alignList[this._align] === undefined) {
            css = this._alignList[0].css;
        } else {
            css = this._alignList[this._align].css;
        }

        return "text-align:" + css + ";";
    };
}(window.jQuery, window.ss);
