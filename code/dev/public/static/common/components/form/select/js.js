/**
 * Select form
 */
ss.add(
    "commonComponentsFormSelect",
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
            template: "form-container-select"
        },

        /**
         * Init
         */
        init: function() {
            this.set();

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
        }
    }
);
