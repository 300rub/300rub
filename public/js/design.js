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
        }
    };

    $.design = function (id, type, values) {
        return new c.Design(id, type, values);
    };
}(window.jQuery, window.Core);