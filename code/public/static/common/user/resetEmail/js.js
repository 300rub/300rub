!function ($, ss) {
    "use strict";

    var name = "commonUserResetEmail";

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
            this.forms = {};

            this.create(
                {
                    group: "user",
                    controller: "resetEmailForm",
                    name: "reset-email",
                    level: 2,
                    parent: "login"
                }
            );
        },

        /**
         * On load success
         */
        onLoadSuccess: function () {
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

            this.setSubmit(
                {
                    label: this.getLabel("button"),
                    icon: "far fa-envelope",
                    forms: this.forms,
                    ajax: {
                        data: {
                            group: "user",
                            controller: "resetEmail"
                        },
                        type: "POST",
                        success: $.proxy(this.onSendSuccess, this)
                    }
                }
            );

            this.forms.email.focus();
        },

        /**
         * On send success
         *
         * @param {Object} data
         */
        onSendSuccess: function (data) {
            if ($.type(data.errors) === "object") {
                if (data.errors.email !== undefined) {
                    this.forms.email
                        .setError(data.errors.email)
                        .scrollTo()
                        .focus();
                }

                return false;
            }

            ss.init("commonUserResetCode", {id: data.id});
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
