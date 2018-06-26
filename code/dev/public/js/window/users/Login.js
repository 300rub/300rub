!function ($, ss) {
    'use strict';

    /**
     * Login window
     *
     * @type {Object}
     */
    ss.window.users.Login = function () {
        ss.window.Abstract.call(
            this,
            {
                group: "user",
                controller: "loginForms",
                success: $.proxy(this._onLoadDataSuccess, this),
                name: "login"
            }
        );

        this._userForm = null;
        this._passwordForm = null;
        this._isRememberForm = null;
    };

    /**
     * Prototype
     *
     * @type {Object}
     */
    ss.window.users.Login.prototype
        = Object.create(ss.window.Abstract.prototype);

    /**
     * Constructor
     */
    ss.window.users.Login.prototype.constructor = ss.window.users.Login;

    /**
     * On load window success
     *
     * @param {Object} [data]
     *
     * @private
     */
    ss.window.users.Login.prototype._onLoadDataSuccess = function (data) {
        this._userForm = new ss.forms.Text(
            $.extend(
                {
                    appendTo: this.getBody()
                },
                data.forms.user
            )
        );

        this._passwordForm = new ss.forms.Password(
            $.extend(
                {
                    appendTo: this.getBody()
                },
                data.forms.password
            )
        );

        this._isRememberForm = new ss.forms.Checkbox(
            $.extend(
                {
                    appendTo: this.getBody()
                },
                data.forms.isRemember
            )
        );

        this
            .setTitle(data.title)
            .setSubmit(
                {
                    label: data.forms.button.label,
                    icon: "fa-lock",
                    forms: [
                        this._userForm,
                        this._passwordForm,
                        this._isRememberForm
                    ],
                    ajax: {
                        data: {
                            group: "user",
                            controller: "session"
                        },
                        type: "POST",
                        success: $.proxy(this._onSendSuccess, this),
                        error: ss.system.App.showError
                    }
                }
            );

        this._userForm.focus();
    };

    /**
     * On send success
     *
     * @param {Object} [data]
     *
     * @private
     */
    ss.window.users.Login.prototype._onSendSuccess = function (data) {
        if ($.type(data.errors) === "object") {
            if (data.errors.user !== undefined) {
                this._userForm
                    .setError(data.errors.user)
                    .scrollTo()
                    .focus();
            } else if (data.errors.password !== undefined) {
                this._passwordForm
                    .setError(data.errors.password)
                    .scrollTo()
                    .focus();
            }
        } else {
            window.location = "/";
        }
    };
}(window.jQuery, window.ss);