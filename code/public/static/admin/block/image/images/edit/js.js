!function ($, ss) {
    "use strict";

    var name = "adminBlockImageImagesEdit";

    var parameters = {
        /**
         * Parent
         *
         * @var {String}
         */
        parent: "commonComponentsWindowAbstract",

        /**
         * Forms
         *
         * @var {Object}
         */
        forms: {},

        /**
         * Init
         */
        init: function () {
            this.create(
                {
                    group: this.getOption("group"),
                    controller: this.getOption("controller"),
                    data: {
                        blockId: this.getOption("blockId"),
                        id: this.getOption("id")
                    },
                    name: "image-edit",
                    parent: this.getOption("parent"),
                    level: this.getOption("level")
                }
            );
        },

        /**
         * On load success
         */
        onLoadSuccess: function () {
            this.setForms();

            this.setSubmit(
                {
                    label: this.getLabel("button"),
                    icon: "fas fa-save",
                    forms: this.forms,
                    ajax: {
                        data: {
                            group: this.getOption("group"),
                            controller: this.getOption("controller"),
                            data: {
                                blockId: parseInt(this.getData("blockId")),
                                id: parseInt(this.getData("id"))
                            }
                        },
                        type: "PUT",
                        success: $.proxy(this.onSendSuccess, this)
                    }
                }
            );
        },

        /**
         * Sets forms
         */
        setForms: function() {
            this.forms = {};

            this.forms.alt = ss.init(
                "commonComponentsFormText",
                $.extend(
                    {},
                    this.getData(["forms", "alt"], {}),
                    {
                        appendTo: this.getBody()
                    }
                )
            );

            this.forms.link = ss.init(
                "commonComponentsFormText",
                $.extend(
                    {},
                    this.getData(["forms", "link"], {}),
                    {
                        appendTo: this.getBody()
                    }
                )
            );

            this.forms.isCover = ss.init(
                "commonComponentsFormCheckbox",
                $.extend(
                    {},
                    this.getData(["forms", "isCover"], {}),
                    {
                        appendTo: this.getBody()
                    }
                )
            );

            return this;
        },

        /**
         * On send success
         *
         * @param {Object} data
         */
        onSendSuccess: function (data) {
            if ($.type(data.errors) === "object") {
                var errors = data.errors;

                if (errors.alt !== undefined) {
                    this.forms.alt
                        .setError(errors.alt)
                        .scrollTo()
                        .focus();
                    return this;
                }

                if (errors.link !== undefined) {
                    this.forms.link
                        .setError(errors.link)
                        .scrollTo()
                        .focus();
                    return this;
                }
            } else {
                this.remove(true);

                ss.init(
                    "commonContentBlockUpdate",
                    {
                        list: [
                            this.getOption("blockId")
                        ]
                    }
                );
            }
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
