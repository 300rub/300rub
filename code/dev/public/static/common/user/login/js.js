ss.add(
    "commonUserLogin",
    {
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
        init: function() {
            this.forms = {};

            this.create(
                {
                    group: "user",
                    controller: "loginForms",
                    name: "login"
                }
            );
        },

        /**
         * On load success
         */
        onLoadSuccess: function() {
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

            var isRememberForm = ss.init(
                "commonComponentsFormCheckbox",
                $.extend(
                    {},
                    this.getData(["forms", "isRemember"], {}),
                    {
                        appendTo: this.getBody()
                    }
                )
            );

            ss.init(
                "commonComponentsFormLink",
                {
                    css: "form-container block gray-red-link",
                    label: this.getLabel("forgotPassword"),
                    appendTo: this.getBody(),
                    onClick: function () {
                        ss.init("commonUserResetEmail");
                    }
                }
            );

            this.setSubmit(
                {
                    label: this.getLabel("button"),
                    icon: "fas fa-lock",
                    forms: [
                        this.forms.user,
                        this.forms.password,
                        isRememberForm
                    ],
                    ajax: {
                        data: {
                            group: "user",
                            controller: "session"
                        },
                        type: "POST",
                        success: $.proxy(this.onSendSuccess, this)
                    }
                }
            );

            this.forms.user.focus();
        },

        /**
         * On send success
         *
         * @param {Object} data
         */
        onSendSuccess: function (data) {
            if ($.type(data.errors) === "object") {
                if (data.errors.user !== undefined) {
                    this.forms.user
                        .setError(data.errors.user)
                        .scrollTo()
                        .focus();
                } else if (data.errors.password !== undefined) {
                    this.forms.password
                        .setError(data.errors.password)
                        .scrollTo()
                        .focus();
                }
            } else {
                window.location = "/" + data.languageAlias;
            }
        }
    }
);
