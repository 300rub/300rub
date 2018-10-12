!function ($, ss) {
    'use strict';

    /**
     * Text font-family
     *
     * @param {Object} options
     *
     * @type {ss.panel.design.text.Family}
     */
    ss.panel.design.text.Family = function (options) {
        this._family = null;

        this._commonContainer = options.commonContainer;

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
    ss.panel.design.text.Family.prototype
        = Object.create(ss.panel.design.AbstractGroup.prototype);

    /**
     * Constructor
     */
    ss.panel.design.text.Family.prototype.constructor
        = ss.panel.design.text.Family;

    /**
     * Fields
     *
     * @type {Array}
     */
    ss.panel.design.text.Family.prototype.fields = [
        "family"
    ];

    /**
     * List of font family types
     *
     * @var {Object}
     */
    ss.panel.design.text.Family.prototype._familyList = {
        0: {
            style: 'font-family: "Open Sans", sans-serif;',
            name: "Open Sans"
        },
        1: {
            style: 'font-family: Arial, Helvetica, sans-serif;',
            name: "Arial, Helvetica"
        },
        2: {
            style: 'font-family: "Arial Black", Gadget, sans-serif;',
            name: "Arial Black, Gadget"
        },
        3 : {
            style: 'font-family: "Comic Sans MS", cursive;',
            name: "Comic Sans MS"
        },
        4: {
            style: 'font-family: "Courier New", Courier, monospace;',
            name: "Courier New"
        },
        5: {
            style: 'font-family: Georgia, serif;',
            name: "Georgia"
        },
        6: {
            style: 'font-family: Impact, Charcoal, sans-serif;',
            name: "Impact, Charcoal"
        },
        7: {
            style: 'font-family: "Lucida Console", Monaco, monospace;',
            name: "Lucida Console, Monaco"
        },
        8: {
            style: 'font-family: "Lucida Sans Unicode", sans-serif;',
            name: "Lucida Sans Unicode"
        },
        9: {
            style: 'font-family: "Palatino Linotype", "Book Antiqua", serif;',
            name: "Palatino"
        },
        10: {
            style: 'font-family: Tahoma, Geneva, sans-serif;',
            name: "Tahoma, Geneva"
        },
        11: {
            style: 'font-family: "Times New Roman", Times, serif;',
            name: "Times New Roman, Times"
        },
        12: {
            style: 'font-family: "Trebuchet MS", Helvetica, sans-serif;',
            name: "Trebuchet MS, Helvetica"
        },
        13: {
            style: 'font-family: Verdana, Geneva, sans-serif;',
            name: "Verdana, Geneva"
        },
        14: {
            style: 'font-family: "MS Sans Serif", Geneva, sans-serif;',
            name: "MS Sans Serif, Geneva"
        },
        15: {
            style: 'font-family: "MS Serif", "New York", serif;',
            name: "MS Serif, New York"
        }
    };

    /**
     * Init
     */
    ss.panel.design.text.Family.prototype.init = function () {
        this._setFamily();
    };

    /**
     * Sets font-family
     *
     * @returns {ss.panel.design.text.Family}
     *
     * @private
     */
    ss.panel.design.text.Family.prototype._setFamily = function () {
        if (this._family === null) {
            return this;
        }

        var list = [];
        $.each(
            this._familyList,
            function (key, data) {
                list.push(
                    {
                        key: key,
                        value: data.name,
                        style: data.style
                    }
                );
            }
        );

        new ss.forms.Select(
            {
                list: list,
                value: this._family,
                css: "family",
                appendTo: this._commonContainer,
                onChange: $.proxy(
                    function (value) {
                        this._family = value;
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
    ss.panel.design.text.Family.prototype.generateCss = function () {
        if (this._familyList[this._family] === undefined) {
            return this._familyList[0].style;
        }

        return this._familyList[this._family].style;
    };
}(window.jQuery, window.ss);
