/**
 * Radio Buttons
 */
ss.add(
    "commonComponentsFormRadioButtons",
    {
        /**
         * Parent
         *
         * @var {String}
         */
        parent: "commonComponentsFormAbstract",

        /**
         * Parent options
         *
         * @var {Object}
         */
        parentOptions: {
            template: "form-container-radio-buttons"
        },

        /**
         * Init
         */
        init: function() {
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

            var itemContainer = ss.components.Template.get(
                "radio-button-item-container"
            );

            var current = 0;
            var grid = this.getOption("grid");
            if (grid === null) {
                grid = 999;
            }

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

                        itemContainer.append(item);

                        current++;

                        if (current >= grid) {
                            current = 0;
                            radioButtons.append(itemContainer);
                            itemContainer = ss.components.Template.get(
                                "radio-button-item-container"
                            );
                        }
                    },
                    this
                )
            );

            if (current > 0) {
                radioButtons.append(itemContainer);
            }

            this.setInstance();

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
        },

        /**
         * Sets value
         *
         * @param {*} value
         *
         * @returns {*}
         */
        setValue: function (value) {
            this.getInstance().each(function() {
                if (parseInt($(this).attr("value")) === parseInt(value)) {
                    $(this).prop("checked", true);
                    $(this).click();
                } else {
                    $(this).prop("checked", false);
                }
            });

            return this;
        },

        /**
         * Gets value
         *
         * @returns {int}
         */
        getValue: function () {
            var value = 0;

            this.getInstance().each(function() {
                if ($(this).is(":checked") === true) {
                    value = parseInt($(this).attr("value"));
                }
            });

            return value;
        }
    }
);