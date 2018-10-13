!function ($, ss) {
    "use strict";

    var name = "adminComponentsDesignTextFamily";

    var parameters = {
        /**
         * Parent
         *
         * @var {String}
         */
        parent: "adminComponentsDesignAbstractGroup",

        /**
         * Font family
         *
         * @var {int|null}
         */
        family: null,

        /**
         * Fields
         *
         * @var {Array}
         */
        fields: [
            "family"
        ],

        /**
         * List of font family types
         *
         * @var {Object}
         */
        familyList: {
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
                style: 'font-family:"Palatino Linotype","Book Antiqua", serif;',
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
        },

        /**
         * Init
         */
        init: function () {
            this.family = null;

            this.create(
                {
                    updateSampleEvent: "update-text-sample"
                }
            );

            this.setFamily();
        },

        /**
         * Sets font-family
         */
        setFamily: function () {
            if (this.family === null) {
                return this;
            }

            var list = [];
            $.each(
                this.familyList,
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

            ss.init(
                "commonComponentsFormSelect",
                {
                    list: list,
                    value: this.family,
                    css: "family",
                    appendTo: this.getOption("commonContainer"),
                    onChange: $.proxy(
                        function (value) {
                            this.family = value;
                            this.update();
                        },
                        this
                    )
                }
            );

            return this;
        },

        /**
         * Generates styles
         *
         * @returns {String}
         */
        generateCss: function () {
            if (this.familyList[this.family] === undefined) {
                return this.familyList[0].style;
            }

            return this.familyList[this.family].style;
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
