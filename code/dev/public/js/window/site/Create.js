!function ($, ss) {
    'use strict';

    /**
     * Create window
     *
     * @type {Object}
     */
    ss.window.site.Create = function () {
        ss.window.Abstract.call(
            this,
            {
                group: "site",
                controller: "createForm",
                success: $.proxy(this._onLoadDataSuccess, this),
                name: "create-site"
            }
        );

        this._nameForm = null;
        this._userNameForm = null;
        this._emailForm = null;
        this._userForm = null;
        this._passwordForm = null;
        this._passwordConfirmForm = null;
        this._languageForm = null;
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    ss.window.site.Create.prototype
        = Object.create(ss.window.Abstract.prototype);

    /**
     * Constructor
     */
    ss.window.site.Create.prototype.constructor = ss.window.site.Create;

    /**
     * On load window success
     *
     * @param {Object} [data]
     *
     * @private
     */
    ss.window.site.Create.prototype._onLoadDataSuccess = function (data) {
        this._nameForm = new ss.forms.Text(
            $.extend(
                {},
                data.forms.name,
                {
                    appendTo: this.getBody()
                }
            )
        );

        this._userNameForm = new ss.forms.Text(
            $.extend(
                {},
                data.forms.userName,
                {
                    appendTo: this.getBody()
                }
            )
        );

        this._emailForm = new ss.forms.Text(
            $.extend(
                {},
                data.forms.email,
                {
                    appendTo: this.getBody()
                }
            )
        );

        this._userForm = new ss.forms.Text(
            $.extend(
                {},
                data.forms.user,
                {
                    appendTo: this.getBody()
                }
            )
        );

        this._passwordForm = new ss.forms.Password(
            $.extend(
                {},
                data.forms.password,
                {
                    appendTo: this.getBody()
                }
            )
        );

        this._passwordConfirmForm = new ss.forms.Password(
            $.extend(
                {},
                data.forms.passwordConfirm,
                {
                    appendTo: this.getBody()
                }
            )
        );

        this._languageForm = new ss.forms.Select(
            $.extend(
                {},
                data.forms.language,
                {
                    appendTo: this.getBody()
                }
            )
        );

        this
            .setTitle(data.title)
            .setSubmit(
                {
                    label: data.forms.button.label,
                    icon: "fas fa-plus",
                    forms: [
                        this._nameForm,
                        this._userNameForm,
                        this._emailForm,
                        this._userForm,
                        this._passwordForm,
                        this._passwordConfirmForm,
                        this._languageForm
                    ],
                    ajax: {
                        data: {
                            group: "site",
                            controller: "site"
                        },
                        type: "POST",
                        success: $.proxy(this._onSendSuccess, this)
                    }
                }
            );
    };

    /**
     * On send success
     *
     * @param {Object} [data]
     *
     * @private
     */
    ss.window.site.Create.prototype._onSendSuccess = function (data) {
        if ($.type(data.errors) === "object") {
            if (data.errors.name !== undefined) {
                this._nameForm
                    .setError(data.errors.name)
                    .scrollTo()
                    .focus();

                return false;
            }

            return false;
        }

        if ($.type(data.userErrors) === "object") {
            if (data.userErrors.passwordConfirm !== undefined) {
                this._passwordConfirmForm
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
    };
}(window.jQuery, window.ss);
