!function ($, ss) {
    "use strict";

    var name = "adminSectionSettings";

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
            this.container = null;
            this.forms = {};

            this.create(
                {
                    group: "section",
                    controller: "section",
                    data: {
                        id: this.getOption("sectionId", 0)
                    },
                    back: function () {
                        ss.init("adminSectionList");
                    }
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
            if (this.getData("id") === 0) {
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
                            group: "section",
                            controller: "section",
                            data: {
                                id: this.getOption("sectionId", 0)
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
            var seo = ss.init(
                "commonComponentsFormSeo",
                this.getData("forms", {})
            );
            seo.getContainer().appendTo(this.getBody());
            this.forms = $.extend({}, seo.getForms());

            if (this.getData(["forms", "isMain", "value"]) !== true) {
                this.forms.isMain = ss.init(
                    "commonComponentsFormCheckbox",
                    $.extend(
                        {},
                        this.getData(["forms", "isMain"], {}),
                        {
                            appendTo: this.getBody()
                        }
                    )
                );
            }

            this.forms.isPublished = ss.init(
                "commonComponentsFormCheckbox",
                $.extend(
                    {},
                    this.getData(["forms", "isPublished"], {}),
                    {
                        appendTo: this.getBody()
                    }
                )
            );

            return this;
        },

        /**
         * Sets buttons
         */
        setButtons: function () {
            if (this.getOption("sectionId", 0) === 0) {
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
                                group: "section",
                                controller: "sectionDuplication",
                                data: {
                                    id: this.getOption("sectionId", 0)
                                }
                            },
                            type: "POST",
                            success: function (data) {
                                ss.init(
                                    "adminSectionSettings",
                                    {
                                        sectionId: data.id
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
                                group: "section",
                                controller: "section",
                                data: {
                                    id: this.getOption("sectionId", 0)
                                }
                            },
                            type: "DELETE",
                            success: function () {
                                ss.init("adminSectionList");
                            }
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
                && $.type(data.errors.seoModel) === "object"
            ) {
                var errors = data.errors.seoModel;

                if (errors.name !== undefined) {
                    this.forms.name
                        .setError(errors.name)
                        .scrollTo()
                        .focus();
                    return this;
                }

                if (errors.alias !== undefined) {
                    this.forms.alias
                        .setError(errors.alias)
                        .scrollTo()
                        .focus();
                    return this;
                }

                if (errors.title !== undefined) {
                    this.forms.title
                        .setError(errors.title)
                        .scrollTo()
                        .focus();
                    return this;
                }

                if (errors.keywords !== undefined) {
                    this.forms.keywords
                        .setError(errors.keywords)
                        .scrollTo()
                        .focus();
                    return this;
                }

                if (errors.description !== undefined) {
                    this.forms.description
                        .setError(errors.description)
                        .scrollTo()
                        .focus();
                    return this;
                }
            } else {
                ss.init("adminSectionList");

                if (data.sectionId !== undefined) {
                    ss.init(
                        "adminSectionStructure",
                        {
                            sectionId: data.sectionId
                        }
                    );
                }

                if (data.dependentBlockIds !== undefined) {
                    ss.init(
                        "commonContentBlockUpdate",
                        {
                            list: data.dependentBlockIds
                        }
                    );
                }
            }
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
