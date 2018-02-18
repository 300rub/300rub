!function ($, ss) {
    'use strict';

    /**
     * RadioButtons form
     *
     * @param {Object} options
     */
    ss.forms.RadioButtons = function (options) {
        ss.forms.Abstract.call(this, "form-container-radio-buttons", options);
        this.init();
    };

    /**
     * RadioButtons form prototype
     *
     * @type {Object}
     */
    ss.forms.RadioButtons.prototype
        = Object.create(ss.forms.Abstract.prototype);

    /**
     * Constructor
     */
    ss.forms.RadioButtons.prototype.constructor
        = ss.forms.RadioButtons;

    /**
     * Init
     */
    ss.forms.RadioButtons.prototype.init = function () {
        var dataOption = this.getOption("data");
        if ($.type(dataOption) !== "array") {
            return this;
        }

        var name = this.getOption("name");
        if (name === null) {
            name = "radio" + ss.components.Library.getUniqueId();
        }

        var labelElement = this.getForm().find(".label-text");
        var labelOption = this.getOption("label");
        if (labelOption !== null) {
            labelElement.text(labelOption);
        } else {
            labelElement.remove();
        }

        var radioButtons = this.getForm().find(".radio-buttons");
        var radioButtonItem
            = ss.components.Template.get("radio-button-item");

        var value = this.getOption("value");

        $.each(
            dataOption,
            $.proxy(
                function (i, data) {
                    if ($.type(data) !== "object"
                        || data.value === undefined
                    ) {
                        return false;
                    }

                    var item = radioButtonItem.clone();

                    var icon = item.find(".label-icon");
                    if (data.icon !== undefined) {
                        icon.addClass(data.icon);
                    } else {
                        icon.remove();
                    }

                    var label = item.find(".label");
                    if (data.label !== undefined) {
                        label.text(data.label);
                    } else {
                        label.remove();
                    }

                    if (data.css !== undefined) {
                        item.addClass(data.css);
                    }

                    var formInstance = item.find(".form-instance");
                    formInstance.val(data.value);
                    formInstance.attr("name", name);

                    if ((value === null && i === 0)
                        || value !== null && value === data.value
                    ) {
                        formInstance.attr("checked", true);
                    }

                    radioButtons.append(item);
                },
                this
            )
        );

        var onChange = this.getOption("onChange");
        if ($.type(onChange) === "function") {
            this.getForm().find(".form-instance").on(
                "change",
                function () {
                    onChange($(this).val());
                }
            );
        }

        return this;
    };
}(window.jQuery, window.ss);
