!function ($, c) {
    "use strict";

    /**
     *
     * @param id
     * @param  type
     * @param {Object} values
     * @constructor
     */
    c.Design = function (id, type, values) {
        this.id = id;
        this.type = type;
        this.values = values;
        this.init();
    };

    c.Design.prototype = {
        constructor: c.Design,

        $_editor: null,
        $_object: null,
        _style: "",
        _class: "",

        init: function () {
            this.$_editor = c.$templates.find(".j-design-editor-" + this.type).clone().attr("data-id", this.id);
            this.$_object = $(".j-design-" + this.type + "-" + this.id);
            this._style = this.$_object.attr("style");
            this._class = this.$_object.attr("class");

            // radios
            if ($.type(this.values.radios) === "array") {
                $.each(this.values.radios, $.proxy(function (i, options) {
                    this._setRadio(options);
                }, this));
            }

            // checkboxes
            if ($.type(this.values.checkboxes) === "array") {
                $.each(this.values.checkboxes, $.proxy(function (i, options) {
                    this._setCheckbox(options);
                }, this));
            }

            // font-family
            if ($.type(this.values.fontFamily) === "object") {
                this._setFontFamily(this.values.fontFamily);
            }

            // spinners
            if ($.type(this.values.spinners) === "array") {
                $.each(this.values.spinners, $.proxy(function (i, options) {
                    this._setSpinner(options);
                }, this));
            }

            // colors
            if ($.type(this.values.colors) === "array") {
                $.each(this.values.colors, $.proxy(function (i, options) {
                    this._setColor(options);
                }, this));
            }

            // background-color
            if ($.type(this.values.backgroundColor) === "object") {
                this._setBackgroundColor(this.values.backgroundColor);
            }
        },

        /**
         * Sets radio
         *
         * @param {Object} options:
         * - {String}  [name]
         * - {Integer} [value]
         * - {String}  [cssAttr]
         *
         * @private
         */
        _setRadio: function (options) {
            var id, t = this;
            this.$_editor.find(".j-" + options.type)
                .each(function () {
                    id = $.uniqueId();
                    $(this)
                        .attr("name", options.name)
                        .attr("id", id)
                        .attr("checked", parseInt($(this).attr("value")) === parseInt(options.value))
                        .closest(".j-radio-container").find("label").attr("for", id);
                })
                .on("change", function () {
                    t.$_object.css(options.type, $(this).data("value"));
                });
        },

        /**
         * Sets checkbox
         *
         * @param {Object} options:
         * - {String}  [name]
         * - {Integer} [value]
         * - {String}  [type]
         * - {String}  [checked]
         * - {String}  [unChecked]
         *
         * @private
         */
        _setCheckbox: function (options) {
            var t = this;
            var id = $.uniqueId();

            var $container = this.$_editor.find(".j-" + options.type + "-container");
            var $checkbox = $container.find(".j-checkbox")
                .attr('checked', parseInt(options.value) == 1)
                .attr('id', id);
            var $value = $container.find(".j-value")
                .val(options.value)
                .attr("name", options.name);

            $container.find("label").attr('for', id);

            $checkbox.on("change", function () {
                if ($(this).is(':checked')) {
                    t.$_object.css(options.type, options.checked);
                    $value.val(1);
                } else {
                    t.object.css(options.type, options.unChecked);
                    $value.val(0);
                }
            });
        },

        /**
         * Sets font-family
         *
         * @param {Object} options:
         * - {String}  [name]
         * - {Integer} [value]
         *
         * @private
         */
        _setFontFamily: function (options) {
            var t = this;
            var className;

            this.$_editor.find(".j-font-family")
                .val(options.value)
                .attr("name", options.name)
                .removeClassByMask("l-font-family-*")
                .on("change", function () {
                    className = $(this).find(':selected').attr('class');
                    $(this)
                        .removeClassByMask("l-font-family-*")
                        .addClass(className);
                    t.$_object
                        .removeClassByMask("l-font-family-*")
                        .addClass(className);
                })
                .change();
        },

        /**
         * Sets spinner
         *
         * @param {Object} options:
         * - {String}  [name]
         * - {Integer} [value]
         * - {String}  [type]
         * - {Integer} [minValue]
         * - {String}  [measure]
         *
         * @private
         */
        _setSpinner: function (options) {
            var t = this;
            var id = $.uniqueId();
            var $container = this.$_editor.find(".j-" + options.type + "-container");

            $container.find("label").attr('for', id);
            $container.find("span").text(options.measure);

            $container.find("input")
                .val(options.value)
                .attr("name", options.name)
                .attr("id", id)
                .forceNumericOnly()
                .spinner({
                    min: options.minValue,
                    spin: function (event, ui) {
                        t.$_object.css(options.type, ui.value + options.measure);
                    }
                })
                .on("keyup", function () {
                    t.$_object.css(options.type, $(this).val() + options.measure);
                });
        },

        /**
         * Set color picker
         *
         * @param {Object} options:
         * - {String}  [name]
         * - {Integer} [value]
         * - {String}  [type]
         *
         * @private
         */
        _setColor: function (options) {
            this.$_editor.find(".j-" + options.type)
                .attr("name", options.name)
                .val(options.value)
                .colorpicker({
                    alpha: true,
                    colorFormat: 'RGBA',
                    buttonColorize: true,
                    showOn: 'both',
                    //buttonImage: '/img/common/color_picker_btn.png',
                    buttonImageOnly: true,
                    position: {
                        my: 'center',
                        at: 'center',
                        of: window
                    },
                    parts: 'full',
                    select: $.proxy(function (event, color) {
                        this.$_object.css(options.type, color.formatted);
                    }, this)
                });
        },

        /**
         * Sets background color
         *
         * @param {Object} options:
         * - {String}  [fromName]
         * - {String}  [fromValue]
         * - {String}  [toName]
         * - {String}  [toValue]
         * - {String}  [gradientName]
         * - {Integer} [gradientValue]
         *
         * @private
         */
        _setBackgroundColor: function (options) {
            var t = this;
            var id;
            var value = "to right";
            var $from = this.$_editor.find(".j-background-from")
                .attr("name", options.fromName)
                .val(options.fromValue);
            var $to = this.$_editor.find(".j-background-to")
                .attr("name", options.toName)
                .val(options.toValue);

            this.$_editor.find(".j-gradient-direction")
                .each(function () {
                    id = $.uniqueId();
                    $(this)
                        .attr("name", options.gradientName)
                        .attr("id", id)
                        .attr("checked", $(this).attr("value") === parseInt(options.gradientValue))
                        .closest(".j-radio-container").find("label").attr("for", id);
                })
                .on("change", function () {
                    value = $(this).data("value");
                    if ($from.val() !== "" && $to.val() !== "") {
                        t.$_object.css(
                            "background",
                            "linear-gradient(" + value + ", " + $from.val() + " 0%, " + $to.val() + " 100%)"
                        );
                    }
                });

            this.$_editor.find(".j-background-clear").on("click", function () {
                $from.val("");
                $to.val("");
                t.$_editor.find('.j-gradient-direction[value="0"]').prop('checked', true);
                t.$_object.css("background", "none");
                value = "to right";

                return false;
            });

            $from.colorpicker({
                alpha: true,
                colorFormat: 'RGBA',
                buttonColorize: true,
                showOn: 'both',
                //buttonImage: '/img/common/color_picker_btn.png',
                buttonImageOnly: true,
                position: {
                    my: 'center',
                    at: 'center',
                    of: window
                },
                parts: 'full',
                select: function (event, color) {
                    if ($to.val() === "") {
                        t.$_object.css("background", color.formatted);
                    } else {
                        t.$_object.css(
                            "background",
                            "linear-gradient(" + value + ", " + color.formatted + " 0%, " + $to.val() + " 100%)")
                        ;
                    }
                }
            });

            $to.colorpicker({
                alpha: true,
                colorFormat: 'RGBA',
                buttonColorize: true,
                showOn: 'both',
                //buttonImage: '/img/common/color_picker_btn.png',
                buttonImageOnly: true,
                position: {
                    my: 'center',
                    at: 'center',
                    of: window
                },
                parts: 'full',
                select: function (event, color) {
                    if ($from.val() === "") {
                        t.$_object.css("background", color.formatted);
                    } else {
                        t.$_object.css(
                            "background",
                            "linear-gradient(" + value + ", " + $from.val() + " 0%, " + color.formatted + " 100%)"
                        );
                    }
                }
            });
        }
    };

    $.design = function (id, type, values) {
        return new c.Design(id, type, values);
    };
}(window.jQuery, window.Core);