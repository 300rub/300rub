!function ($, ss) {
    "use strict";

    var name = "adminBlockTextSettings";

    var parameters = {
        /**
         * Parent
         *
         * @var {String}
         */
        parent: "adminComponentsPanel",

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
            this.forms = {};

            this.create(
                {
                    group: "text",
                    controller: "block",
                    data: {
                        id: this.getOption("blockId", 0)
                    },
                    back: function () {
                        ss.init("adminBlockTextList", {});
                    },
                    hasHeaderButtons: this.getOption("blockId", 0) > 0
                }
            );
        },

        /**
         * On load success
         */
        onLoadSuccess: function () {
            this
                .setForms()
                .setButtons();

            var type = "PUT";
            var icon = "fas fa-save";
            if (this.getData("id", 0) === 0) {
                type = "POST";
                icon = "fas fa-plus";
            }

            this.setSubmit(
                {
                    label: this.getLabel("button"),
                    icon: icon,
                    forms: this.forms,
                    ajax: {
                        data: {
                            group: "text",
                            controller: "block",
                            data: {
                                id: this.getOption("blockId", 0)
                            }
                        },
                        type: type,
                        success: $.proxy(this.onSendSuccess, this)
                    }
                }
            );
        },

        /**
         * Sets forms
         */
        setForms: function () {
            var container
                = ss.init("template").get("text-settings-container");
            container.appendTo(this.getBody());

            this.forms.name = ss.init(
                "commonComponentsFormText",
                $.extend(
                    {},
                    this.getData(["forms", "name"], {}),
                    {
                        appendTo: container
                    }
                )
            );

            this.forms.type = ss.init(
                "commonComponentsFormSelect",
                $.extend(
                    {},
                    this.getData(["forms", "type"], {}),
                    {
                        appendTo: container,
                        type: "int",
                        onChange: function (value) {
                            if (value === 0) {
                                container.removeClass("no-editor");
                            } else {
                                container.addClass("no-editor");
                            }
                        }
                    }
                )
            );

            this.forms.hasEditor = ss.init(
                "commonComponentsFormCheckbox",
                $.extend(
                    {},
                    this.getData(["forms", "hasEditor"], {}),
                    {
                        appendTo: container,
                        css: "editor"
                    }
                )
            );

            if (this.getData(["forms", "type", "value"], 0) !== 0) {
                container.addClass("no-editor");
            }

            return this;
        },

        /**
         * Sets buttons
         */
        setButtons: function () {
            if (this.getOption("blockId", 0) === 0) {
                return this;
            }

            return this
                .addHeaderButton(
                    {
                        label: this.getLabel("duplicate"),
                        icon: "fas fa-clone",
                        css: "btn btn-gray btn-small",
                        ajax: {
                            data: {
                                group: "text",
                                controller: "blockDuplication",
                                data: {
                                    id: this.getOption("blockId", 0)
                                }
                            },
                            type: "POST",
                            success: function (data) {
                                ss.init(
                                    "adminBlockTextSettings",
                                    {
                                        blockId: data.id
                                    }
                                );
                            }
                        }
                    }
                )
                .addHeaderButton(
                    {
                        label: this.getLabel("delete"),
                        icon: "fas fa-trash",
                        css: "btn btn-red btn-small",
                        confirm: {
                            text: this.getLabel("deleteConfirmText"),
                            yes: {
                                label: this.getLabel("delete"),
                                icon: "fas fa-trash"
                            },
                            no: this.getLabel("no")
                        },
                        ajax: {
                            data: {
                                group: "text",
                                controller: "block",
                                data: {
                                    id: this.getOption("blockId", 0)
                                }
                            },
                            type: "DELETE",
                            success: $.proxy(
                                function () {
                                    ss.init("adminBlockTextList", {});
                                    ss.init(
                                        "commonContentBlockDelete",
                                        {
                                            list: [
                                            this.getOption("blockId", 0)
                                            ]
                                        }
                                    );
                                },
                                this
                            )
                        }
                    }
                );
        },

        /**
         * On send success
         *
         * @param {Object} [data]
         */
        onSendSuccess: function (data) {
            if ($.type(data.errors) === "object"
                && data.errors.name !== undefined
            ) {
                this.forms.name
                    .setError(data.errors.name)
                    .scrollTo()
                    .focus();
            } else {
                if (this.getOption("blockId", 0) === 0) {
                    ss.init("app").setIsBlockSection(false);
                } else {
                    ss.init(
                        "commonContentBlockUpdate",
                        {
                            list: [
                                this.getOption("blockId", 0)
                            ]
                        }
                    );
                }

                ss.init("adminBlockTextList", {});
            }
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
