!function ($, ss) {
    "use strict";

    var name = "adminBlockImageAlbumsSettings";

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
                    group: "image",
                    controller: "album",
                    data: {
                        blockId: this.getOption("blockId"),
                        id: this.getOption("id")
                    },
                    name: "image-albums-settings",
                    parent: "image-content",
                    level: 2
                }
            );
        },

        /**
         * On load success
         */
        onLoadSuccess: function () {
            var seo = ss.init(
                "commonComponentsFormSeo",
                this.getData("forms", {})
            );
            seo.getContainer().appendTo(this.getBody());
            this.forms = $.extend({}, seo.getForms());

            var type = "POST";
            if (this.getData("id", 0) > 0) {
                type = "PUT";
            }

            this.setSubmit(
                {
                    label: this.getLabel("button"),
                    icon: "fas fa-save",
                    ajax: {
                        data: {
                            group: "image",
                            controller: "album",
                            forms: this.forms,
                            data: {
                                blockId: this.getData("blockId")
                            }
                        },
                        type: type,
                        success: $.proxy(this.onSendSuccess, this)
                    }
                }
            );
        },

        /**
         * On send success
         *
         * @param {Object} data
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
