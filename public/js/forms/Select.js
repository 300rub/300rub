!function ($, ss) {
    'use strict';

    /**
     * Select form
     *
     * @param {Object} options
     */
    ss.forms.Select = function (options) {
        ss.forms.Abstract.call(this, "form-container-select", options);
        this.init();
    };

    /**
     * Select form prototype
     *
     * @type {Object}
     */
    ss.forms.Select.prototype
        = Object.create(ss.forms.Abstract.prototype);

    /**
     * Constructor
     */
    ss.forms.Select.prototype.constructor = ss.forms.Select;

    /**
     * Init
     */
    ss.forms.Select.prototype.init = function () {
        var t = this;

        var optionTemplate = t.getForm().find(".option-template");

        var list = t.getOption("list");
        if ($.type(list) === "array") {
            $.each(
                list,
                function (i, object) {
                    var option = optionTemplate.clone()
                    .attr("value", object.key)
                    .text(object.value);

                    if (object.css !== undefined) {
                        option.addClass(object.css);
                    }

                    if (object.style !== undefined) {
                        option.attr("style", object.style);
                    }

                    option.appendTo(t.getInstance());
                }
            );
        }

        optionTemplate.remove();

        t.getInstance().val(t.getOption("value"));

        var onChange = t.getOption("onChange");
        if ($.type(onChange) === "function") {
            t.getInstance().on(
                "change",
                function () {
                    onChange(
                        ss.components.Library.getIntVal($(this).val())
                    );
                }
            );
        }
    };
}(window.jQuery, window.ss);
