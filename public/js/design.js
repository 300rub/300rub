!function ($, c) {
    "use strict";

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

            // radio
            if ($.type(this.values.radio) === "array") {
                $.each(this.values.radio, function (i, options) {
                    this._setRadio(options);
                });
            }

            // checkbox
            if ($.type(this.values.checkbox) === "array") {
                $.each(this.values.checkbox, function (i, options) {
                    this._setCheckbox(options);
                });
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
         * - {string} name
         * - {int}    value
         * - {string} type
         * - {string} checked
         * - {string} unChecked
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
        }
    };

    $.design = function (id, type, values) {
        return new c.Design(id, type, values);
    };
}(window.jQuery, window.Core);