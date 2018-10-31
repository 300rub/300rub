!function ($, ss) {
    "use strict";

    var name = "commonUserResetCode";

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
                    controller: "resetCodeForm",
                    name: "reset-code",
                    level: 2,
                    parent: "login"
                }
            );
        },

        /**
         * On load success
         */
        onLoadSuccess: function () {
            this.forms.code = ss.init(
                "commonComponentsFormText",
                $.extend(
                    {},
                    this.getData(["forms", "code"], {}),
                    {
                        appendTo: this.getBody()
                    }
                )
            );

            this.setSubmit(
                {
                    label: this.getLabel("button"),
                    icon: "fas fa-lock",
                    forms: this.forms,
                    ajax: {
                        data: {
                            group: "user",
                            controller: "resetCode",
                            data: {
                                id: this.getOption("id")
                            }
                        },
                        type: "POST",
                        success: $.proxy(this.onSendSuccess, this)
                    }
                }
            );

            this.forms.code.focus();
        },

        /**
         * On send success
         *
         * @param {Object} data
         */
        onSendSuccess: function (data) {
            if ($.type(data.errors) === "object") {
                if (data.errors.code !== undefined) {
                    this.form.code
                        .setError(data.errors.code)
                        .scrollTo()
                        .focus();
                }

                return false;
            }

            window.location.reload();
        }
    };

    ss.add(name, parameters);
}(window.jQuery, window.ss);
