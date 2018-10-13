!function ($, ss) {
    "use strict";

    var name = "siteCreate";

    var parameters = {
        /**
         * Parent
         *
         * @var {String}
         */
        parent: "siteCreate",

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
                    group: "site",
                    controller: "createForm",
                    name: "create-site"
                }
            );
        },

        /**
         * On load success
         */
        onLoadSuccess: function () {
            this.forms.name = ss.init(
                "commonComponentsFormText",
                $.extend(
                    {},
                    this.getData(["forms", "name"], {}),
                    {
                        appendTo: this.getBody()
                    }
                )
            );

            this.forms.userName = ss.init(
                "commonComponentsFormText",
                $.extend(
                    {},
                    this.getData(["forms", "userName"], {}),
                    {
                        appendTo: this.getBody()
                    }
                )
            );

            this.forms.email = ss.init(
                "commonComponentsFormText",
                $.extend(
                    {},
                    this.getData(["forms", "email"], {}),
                    {
                        appendTo: this.getBody()
                    }
                )
            );

            this.forms.user = ss.init(
                "commonComponentsFormText",
                $.extend(
                    {},
                    this.getData(["forms", "user"], {}),
                    {
                        appendTo: this.getBody()
                    }
                )
            );

            this.forms.password = ss.init(
                "commonComponentsFormPassword",
                $.extend(
                    {},
                    this.getData(["forms", "password"], {}),
                    {
                        appendTo: this.getBody()
                    }
                )
            );

            this.forms.passwordConfirm = ss.init(
                "commonComponentsFormPassword",
                $.extend(
                    {},
                    this.getData(["forms", "passwordConfirm"], {}),
                    {
                        appendTo: this.getBody()
                    }
                )
            );

            this.forms.language = ss.init(
                "commonComponentsFormSelect",
                $.extend(
                    {},
                    this.getData(["forms", "language"], {}),
                    {
                        appendTo: this.getBody()
                    }
                )
            );

            this.setSubmit(
                {
                    label: this.getLabel("button"),
                    icon: "fas fa-plus",
                    forms: this.forms,
                    ajax: {
                        data: {
                            group: "site",
                            controller: "site"
                        },
                        type: "POST",
                        success: $.proxy(this.onSendSuccess, this)
                    }
                }
            );

            this.forms.name.focus();
        },

        /**
         * On send success
         *
         * @param {Object} data
         */
        onSendSuccess: function (data) {
            if ($.type(data.errors) === "object") {
                if (data.errors.name !== undefined) {
                    this.forms.name
                        .setError(data.errors.name)
                        .scrollTo()
                        .focus();

                    return false;
                }

                return false;
            }

            if ($.type(data.userErrors) === "object") {
                if (data.userErrors.passwordConfirm !== undefined) {
                    this.forms.passwordConfirm
                        .setError(data.userErrors.passwordConfirm)
                        .scrollTo()
                        .focus();

                    return false;
                }

                return false;
            }

            if (data.url !== undefined) {
                window.location = data.url;
            }
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
